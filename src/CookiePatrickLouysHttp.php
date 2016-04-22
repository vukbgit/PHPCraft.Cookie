<?php

namespace PHPCraft\Cookie;

class CookiePatrickLouysHttp implements CookieInterface
{
    private $cookieBuilder;
    private $httpRequest;
    private $httpResponse;

    public function __construct(Http\CookieBuilder $cookieBuilder, Http\Request $httpRequest, Http\Response $httpResponse)
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