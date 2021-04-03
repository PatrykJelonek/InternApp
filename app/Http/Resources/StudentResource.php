<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'student_index' => $this->student_index,
            'semester' => $this->semester,
            'study_year' => $this->study_year,
            'specialization' => new Specialization($this->specialization),
            'user' => new User($this->user),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
