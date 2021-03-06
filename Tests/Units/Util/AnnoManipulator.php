<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\Tests\Units\Util;

use Asbo\WhosWhoBundle\Util\AnnoManipulator as AnnoManipulatorTested;
use Asbo\WhosWhoBundle\Tests\Units;

class AnnoManipulator extends Units\Test
{

    public function testGetFondationDate()
    {
        $array = explode('-', AnnoManipulatorTested::FONDATION_DATE);

        $this->datetime(AnnoManipulatorTested::getFondationDate())->hasDate($array[2], $array[1], $array[0]);
    }

    public function testIsValid()
    {
        $annos = AnnoManipulatorTested::getAnnos();

        foreach ($annos as $anno) {
            $this->boolean(AnnoManipulatorTested::isValid($anno));
        }

    }

    public function testCurrentAnno()
    {
        $annos   = AnnoManipulatorTested::getAnnos();
        $current = AnnoManipulatorTested::getCurrentAnno();

        $this->integer($current)->isEqualTo(end($annos));
    }

    public function testGetAnno()
    {
        $this->array((new AnnoManipulatorTested)->getAnnos())->isNotEmpty();
    }

    public function testGetDateByAnno()
    {
        $annos = AnnoManipulatorTested::getAnnos();

        foreach ($annos as $anno) {
            $date = (new \Datetime(AnnoManipulatorTested::FONDATION_DATE))->add(new \DateInterval('P'.$anno.'Y'));
            $this->datetime(AnnoManipulatorTested::getDateByAnno($anno))->isEqualTo($date);
        }
    }

    public function testGetDateByInvalidAnno()
    {
        $this->exception(
            function () {
                $annos = AnnoManipulatorTested::getAnnos();
                AnnoManipulatorTested::getDateByAnno(end($annos) + 1);
            }
        )->isInstanceOf('\InvalidArgumentException');
    }

    public function testGetDateIntervalByValidAnno()
    {
        foreach (AnnoManipulatorTested::getAnnos() as $anno) {

            if (0 == $anno) {
                continue;
            }

            $date1 = (new \DateTime(AnnoManipulatorTested::FONDATION_DATE))->add(new \DateInterval('P'.$anno.'Y'));
            $date2 = clone $date1;
            $date2->add(new \DateInterval('P1Y'))->sub(new \DateInterval('P1D'));

            $array = AnnoManipulatorTested::getDateIntervalByAnno($anno);
            $this->array($array)->hasSize(2)->containsValues(array($date1, $date2));
            $this->boolean($array[0] < $array[1])->isTrue();
        }

        $fondation = new \DateTime(AnnoManipulatorTested::FONDATION_DATE);
        $endAnno0  = new \DateTime(AnnoManipulatorTested::END_ANNO_0);

        $this->array(AnnoManipulatorTested::getDateIntervalByAnno(0))->containsValues(array($fondation, $endAnno0));
    }

    /**
     * @dataProvider invalidIntervalAnno
     */
    public function testGetDateIntervalByInvalidAnno($anno)
    {
        $this->exception(
            function () use ($anno) {
                AnnoManipulatorTested::getDateIntervalByAnno($anno);
            }
        )->isInstanceOf('\InvalidArgumentException');
    }

    /**
     * @dataProvider validAnnos
     */
    public function testGetAnnoByValidDate($date, $validValue)
    {
        $this->integer((new AnnoManipulatorTested)->getAnnoByDate($date))->isEqualTo($validValue);
    }

    /**
     * @dataProvider invalidAnnos
     */
    public function testGetAnnoByInvalidDate($invalid)
    {
        $this->exception(
            function () use ($invalid) {
                AnnoManipulatorTested::getAnnoByDate($invalid);
            }
        )->isInstanceOf('\InvalidArgumentException');
    }

    protected function invalidAnnos()
    {
        return array(
            $this->faker->datetimeBetween('-30 years', AnnoManipulatorTested::FONDATION_DATE),
            $this->faker->datetimeBetween('now', '+10 years'),
            $this->faker->datetimeBetween('now', '+1 day')
        );
    }

    protected function validAnnos()
    {
        $annos = (new AnnoManipulatorTested)->getAnnos();

        return array(
            array(new \Datetime('now'), end($annos)),
            array(new \Datetime(AnnoManipulatorTested::FONDATION_DATE), 0),
            array($this->faker->datetimeBetween(AnnoManipulatorTested::FONDATION_DATE, AnnoManipulatorTested::END_ANNO_0), 0),
            array((new \Datetime(AnnoManipulatorTested::END_ANNO_0))->sub(new \DateInterval('P1D')), 0),
            array((new \Datetime(AnnoManipulatorTested::END_ANNO_0))->add(new \DateInterval('P1D')), 1),
            array(new \Datetime('16-04-2013'), 27),
            array('16-04-2013', 27)
        );
    }

    protected function invalidIntervalAnno()
    {
        $annos = (new AnnoManipulatorTested)->getAnnos();

        return array(
            end($annos) + 1,
            reset($annos) - 1,
        );
    }
}
