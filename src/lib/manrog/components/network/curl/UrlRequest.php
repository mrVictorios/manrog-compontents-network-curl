<?php

namespace manrog\components\network\curl;

use manrog\components\network\curl\exceptions\CurlNotFoundException;

/**
 * Class UrlRequest
 *
 * Preform a single request over curl
 *
 * @package manrog\components\network\curl
 */
class UrlRequest implements UrlRequestInterface
{
    /** @var CurlInterface cURL object */
    private $curl = null;
    /** @var resource curlHandle */
    private $ch = null;
    /** @var string url */
    private $url = null;
    /** @var mixed response content */
    private $content = null;
    /** @var array performing options */
    private $options = array();

    /**
     * UrlRequest constructor.
     *
     * arguments can be used for a comfortable initialize.
     *
     * @param null|string   $url  url for request
     * @param CurlInterface $curl curl object for performing
     */
    public function __construct($url = null, CurlInterface $curl = null)
    {
        $this->setCurl($curl);
        $this->setUrl($url);
    }

    /**
     * set the curl object for performing
     *
     * @param CurlInterface|null $curl curl object for performing
     *
     * @return UrlRequestInterface returns self for chain calls
     */
    public function setCurl(CurlInterface $curl = null): UrlRequestInterface
    {
        $this->curl = $curl;

        return $this;
    }

    /**
     * return the curls object or throw curl CurlNotFoundException;
     *
     * @return CurlInterface
     * @throws CurlNotFoundException
     */
    public function getCurl(): CurlInterface
    {
        if (is_null($this->curl)) {
            throw new CurlNotFoundException('missing cURL object');
        }

        return $this->curl;
    }

    /**
     * set url for request
     *
     * @param string $url url for request
     *
     * @return $this|\manrog\components\network\curl\UrlRequestInterface
     */
    public function setUrl($url = null): UrlRequestInterface
    {
        if (!is_string($url) && isset($url)) {
            throw new \InvalidArgumentException('argument must be a string');
        }

        $this->url = $url;

        return $this;
    }

    /**
     * returns the url for request
     *
     * @return string|null
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * performs the request, and returns it self, the returned content will be store in the content variable to get it,
     * call getContent()
     *
     * Example:
     *
     * ...
     * if($request->execute()->getErno() == 0) {
     *  $content = $request->getContent();
     * }
     * ...
     *
     * CURLOPT_RETURNTRANSFER is 1 by default
     *
     * @return \manrog\components\network\curl\UrlRequestInterface
     */
    public function execute(): UrlRequestInterface
    {
        $this->ch = $this->getCurl()->init($this->url); // be shore curl object is present before configure

        if (!empty($this->options)) {
            foreach ($this->options as $option => $value) {
                $this->curl->setopt($this->ch, $option, $value);
            }
        } else {
            $this->curl->setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        }

        $this->content = $this->curl->exec($this->ch);

        $this->curl->close($this->ch);

        return $this;
    }

    /**
     * returns content of request
     *
     * @return mixed returns content by default, CURLOPT_RETURNTRANSFER is 1 by default
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * returns error from last request
     *
     * @return string returns error message
     */
    public function getError()
    {
        if (is_null($this->ch)) {
            return '';
        }

        return $this->curl->error($this->ch);
    }

    /**
     * returns errorcode from last request
     *
     * @return int returns error code
     */
    public function getErrno()
    {
        if (is_null($this->ch)) {
            return 0;
        }

        return $this->curl->errno($this->ch);
    }

    /**
     * add a curl option for request
     *
     * @param int|mixed $option CURL option constant
     * @param mixed     $value  the value for the option
     *
     * @return \manrog\components\network\curl\UrlRequestInterface
     */
    public function addCurlOption($option, $value): UrlRequestInterface
    {
        $this->options[$option] = $value; // use doublequot to get safe stores ass assoc array and not as numeric

        return $this;
    }

    /**
     * removes a existing option from request
     *
     * @param int $option
     *
     * @return \manrog\components\network\curl\UrlRequestInterface
     */
    public function removeCurlOption($option): UrlRequestInterface
    {
        unset($this->options[$option]);

        return $this;
    }

    /**
     * clean options from request
     *
     * @return \manrog\components\network\curl\UrlRequestInterface
     */
    public function cleanCurlOptions(): UrlRequestInterface
    {
        $this->options = array();

        return $this;
    }
}
