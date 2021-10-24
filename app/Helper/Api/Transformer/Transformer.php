<?php
/**
 * Created by PhpStorm.
 * User: amin
 * Time: 1:30 PM
 */

namespace App\Helper\Api\Transformer;


interface Transformer
{
    public function handle($data, $param = null);
}
