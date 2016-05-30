<?php

namespace PHPCraft\Cookie;

use Psr\Http\Message\RequestInterface, Psr\Http\Message\ResponseInterface, Dflydev\FigCookies\FigResponseCookies, Dflydev\FigCookies\FigRequestCookies, Dflydev\FigCookies\SetCookie;;

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
     * @return Psr\Http\Message\ResponseInterface object modified by cookie addition
     **/
    public function set($name, $value, $life = null)
    {
        return FigResponseCookies::set($this->httpResponse, SetCookie::create($name)
            ->withValue($value)
            ->withExpires($life)
        );
    }
    
    /**
     * Gets cookie
     *
     * @param string $name
     * @param mixed $defaultValue to return in case cookie is not set
     * @return mixed cookie value if any or default value
     **/
    public function get($name, $defaultValue = false)
    {
        return $cookie = FigRequestCookies::get($this->httpRequest, $name, $defaultValue)->getValue();
    }
    
    /**
     * Deletes cookie
     *
     * @param string $name
     * @return Psr\Http\Message\ResponseInterface object modified by cookie deletion
     **/
    public function delete($name)
    {
        $this->httpResponse = FigResponseCookies::remove($this->httpResponse, $name);
        return FigResponseCookies::expire($this->httpResponse, $name);
    }
}