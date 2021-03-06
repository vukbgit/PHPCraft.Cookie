<?php

namespace PHPCraft\Cookie;

use Psr\Http\Message\RequestInterface, Psr\Http\Message\ResponseInterface, Dflydev\FigCookies\FigResponseCookies, Dflydev\FigCookies\FigRequestCookies, Dflydev\FigCookies\SetCookie;;

/**
 * Manages cookies using Http class by Patrick Louys (https://github.com/PatrickLouys/http)
 *
 * @author vuk <info@vuk.bg.it>
 */
class DflydevFigCookiesAdapter implements CookieInterface
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
        if($life) {
            $date = new \DateTime();
            $date->add(new \DateInterval('PT' . $life . 'S'));
        } else {
            $date = null;
        }
        $this->httpResponse = FigResponseCookies::set($this->httpResponse, SetCookie::create($name)
            ->withPath($this->path)
            ->withValue($value)
            ->withExpires($date)
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
        //try from request
        $cookie = FigRequestCookies::get($this->httpRequest, $name, $defaultValue)->getValue();
        if($cookie) {
            return $cookie;
        } else {
        //try from response, for cookie set during curernt script lifetime
            return $cookie = FigResponseCookies::get($this->httpResponse, $name, $defaultValue)->getValue();
        }
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