<?php
/**
 * Created by PhpStorm.
 * User: SunSon (mav@twinscom.ru)
 * Date: 14.06.2017
 * Time: 16:07
 */

namespace CanapeCrmApi\models;


use CanapeCrmApi\exception\ValidationException;


/**
 * Class AbstractModel
 * @package CanapeCrmApi\models
 */
abstract class AbstractModel {


    /**
     * @var
     */
    protected $fields;


    /**
     * @return array
     */
    public function getPostFields() {

        $this->validate();

        return $this->prepareFields( $this->fields );
    }


    /**
     * @param array $data
     * @return array
     */
    public function prepareFields( array $data ) {

        foreach ( $data as $field => $value ) {

            if ( is_array( $value ) )
                $data[ $field ] = $this->prepareFields( $value );

            if ( is_int( $field ) and is_subclass_of( $value, 'CanapeCrmApi\models\AbstractModel' ) )
                /** @var AbstractModel $value */
                $data[ $field ] = $value->getPostFields();
        }

        return $data;
    }

    /**
     * @throws ValidationException
     * @return bool
     */
    abstract public function validate();
}