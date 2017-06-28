<?php
/**
 * Created by PhpStorm.
 * User: SunSon (mav@twinscom.ru)
 * Date: 14.06.2017
 * Time: 15:32
 */

namespace CanapeCrmApi\models;


use CanapeCrmApi\exception\ValidationException;


/**
 * Class NewDeal
 * @package CanapeCrmApi\models
 */
class NewDeal extends AbstractModel {


    /**
     * @var array
     */
    protected $fields = [
        'domain' => null,
        'deal_content' => null,
        'contact_client' => null,
        'contact_email' => null,
        'contact_phone' => null,
    ];


    /**
     * @param $domain
     * @return $this
     */
    public function setDomain( $domain ) {
        $this->fields['domain'] = $domain;
        return $this;
    }


    /**
     * @param $date
     * @return $this
     */
    public function setDate( $date ) {
        $this->fields['date'] = $date;
        return $this;
    }


    /**
     * @param $title
     * @return $this
     */
    public function setDealTitle( $title ) {
        $this->fields['deal_title'] = $title;
        return $this;
    }


    /**
     * @param $id
     * @return $this
     */
    public function setEventId( $id ) {
        $this->fields['event_id'] = $id;
        return $this;
    }


    /**
     * @param $text
     * @return $this
     */
    public function setDealContent( $text ) {
        $this->fields['deal_content'] = $text;
        return $this;
    }


    /**
     * @param $name
     * @return $this
     */
    public function setContactClient( $name ) {
        $this->fields['contact_client'] = $name;
        return $this;
    }


    /**
     * @param $email
     * @return $this
     */
    public function setContactEmail( $email ) {
        $this->fields['contact_email'] = $email;
        return $this;
    }


    /**
     * @param $phone
     * @return $this
     */
    public function setContactPhone( $phone ) {
        $this->fields['contact_phone'] = $phone;
        return $this;
    }


    /**
     * @param $mobile
     * @return $this
     */
    public function setContactMobile( $mobile ) {
        $this->fields['contact_mobile'] = $mobile;
        return $this;
    }

    /**
     * @param $code
     * @return $this
     */
    public function setCanapeUuid( $code ) {
        $this->fields['_canapeuuid'] = $code;
        return $this;
    }

    /**
     * @param Catalog $catalog
     * @return $this
     */
    public function addCatalogItem( Catalog $catalog ) {

        $this->fields['items'][] = $catalog;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function validate() {

        if ( !(
            $this->fields['domain'] and $this->fields['deal_content'] and (
                $this->fields['contact_client'] or $this->fields['contact_email'] or $this->fields['contact_phone']
            )
        ) )
            throw new ValidationException( 'New Deal validation error: required "domain" and "deal_content" and ( "contact_client" or "contact_email" or "contact_phone" )' );

        return true;
    }
}