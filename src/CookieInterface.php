<?php

namespace PHPCraft\Cookie;

interface CookieInterface
{
    public function set($name, $value);
    
    public function get($name);
}