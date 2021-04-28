<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LandingPageOfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'places_number' => $this->places_number,
            'program' => $this->program,
            'company' => [
                'name' => $this->company->name,
                'website' => $this->company->website,
            ],
            'created_at' => $this->created_at,
        ];
    }
}
