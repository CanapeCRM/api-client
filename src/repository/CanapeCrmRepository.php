<?php
/**
 * Created by PhpStorm.
 * User: SunSon (mav@twinscom.ru)
 * Date: 21.06.2017
 * Time: 11:54
 */

namespace CanapeCrmApi\repository;


use CanapeCrmApi\dto\AuthTransferObject;
use CanapeCrmApi\dto\Response;
use CanapeCrmApi\exception\CanapeCrmClientException;
use CanapeCrmApi\exception\ForbiddenException;
use CanapeCrmApi\exception\UnauthorizedException;
use CanapeCrmApi\models\AbstractModel;
use CanapeCrmApi\models\NewDeal;
use GuzzleHttp;
use GuzzleHttp\Exception\ClientException;


/**
 * Class CanapeCrmRepository
 * @package CanapeCrmApi\repository
 */
class CanapeCrmRepository {


    /** The header name with items count in CRM response */
    const PAGINATION_ITEMS   = 'x_pagination_total_count';


    /** The header name with pages count in CRM response */
    const PAGINATION_PAGES   = 'x_pagination_page_count';


    /** The header name with current page  number in CRM response */
    const PAGINATION_PAGE    = 'x_pagination_current_page';


    /** The header name with "on page" items count in CRM response */
    const PAGINATION_ON_PAGE = 'x_pagination_per_page';

    /**
     * @var string
     */
    const PROTOCOL = 'https://';


    /**
     * @var null|string
     */
    private $domain    = null;


    /**
     * @var null
     */
    private $accessKey = null;


    /**
     * @var bool
     */
    private $sslVerify = true;


    /**
     * CanapeCrmRepository constructor.
     * @param AuthTransferObject $oAuth
     */
    public function __construct( AuthTransferObject $oAuth ) {

        $this->domain = trim( preg_replace( '/^(https?:)?/i', '', $oAuth->domain ), '/' );
        $this->accessKey = $oAuth->accessKey;
    }

    /**
     * Disable verifying ssl certificate host and peer (use only for development with self-signed certificates)
     * @param bool $value
     */
    public function setSSLVerify( $value ) {

        $this->sslVerify = $value;
    }


    /**
     * Request headers array
     * @return array
     */
    private function buildHeaders() {

        $headers = [
            'access-token' => $this->accessKey,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];

        return $headers;
    }


    /**
     * Prepares future request client
     * @param $url
     * @return GuzzleHttp\Client
     */
    private function buildClient( $url ) {

        $oClient = new GuzzleHttp\Client( [
            'base_url' => self::PROTOCOL . $this->domain . $url,
            'defaults' => [
                'headers' => $this->buildHeaders(),
            ],
        ] );
        if ( !$this->sslVerify )
            $oClient->setDefaultOption( 'verify', false );

        return $oClient;
    }


    /**
     * @param $url
     * @param AbstractModel $oModel
     * @param array $query
     * @return Response
     * @throws CanapeCrmClientException
     * @throws ForbiddenException
     * @throws UnauthorizedException
     */
    public function executePost( $url, AbstractModel $oModel, array $query = [] ) {

        $client = $this->buildClient( $url );

        try {

            $options = [
                'body' => json_encode( $oModel->getPostFields() )
            ];
            if ( $query ) $options['query'] = $query;

            /** @var GuzzleHttp\Message\Response $response */
            $response = $client->post( null, $options );

        } catch ( ClientException $exception ) {

            $result = $exception->getResponse();
            $code = $result->getStatusCode();
            $message = $result->getReasonPhrase();

            $crmMessage = $result->json();
            if ( isset( $crmMessage['message'] ) and $crmMessage['message'] )
                $message .= " ({$crmMessage['message']})";

            if ( $code === 403 ) {
                throw new ForbiddenException($message);
            }

            if ( $code === 401 ) {
                throw new UnauthorizedException($message);
            }

            throw new CanapeCrmClientException(
                'Service responded with error code: "' . $code . '" and message: "' . $message . '"'
            );
        }

        return new Response( $response, $client );
    }

    /**
     * @param $url
     * @param array $query
     * @return Response
     * @throws CanapeCrmClientException
     * @throws ForbiddenException
     * @throws UnauthorizedException
     */
    public function executeGet( $url, array $query = [] ) {

        $client = $this->buildClient( $url );

        try {
            /** @var GuzzleHttp\Message\Response $response */
            $response = $client->get( null, $query ? [ 'query' => $query ] : [] );

        } catch ( ClientException $ex ) {

            $result = $ex->getResponse();
            $code = $result->getStatusCode();
            $message = $result->getReasonPhrase();

            if ( $code === 403 ) {
                throw new ForbiddenException($message);
            }

            if ( $code === 401 ) {
                throw new UnauthorizedException($message);
            }

            throw new CanapeCrmClientException(
                'Service responded with error code: "' . $code . '" and message: "' . $message . '"'
            );
        }

        return new Response( $response, $client );
    }


    /**
     * @param NewDeal $oNewDeal
     * @return Response
     */
    public function postOrder( NewDeal $oNewDeal ) {

        return $this->executePost( '/v1/order', $oNewDeal );
    }

    /**
     * @return Response
     */
    public function getDealType() {

        return $this->executeGet( '/v1/deal-type' );
    }

    /**
     * @return Response
     */
    public function getEvent() {

        return $this->executeGet( '/v1/event' );
    }

    /**
     * @param Response $response
     * @return Response|bool
     */
    public function getNextPage( Response $response ) {

        $page = $this->hasNextPage( $response );

        return !$page ? : $this->executeGet(
            parse_url( $response->getGuzzleResponse()->getEffectiveUrl(), PHP_URL_PATH ),
            [ 'page' => $page, ]
        );
    }

    /**
     * @param Response $response
     * @return array|bool|mixed|string
     */
    public function hasNextPage( Response $response ) {

        $page = $response->getGuzzleResponse()->getHeader( self::PAGINATION_PAGE );
        $pages = $response->getGuzzleResponse()->getHeader( self::PAGINATION_PAGES );

        return ( 0 < $page and $page < $pages ) ? ++$page : false;
    }

}