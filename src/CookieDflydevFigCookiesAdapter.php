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
    private $path;

    /**
     * Constructor.
     *
     * @param Http\Request $httpRequest
     * @param Http\Response $httpResponse
     * @param Http\CookieBuilder $cookie
     **/
    public function __construct(RequestInterface &$httpRequest, ResponseInterface &$httpResponse)
    {
        $this->httpRequest =& $httpRequest;
        $this->httpResponse =& $httpResponse;
        $this->path = '/';
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
        $this->httpResponse = FigResponseCookies::set($this->httpResponse, SetCookie::create($name)
            ->withPath($this->path)
            ->withValue($value)
            ->withExpires($life)
        );
    }
    
    /**
     * Sets cookie path
     *
     * @param string $path
     **/
    public function setPath($path)
    {
        $this->path = $path;
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
     **/
    public function delete($name)
    {
        $this->httpResponse = FigResponseCookies::remove($this->httpResponse, $name);
        //set cookie to expire 1 second after Unix Epoch
        $this->set($name, '', 1);
    }
}