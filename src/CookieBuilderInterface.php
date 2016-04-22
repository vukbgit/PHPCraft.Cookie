<?php

namespace PHPCraft\Cookie;

interface CookieBuilderInterface
{
    public function set($name, $value);
    
    public function get($name);
}