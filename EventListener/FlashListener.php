<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\EventListener;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Translation\TranslatorInterface;

class FlashListener implements EventSubscriberInterface
{
    private static $successMessages = array(
        'asbo_whoswho.phone.create_succeed' => 'Le numéro de téléphone a bien été ajouté !',
    );

    private $session;
    private $translator;

    public function __construct(Session $session, TranslatorInterface $translator)
    {
        $this->session = $session;
        $this->translator = $translator;
    }

    public static function getSubscribedEvents()
    {
        return array(
            'asbo_whoswho.phone.create_succeed' => 'addSuccessFlash',
        );
    }

    public function addSuccessFlash(Event $event)
    {
        if (!isset(self::$successMessages[$event->getName()])) {
            throw new \InvalidArgumentException('This event does not correspond to a known flash message');
        }

        $this->session->getFlashBag()->add('success', $this->trans(self::$successMessages[$event->getName()]));
    }

    private function trans($message, array $params = array())
    {
        return $this->translator->trans($message, $params, 'AsboWhosWhoBundle');
    }
}