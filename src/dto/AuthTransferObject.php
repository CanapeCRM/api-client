<?php
/**
 * Created by PhpStorm.
 * User: SunSon (mav@twinscom.ru)
 * Date: 21.06.2017
 * Time: 11:57
 */

namespace CanapeCrmApi\dto;


/**
 * Class AuthTransferObject
 * @method AuthTransferObject setDomain( string $domain )
 * @method AuthTransferObject setAccessKey( string $key )
 * @package CanapeCrmApi\dto
 */
class AuthTransferObject extends AbstractTransferObject {


    /**
     * @var string|null
     */
    public $domain    = null;


    /**
     * @var string|null
     */
    public $accessKey = null;

}