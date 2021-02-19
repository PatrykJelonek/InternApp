<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InternshipResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'offer_id' => $this->offer_id,
            'agreement_id' => $this->agreement_id,
            'student_id' => $this->student_id,
            'company_supervisor_id' => $this->company_supervisor_id,
            'university_supervisor_id' => $this->company_supervisor_id,
            'grade' => $this->grade,
            'interview_date' => $this->intervie_date,
            'internship_status_id' => $this->internship_status_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
