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
            'agreement' => $this->agreement,
            'offer' => $this->agreement->offer,
            'company_supervisor_id' => $this->company_supervisor_id,
            'university_supervisor_id' => $this->company_supervisor_id,
            'grade' => $this->grade,
            'interview_date' => $this->intervie_date,
            'internship_status_id' => $this->internship_status_id,
            'company_supervisor' => $this->companySupervisor,
            'university_supervisor' => $this->universitySupervisor,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
