<?php

namespace PHPCraft\Cookie;

/**
 * Manages cookies
 *
 * @author vuk <info@vuk.bg.it>
 */
interface CookieInterface
{
    /**
     * Sets cookie
     *
     * @param string $name
     * @param mixed $value
     * @param integer $life of the cookie inb seconds
     * @return Psr\Http\Message\ResponseInterface object modified by cookie addition
     **/
    public function set($name, $value, $life = null);
    
    /**
     * Gets cookie
     *
     * @param string $name
     * @param mixed $defaultValue to return in case cookie is not set
     **/
    public function get($name, $defaultValue = false);
    
    /**
     * Deletes cookie
     *
     * @param string $name
     **/
    public function delete($name);
}