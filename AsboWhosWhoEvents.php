<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle;

/**
 * Contains all events thrown in the AsboWhosWhoBundle
 */
final class AsboWhosWhoEvents
{
    /**
     * Generic events
     */
    const GENERIC_CREATE_INITIALIZE =  'create.initialize';
    const GENERIC_CREATE_COMPLETED = 'create.completed';
    const GENERIC_CREATE_SUCCESS = 'create.success';
    const GENERIC_EDIT_INITIALIZE =  'edit.initialize';
    const GENERIC_EDIT_SUCCESS = 'edit.success';
    const GENERIC_EDIT_COMPLETED = 'edit.completed';
    const GENERIC_DELETE_COMPLETED = 'delete.completed';

    /**
     * Returns the name of the event to use when creating the resource
     *
     * @param  string $resource
     * @return string
     */
    public static function getCreateInitialize($resource)
    {
        return self::get($resource, self::GENERIC_CREATE_INITIALIZE);
    }

    /**
     * Returns the name of the event to use when the resource are create with success.
     *
     * @param  string $resource
     * @return string
     */
    public static function getCreateSuccess($resource)
    {
        return self::get($resource, self::GENERIC_CREATE_SUCCESS);
    }

    /**
     * Returns the name of the event to use when processing the resource is complete.
     *
     * @param  string $resource
     * @return string
     */
    public static function getCreateCompleted($resource)
    {
        return self::get($resource, self::GENERIC_CREATE_COMPLETED);
    }

    /**
     * Returns the name of the event to use when editing the resource
     *
     * @param  string $resource
     * @return string
     */
    public static function getEditInitialize($resource)
    {
        return self::get($resource, self::GENERIC_EDIT_INITIALIZE);
    }

    /**
     * Returns the name of the event to use when the resource are edit with success.
     *
     * @param  string $resource
     * @return string
     */
    public static function getEditSuccess($resource)
    {
        return self::get($resource, self::GENERIC_EDIT_SUCCESS);
    }

    /**
     * Returns the name of the event to use when editing the resource is complete.
     *
     * @param  string $resource
     * @return string
     */
    public static function getEditCompleted($resource)
    {
        return self::get($resource, self::GENERIC_EDIT_COMPLETED);
    }

    /**
     * Returns the name of the event to use when deleting the resource is complete.
     *
     * @param  string $resource
     * @return string
     */
    public static function getDeleteCompleted($resource)
    {
        return self::get($resource, self::GENERIC_DELETE_COMPLETED);
    }

    /**
     * Format the event name
     *
     * @param  string $resource
     * @param  string $event
     * @return string
     */
    private static function get($resource, $event)
    {
        return sprintf('asbo_whoswho.%s.%s', $resource, $event);
    }
}
