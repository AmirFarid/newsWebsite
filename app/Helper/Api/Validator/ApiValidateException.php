<?php
/**
 * Created by PhpStorm.
 * User: amin
 * Date: 5/10/20
 * Time: 8:29 PM
 */

namespace App\Helper\Api\Validator;


class ApiValidateException extends \Exception
{
    protected $code = 422;
}
