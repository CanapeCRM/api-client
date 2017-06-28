<?php
/**
 * Created by PhpStorm.
 * User: SunSon (mav@twinscom.ru)
 * Date: 21.06.2017
 * Time: 11:48
 */

namespace CanapeCrmApi\service;


use CanapeCrmApi\dto\AuthTransferObject;
use CanapeCrmApi\dto\Response;
use CanapeCrmApi\models\NewDeal;
use CanapeCrmApi\repository\CanapeCrmRepository;


/**
 * Class RestService
 * @package CanapeCrmApi\service
 */
class RestService {

    /**
     * @var CanapeCrmRepository
     */
    private $repository;


    /**
     * RestService constructor.
     * @param AuthTransferObject $oAuth
     */
    function __construct( AuthTransferObject $oAuth ) {

        $this->repository = new CanapeCrmRepository( $oAuth );
    }

    /**
     * @return $this
     */
    public function disallowSSL() {

        $this->repository->setSSLVerify( false );

        return $this;
    }

    /**
     * @param NewDeal $oNewDeal
     * @return mixed
     */
    public function createDeal( NewDeal $oNewDeal ) {

        return $this->repository->postOrder( $oNewDeal );
    }


    /**
     * @return mixed
     */
    public function getDealTypes() {

        return $this->repository->getDealType();
    }


    /**
     * @return mixed
     */
    public function getEvents() {

        return $this->repository->getEvent();
    }

    /**
     * @param Response $response
     * @return bool|Response
     */
    public function getNextPage( Response $response ) {

        return $this->repository->getNextPage( $response );
    }

    /**
     * @param Response $response
     * @return bool
     */
    public function hasNextPage( Response $response ) {

        return (bool)$this->repository->hasNextPage( $response );
    }
}