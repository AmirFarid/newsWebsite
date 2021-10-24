<?php
/**
 * Created by PhpStorm.
 * User: Mvaliolahi
 * Date: 7/30/18
 * Time: 6:11 PM
 */

namespace App\Http\Middleware;

use App\Helper\GlobalHelper;
use Closure;
use Illuminate\Http\Request;


/**
 * Class ConvertDigitsToEnglishFormat
 * @package Sibapp\Http\Middleware
 */
class ConvertDigitsToEnglishFormat
{
    /**
     * @var array
     */
    protected $fields = [
        'mobile',
        'number',
        'token',
        'created_at'
    ];

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        foreach ($this->fields as $field) {
            if ($request->has($field)) {
                request()->merge([
                    $field => GlobalHelper::changeToEnglishDigit(request($field))
                ]);
            }
        }

        return $next($request);
    }
}
