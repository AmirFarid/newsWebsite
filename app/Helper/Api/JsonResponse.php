<?php
/**
 * Created by PhpStorm.
 * User: amin
 * Time: 1:08 PM
 */

namespace App\Helper\Api;


use App\Helper\Api\Transformer\ApiTransformer;
use App\Helper\Api\Transformer\PaginationTransformer;
use Illuminate\Support\Facades\Cache;

/**
 * Class JsonResponse
 * @package App\Http\Services\Api
 */
class JsonResponse
{
    /**
     * @var int
     */
    private $status = 200;

    /**
     * @var
     */
    private $mainKey;

    /**
     * @var array
     */
    private $data = [];

    /**
     * @var
     */
    private $pagination;

    /**
     * @var null
     */
    private $remember = null;

    /**
     * @var string
     */
    private $message = '';

    /**
     * @var null
     */
    private $date = null;

    /**
     * JsonResponse constructor.
     * @param array $data
     * @param $mainKey
     */
    public function __construct($data, $mainKey)
    {
        $this->data = $data;
        $this->mainKey = $mainKey;
    }

    /**
     * @param mixed $status
     * @return JsonResponse
     */
    public function setStatus($status): JsonResponse
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @param mixed $mainKey
     * @return JsonResponse
     */
    public function setMainKey($mainKey): JsonResponse
    {
        $this->mainKey = $mainKey;

        return $this;
    }

    /**
     * @param array $data
     * @return JsonResponse
     */
    public function setData(array $data): JsonResponse
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param mixed $pagination
     * @return JsonResponse
     */
    public function setPagination($pagination): JsonResponse
    {
        $this->pagination = $pagination;

        return $this;
    }

    /**
     * @param $key
     * @param $data
     * @param int $min
     * @return $this
     */
    public function setRemember($key, $data, $min = 240)
    {
        $this->remember = Cache::remember($key, $min, function () use ($data) {
            return is_callable($data) ? call_user_func($data) : $data;
        });

        return $this;
    }

    /**
     * @param string $message
     * @return JsonResponse
     */
    public function setMessage(string $message): JsonResponse
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @param string $date
     * @return JsonResponse
     */
    public function setDate(string $date): JsonResponse
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @param $transformer
     * @param $data
     * @param bool $hasPagination
     * @param null $param
     * @return JsonResponse
     */
    public function transform($transformer, $data, $hasPagination = false, $param = null)
    {
        $this->setData(ApiTransformer::transform($transformer, $data, $param));

        if ($hasPagination) {
            $this->pagination = ApiTransformer::transform(PaginationTransformer::class, $data, $param);
        }

        return $this;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function toJson()
    {
        $this->mainKey = $this->mainKey ?? 'main';

        return response()->json([
            'message' => $this->message,
            'data' => [
                $this->mainKey => $this->remember ?? $this->data,
                'pagination' => $this->pagination,
                'date' => $this->date
            ],
            'mainKey' => $this->mainKey
        ], $this->status);
    }

    /**
     * @param string $message
     * @param int $code
     * @param string $mainKey
     * @param bool $api
     * @return \Illuminate\Http\JsonResponse
     */
    public function toJsonError($message = 'something goes wrong!', $code = 500, $mainKey = 'error', $api = false)
    {
        $this->setMainKey($mainKey)
            ->setStatus($code)
            ->setMessage(is_object($message) ? json_encode($message, JSON_UNESCAPED_UNICODE) : $message)
            ->setData(empty($this->data) ? compact('code', 'message') : $this->data);

        return $this->toJson();
    }

    /**
     * @param int $code
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function toJsonSuccess($message = 'OK!', $code = 200)
    {
        $this->setMainKey('success')
            ->setStatus($code)
            ->setMessage($message);

        return $this->toJson();
    }

    public function toNotFoundJson()
    {
        return $this->toJsonError('پیدا نشد!', 404);
    }

    public function toForbiddenJson()
    {
        return $this->toJsonError('دسترسی ندارید!', 403);
    }
}

