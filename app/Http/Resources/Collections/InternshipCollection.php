<?php

namespace App\Http\Resources\Collections;

use App\Http\Resources\InternshipResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class InternshipCollection extends ResourceCollection
{
    public $collects = InternshipResource::class;
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
