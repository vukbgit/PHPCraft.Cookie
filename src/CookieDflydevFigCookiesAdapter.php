<?php

namespace PHPCraft\Cookie;

use Psr\Http\Message\RequestInterface, Psr\Http\Message\ResponseInterface, Dflydev\FigCookies\FigResponseCookies, Dflydev\FigCookies\FigRequestCookies;

/**
 * Manages cookies using Http class by Patrick Louys (https://github.com/PatrickLouys/http)
 *
 * @author vuk <info@vuk.bg.it>
 */
class CookieDflydevFigCookiesAdapter implements CookieInterface
{
    private $httpRequest;
    private $httpResponse;

    /**
     * Constructor.
     *
     * @param Http\Request $httpRequest
     * @param Http\Response $httpResponse
     * @param Http\CookieBuilder $cookie
     **/
    public function __construct(RequestInterface $httpRequest, ResponseInterface $httpResponse)
    {
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
        FigResponseCookies::set($this->httpResponse, SetCookie::create($name)
            ->withValue($value)
            ->withExpires($life)
        );
    }
    
    /**
     * Gets cookie
     *
     * @param string $name
     * @param mixed $defaultValue to return in case cookie is not set
     **/
    public function get($name, $defaultValue = false)
    {
        return $cookie = FigRequestCookies::get($this->httpRequest, $name, $defaultValue);
    }
    
    /**
     * Deletes cookie
     *
     * @param string $name
     **/
    public function delete($name)
    {
        FigResponseCookies::remove($this->httpResponse, $name);
    }
}