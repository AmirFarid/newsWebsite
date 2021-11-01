<?php
/**
 * Created by PhpStorm.
 * User: amin
 * Date: 5/10/20
 * Time: 8:25 PM
 */

namespace App\Helper\Api\Validator;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiValidator
{
    /**
     * @param Request $request
     * @param $input
     * @throws ApiValidateException
     */
    public static function validate(Request $request, $input)
    {
        $validator = Validator::make($request->all(), $input);

        if ($validator->fails()) {
            throw new ApiValidateException(json_encode($validator->errors()));
        }
    }
}
