<?php

namespace Remp\LaravelHelpers\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Symfony\Component\HttpKernel\Exception\HttpException;

class JsonResource extends Resource
{
    public function toArray($request)
    {
        if ($this->resource instanceof \Exception) {
            return [
                'message' => $this->resource->getMessage(),
            ];
        }
        if (!isset($this->resource) || is_array($this->resource)) {
            return null;
        }
        return parent::toArray($request);
    }

    public function withResponse($request, $response)
    {
        parent::withResponse($request, $response);

        if ($this->resource instanceof \Exception) {
            if ($this->resource instanceof HttpException) {
                $response->setStatusCode($this->resource->getStatusCode());
            } else {
                $response->setStatusCode(500);
            }
        }
    }
}