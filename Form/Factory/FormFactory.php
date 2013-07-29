<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\Form\Factory;

use Symfony\Component\Form\FormFactoryInterface;

class FormFactory
{
    /**
     * @var FormFactoryInterface $formFactory
     */
    private $formFactory;

    /**
     * @var string $name
     */
    private $name;

    /**
     * @var string $type
     */
    private $type;

    /**
     * Constructor.
     *
     * @param FormFactoryInterface $formFactory
     * @param string               $name
     * @param string               $type
     */
    public function __construct(FormFactoryInterface $formFactory, $name, $type)
    {
        $this->formFactory      = $formFactory;
        $this->name             = $name;
        $this->type             = $type;
    }

    /**
     * Create the form
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createForm()
    {
        return $this->formFactory->createNamed(
            $this->name,
            $this->type
        );
    }
}
