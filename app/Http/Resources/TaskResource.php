<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public $status;
    public $message;
    public $resource;
    public $setMeta;

    public function __construct($status, $message, $resource, $setMeta = false)
    {
        parent::__construct($resource);
        $this->status  = $status;
        $this->message = $message;
        $this->setMeta = $setMeta;
    }

    public function toArray(Request $request): array
    {
        $result =  [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->resource          
        ];

        if ($this->setMeta) {
            $result['meta'] = [
                'total'       => $this->total(),
                'count'       => $this->count(),
                'per_page'     => $this->perPage(),
                'current_page' => $this->currentPage(),
                'total_page'  => $this->lastPage(),
            ];
        }

        return $result;
    }
}
