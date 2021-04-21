<?php

namespace App\Http\Requests;

use App\Constants\InternshipStatusConstants;
use App\Constants\RoleConstants;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreInternshipRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::user()->hasRole(RoleConstants::ROLE_ADMIN)) {
            return true;
        }

        if (Auth::user()->hasRole(RoleConstants::ROLE_STUDENT)) {
            return (bool) Auth::user()->internships()->whereHas('status', function (Builder $query) {
                $query->where(['name' => [InternshipStatusConstants::STATUS_NEW, InternshipStatusConstants::STATUS_ACCEPTED]]);
            })->count() > 1;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'offerId' => 'required|numeric|exists:offers,id',
            'agreementId' => 'required|numeric|exists:agreements,id',
            'companySupervisorId' => 'required|numeric|exists:offers,company_supervisor_id',
            'universitySupervisorId' => 'required|numeric|exists:agreements,university_supervisor_id'
        ];
    }
}
