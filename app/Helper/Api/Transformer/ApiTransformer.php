<?php
/**
 * Created by PhpStorm.
 * User: amin
 * Time: 1:29 PM
 */

namespace App\Helper\Api\Transformer;


/**
 * Class ApiTransformer
 * @package App\Http\Services\Api\Transformer
 */
class ApiTransformer
{
    /**
     * @param $transformer
     * @param $data
     * @param null $param
     * @return array|null
     */
    public static function transform($transformer, $data, $param = null)
    {
        $transformer = new $transformer;

        if ($transformer instanceof Transformer) {
            if (is_callable($func = $transformer->handle($data, $param))) {
                return $func();
            }
            return $func;
        }

        return null;
    }
}
