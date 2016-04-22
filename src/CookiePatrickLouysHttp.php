<?php

namespace PHPCraft\Cookie;

use Http\Request, Http\Response, Http\CookieBuilder;

class CookiePatrickLouysHttp implements CookieInterface
{
    private $cookieBuilder;
    private $httpRequest;
    private $httpResponse;

    public function __construct(Request $httpRequest, Response $httpResponse, CookieBuilder $cookieBuilder)
    {
        $this->cookieBuilder = $cookieBuilder;
        $this->httpRequest = $httpRequest;
        $this->httpResponse = $httpResponse;
    }

    public function set($name, $value)
    {
        $cookie = $this->cookieBuilder->build($name, $value);
        $this->httpResponse->addCookie($cookie);
    }
    
    public function get($name, $defaultValue = false)
    {
        $this->httpRequest->getCookie($name, $defaultValue);
    }
}