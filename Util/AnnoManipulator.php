<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\Util;

use \DateTime as DateTime;

/**
 * Executes some manipulations on the annos of ASBO
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class AnnoManipulator
{
    /**
     * Date of fondation of ASBO
     */
    const FONDATION_DATE = '15-04-1987';

    /**
     * End of the anno 0
     */
    const END_ANNO_0 = '01-09-1987';

    /**
     * Stores the available annos choices
     *
     * @var array
     */
    private static $annos;

    /**
     * Returns the anno choices
     *
     * The choices are generated from the current date,
     * the fondation date and the end of the first year.
     * They are cached during a single resquest, so multiple anno
     * fields on the same page don't lead to unecessary overhead.
     *
     * @return array The anno choices
     */
    public static function getAnnos()
    {
        if (null === static::$annos) {
            static::$annos = range(0, intval((new DateTime())->diff(self::getFondationDate())->format('%y')) + 1);
        }

        return static::$annos;
    }

    /**
     * Returns the current anno
     *
     * @return integer The current anno
     */
    public static function getCurrentAnno()
    {
        $annos = self::getAnnos();

        return end($annos);
    }

    /**
     * Returns the anno corresponding to the date
     *
     * @param \DateTime|string $date
     *
     * @throws \InvalidArgumentException
     * @return integer                   The anno
     */
    public static function getAnnoByDate($date)
    {
        if (!$date instanceof \Datetime) {
            $date = new DateTime($date);
        }

        if ($date < self::getFondationDate()) {
            throw new \InvalidArgumentException(sprintf('The date must be upper than %s.', self::getFondationDate()->format('d-m-Y')));
        } elseif ($date > new DateTime()) {
            throw new \InvalidArgumentException(sprintf('The date must be lower than today'));
        } elseif ($date < new DateTime(self::END_ANNO_0)) {
            return 0;
        }

        return (int) $date->diff(self::getFondationDate())->format('%y') + 1;
    }

    /**
     * Get the date that corresponding to anno
     *
     * @param integer $anno
     *
     * @throws \InvalidArgumentException
     * @return \Datetime
     */
    public static function getDateByAnno($anno)
    {
        if (!self::isValid($anno)) {
            throw new \InvalidArgumentException(sprintf('The anno must be valid. %d given.', $anno));
        }

        return self::getFondationDate()->add(new \DateInterval(sprintf('P%dY', $anno)));
    }

    /**
     * Return an array with the interval of anno
     *
     * @param integer $anno
     *
     * @throws \InvalidArgumentException
     * @return array(\DateTime)
     */
    public static function getDateIntervalByAnno($anno)
    {
        if (!self::isValid($anno)) {
            throw new \InvalidArgumentException(sprintf('The anno must be valid. %d given.', $anno));
        }

        $date1 = self::getFondationDate();
        $date2 = new DateTime(self::END_ANNO_0);

        if ($anno > 0) {
            $date1->add(new \DateInterval(sprintf('P%dY', $anno)));
            $date2 = clone $date1;
            $date2->add(new \DateInterval('P1Y'))->sub(new \DateInterval('P1D'));
        }

        return array($date1, $date2);
    }

    /**
     * Return true if the annos exists
     *
     * @param  integer $anno
     * @return boolean
     */
    public static function isValid($anno)
    {
        $annos = self::getAnnos();

        return isset($annos[$anno]);
    }

    /**
     * Return object with fondation date
     *
     * @return DateTime
     */
    public static function getFondationDate()
    {
        return new DateTime(self::FONDATION_DATE);
    }
}
