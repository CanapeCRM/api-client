<?php
/**
 * Created by PhpStorm.
 * User: SunSon (mav@twinscom.ru)
 * Date: 21.06.2017
 * Time: 11:58
 */

namespace CanapeCrmApi\dto;


use CanapeCrmApi\exception\CanapeCrmClientException;


/**
 * Class AbstractTransferObject
 * @package CanapeCrmApi\dto
 */
class AbstractTransferObject {


    /**
     * AbstractTransferObject constructor.
     * @param array $data
     */
    public function __construct( array $data = [] ) {

        foreach ( $data as $property => $value )
            if ( property_exists( $this, $property ) )
                $this->$property = $value;
    }


    /**
     * @param $name
     * @param $arguments
     * @return $this
     * @throws CanapeCrmClientException
     */
    function __call( $name, $arguments ) {

        $property = lcfirst( substr( $name, 3 ) );

        if ( !property_exists( $this, $property ) ) throw new CanapeCrmClientException( "Setting unknown property" );

        if ( count( $arguments ) !== 1 ) throw new CanapeCrmClientException( "Method " . $name . " accepts only one argument" );

        $this->$property = array_shift( $arguments );

        return $this;
    }


}