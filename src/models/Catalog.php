<?php
/**
 * Created by PhpStorm.
 * User: SunSon (mav@twinscom.ru)
 * Date: 14.06.2017
 * Time: 16:18
 */

namespace CanapeCrmApi\models;


use CanapeCrmApi\exception\ValidationException;


class Catalog extends AbstractModel {

    protected $fields = [
        'index' => null,
        'title' => null,
        'price' => null,
    ];

    /**
     * @param $index
     * @return $this
     */
    public function setIndex( $index ) {

        $this->fields['index'] = $index;
        return $this;
    }

    /**
     * @param $title
     * @return $this
     */
    public function setTitle( $title ) {

        $this->fields['title'] = $title;
        return $this;
    }

    /**
     * @param $count
     * @return $this
     */
    public function setCount( $count ) {

        $this->fields['count'] = $count;
        return $this;
    }

    /**
     * @param $price
     * @return $this
     */
    public function setPrice( $price ) {

        $this->fields['price'] = $price;
        return $this;
    }

    /**
     * @param $units
     * @return $this
     */
    public function setUnits( $units ) {

        $this->fields['units'] = $units;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function validate() {

        if ( !( $this->fields['index'] or ( $this->fields['title'] and $this->fields['price'] ) ) )
            throw new ValidationException( 'Catalog validation error: required "index" or "title" and "price"' );

        return true;
    }
}