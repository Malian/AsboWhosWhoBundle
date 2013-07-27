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
use Asbo\WhosWhoBundle\AsboWhosWhoEvents;

class FlashListener implements EventSubscriberInterface
{
    /**
     * @var \Symfony\Component\HttpFoundation\Session\Session $session
     */
    private $session;

    /**
     * @var \Symfony\Component\Translation\TranslatorInterface $translator
     */
    private $translator;

    /**
     * @var array $successMessages
     */
    private static $successMessages;

    /**
     * @var array $subscribedEvents;
     */
    private static $subscribedEvents;

    /**
     * Constructor.
     *
     * @param Session             $session
     * @param TranslatorInterface $translator
     */
    public function __construct(Session $session, TranslatorInterface $translator)
    {
        $this->session = $session;
        $this->translator = $translator;
    }

    /**
     * {@inerithdoc}
     */
    public static function getSubscribedEvents()
    {
        if (null === self::$subscribedEvents) {
            foreach (array('Create', 'Edit', 'Delete') as $action) {

                $call = sprintf('get%sCompleted', $action);

                foreach (array('phone') as $resource) {
                    self::$subscribedEvents[AsboWhosWhoEvents::$call($resource)] =  'addSuccessFlash';
                }
            }
        }

        return self::$subscribedEvents;
    }

    /**
     * Returns an array with success messages
     *
     * @return array
     */
    public static function getSuccessMessages()
    {
        if (null === self::$successMessages) {
            foreach (self::getSubscribedEvents() as $name => $function) {
                self::$successMessages[$name] = ltrim(str_replace('asbo_whoswho', '', $name), '.');
            }
        }

        return self::$successMessages;
    }

    /**
     * Function that listens for the event
     *
     * @param  Event                     $event
     * @throws \InvalidArgumentException
     */
    public function addSuccessFlash(Event $event)
    {
        if (!isset(self::getSuccessMessages()[$event->getName()])) {
            throw new \InvalidArgumentException('This event does not correspond to a known flash message');
        }

        $this->session->getFlashBag()->add('success', $this->trans(self::getSuccessMessages()[$event->getName()]));
    }

    /**
     * Translate the message with AsboWhosWhoBundle namespace
     *
     * @param  string $message
     * @param  array  $params
     * @return string
     */
    private function trans($message, array $params = array())
    {
        return $this->translator->trans($message, $params, 'AsboWhosWhoBundle');
    }
}
