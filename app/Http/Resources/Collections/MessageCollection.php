<?php

namespace App\Http\Resources\Collections;

use App\Http\Resources\MessageResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MessageCollection extends ResourceCollection
{
    public $collects = MessageResource::class;

    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
