<?php
/**
 * Created by PhpStorm.
 * User: SunSon (mav@twinscom.ru)
 * Date: 22.06.2017
 * Time: 10:11
 */

namespace CanapeCrmApi\dto;


use GuzzleHttp\Client;


/**
 * Class Response
 * @package CanapeCrmApi\dto
 */
class Response {


    /**
     * @var \GuzzleHttp\Message\Response
     */
    private $guzzleResponse;


    /**
     * @var Client
     */
    private $guzzleRequest;


    /**
     * Response constructor.
     * @param \GuzzleHttp\Message\Response $response
     * @param Client $request
     */
    public function __construct( \GuzzleHttp\Message\Response $response, Client $request ) {

        $this->guzzleResponse = $response;
        $this->guzzleRequest = $request;
    }

    /**
     * @return mixed
     */
    public function json() {

        return $this->guzzleResponse->json();
    }

    /**
     * @return string
     */
    public function plain() {

        return $this->guzzleResponse->getBody()->getContents();
    }

    /**
     * @return array
     */
    public function headers() {

        return $this->guzzleResponse->getHeaders();
    }

    /**
     * @return \GuzzleHttp\Message\Response
     */
    public function getGuzzleResponse() {

        return $this->guzzleResponse;
    }

    /**
     * @return Client
     */
    public function getGuzzleRequest() {

        return $this->guzzleRequest;
    }
}