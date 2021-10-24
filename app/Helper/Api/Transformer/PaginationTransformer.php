<?php
/**
 * Created by PhpStorm.
 * User: amin
 * Date: 5/24/19
 * Time: 1:31 PM
 */

namespace App\Helper\Api\Transformer;


class PaginationTransformer implements Transformer
{
    /**
     * @param $data
     * @return array
     */
    public function handle($data, $param = null): array
    {
        $data = is_array($data) ? $data : $data->toArray();
        return [
            'current_page' => $data['current_page'],
            'first_page_url' => $data['first_page_url'],
            'from' => $data['from'],
            'last_page' => $data['last_page'],
            'last_page_url' => $data['last_page_url'],
            'next_page_url' => $data['next_page_url'],
            'path' => $data['path'],
            'per_page' => $data['per_page'],
            'prev_page_url' => $data['prev_page_url'],
            'to' => $data['to'],
            'total' => $data['total'],
        ];
    }
}
