<?php

namespace manrog\components\network\curl;

use manrog\components\network\curl\exceptions\CurlNotFoundException;

/**
 * Interface UrlRequestInterface
 *
 * Preform a single reuqest over curl
 *
 * @package manrog\components\network\curl
 */
interface UrlRequestInterface
{
    /**
     * set the curl object for performing
     *
     * @param CurlInterface|null $curl curl object for performing
     *
     * @return UrlRequestInterface returns self for chain calls
     */
    public function setCurl(CurlInterface $curl = null): UrlRequestInterface;

    /**
     * return the curls object or throw curl CurlNotFoundException;
     *
     * @return CurlInterface
     * @throws CurlNotFoundException
     */
    public function getCurl() : CurlInterface;

    /**
     * set url for request
     *
     * @param string $url url for request
     *
     * @return $this|\manrog\components\network\curl\UrlRequestInterface
     */
    public function setUrl($url = null) : UrlRequestInterface;

    /**
     * returns the url for request
     *
     * @return string|null
     */
    public function getUrl() : string;

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
    public function execute() : UrlRequestInterface;

    /**
     * returns content of request
     *
     * @return mixed returns content by default, CURLOPT_RETURNTRANSFER is 1 by default
     */
    public function getContent();

    /**
     * returns error from last request
     *
     * @return string returns error message
     */
    public function getError();

    /**
     * returns errorcode from last request
     *
     * @return int returns error code
     */
    public function getErrno();

    /**
     * add a curl option for request
     *
     * @param int|mixed $option CURL option constant
     * @param mixed     $value  the value for the option
     *
     * @return \manrog\components\network\curl\UrlRequestInterface
     */
    public function addCurlOption($option, $value) : UrlRequestInterface;

    /**
     * removes a existing option from request
     *
     * @param int $option
     *
     * @return \manrog\components\network\curl\UrlRequestInterface
     */
    public function removeCurlOption($option) : UrlRequestInterface;

    /**
     * clean options from request
     *
     * @return \manrog\components\network\curl\UrlRequestInterface
     */
    public function cleanCurlOptions() : UrlRequestInterface;
}
