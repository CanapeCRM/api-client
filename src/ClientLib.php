<?php
/**
 * Created by PhpStorm.
 * User: SunSon (mav@twinscom.ru)
 * Date: 07.06.2017
 * Time: 11:57
 */

namespace CanapeCrmApi;

use CanapeCrmApi\dto\AuthTransferObject;
use CanapeCrmApi\dto\Response;
use CanapeCrmApi\models\NewDeal;
use CanapeCrmApi\service\RestService;


/**
 * Class ClientLib
 * @package CanapeCrmApi
 */
class ClientLib {


    /**
     * @var RestService|null
     */
    private $restService = null;


    /**
     * ClientLib constructor.
     * @param $domain
     * @param $accessKey
     */
    function __construct( $domain, $accessKey ) {

        $this->restService = new RestService(
            ( new AuthTransferObject() )->setDomain( $domain )->setAccessKey( $accessKey )
        );
    }


    /**
     * @return $this
     */
    public function disallowSSL() {

        $this->restService->disallowSSL();
        return $this;
    }


    /**
     * @param NewDeal $oNewDeal
     * @return Response
     */
    public function createDeal( NewDeal $oNewDeal ) {

        return $this->restService->createDeal( $oNewDeal );
    }


    /**
     * @return Response
     */
    public function getDealTypes() {

        return $this->restService->getDealTypes();
    }

    /**
     * @return Response
     */
    public function getEvents() {

        return $this->restService->getEvents();
    }

    /**
     * @param Response $response
     * @return Response
     */
    public function getNextPage( Response $response ) {

        return $this->restService->getNextPage( $response );
    }

    /**
     * @param Response $response
     * @return bool
     */
    public function hasNextPage( Response $response ) {

        return $this->restService->hasNextPage( $response );
    }
}