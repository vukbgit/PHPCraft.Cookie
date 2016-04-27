<?php

namespace PHPCraft\Cookie;

use Http\Request, Http\Response, Http\CookieBuilder;

/**
 * Manages cookies using Http class by Patrick Louys (https://github.com/PatrickLouys/http)
 *
 * @author vuk <info@vuk.bg.it>
 */
class CookieBuilderPatrickLouysHttp implements CookieBuilderInterface
{
    private $cookieBuilder;
    private $httpRequest;
    private $httpResponse;

    /**
     * Constructor.
     *
     * @param Http\Request $httpRequest
     * @param Http\Response $httpResponse
     * @param Http\CookieBuilder $cookieBuilder
     **/
    public function __construct(Request $httpRequest, Response $httpResponse, CookieBuilder $cookieBuilder)
    {
        $this->cookieBuilder = $cookieBuilder;
        $this->cookieBuilder->setDefaultSecure(false);
        $this->httpRequest = $httpRequest;
        $this->httpResponse = $httpResponse;
    }

    /**
     * Sets cookie
     *
     * @param string $name
     * @param mixed $value
     * @param integer $life of the cookie in seconds
     **/
    public function set($name, $value, $life = null)
    {
        $cookie = $this->cookieBuilder->build($name, $value);
        if($life){
            $cookie->setMaxAge($life);
        }
        $this->httpResponse->addCookie($cookie);
    }
    
    /**
     * Gets cookie
     *
     * @param string $name
     * @param mixed $defaultValue to return in case cookie is not set
     **/
    public function get($name, $defaultValue = false)
    {
        return $this->httpRequest->getCookie($name, $defaultValue);
    }
    
    /**
     * Deletes cookie
     *
     * @param string $name
     **/
    public function delete($name)
    {
        $cookie = $this->cookieBuilder->build($name,'');
        $this->httpResponse->deleteCookie($cookie);
    }
}