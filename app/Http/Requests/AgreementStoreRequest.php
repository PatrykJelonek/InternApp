<?php

namespace App\Http\Requests;

use App\Rules\Attachments;
use Illuminate\Foundation\Http\FormRequest;

class AgreementStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'dateFrom' => 'required|date|after:yesterday',
            'dateTo' => 'required|date',
            'program' => 'required|string',
            'schedule' => 'nullable|string',
            'content' => 'nullable|string',
            'companyId' => 'required|exists:App\Models\Company,id',
            'universitySlug' => 'required|exists:App\Models\University,slug',
            'universitySupervisorId' => 'required|exists:App\Models\User,id',
            'offerId' => 'required|exists:App\Models\Offer,id',
            'offerPlacesNumber' => 'required|int',
            'placesNumber' => 'required|int|lte:offerPlacesNumber|min:1',
            'isActive' => 'nullable|boolean',
            'attachments' => new Attachments()
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Pole jest wymagane.',
            'dateFrom.required' => 'Pole jest wymagane.',
            'dateFrom.date' => 'Podaj poprawną date.',
            'dateFrom.after' => 'Data musi być aktualna.',
            'dateTo.required' => 'Pole jest wymagane.',
            'dateTo.date' => 'Podaj poprawną date.',
            'program.required' => 'Pole jest wymagane.',
            'program.string' => 'Pole musi być tekstem.',
            'schedule.string' => 'Pole musi być tekstem.',
            'content.string' => 'Pole musi być tekstem.',
            'companyId.required' => 'Pole jest wymagane.',
            'companyId.exists' => 'Podana firma nie istnieje.',
            'universityId.required' => 'Pole jest wymagane.',
            'universityId.exists' => 'Podana uczelnia nie istnieje.',
            'universitySupervisorId.required' => 'Pole jest wymagane.',
            'universitySupervisorId.exists' => 'Podany użytkownik nie istnieje.',
            'offerId.required' => 'Pole jest wymagane.',
            'offerId.exists' => 'Podana oferta nie istnieje.',
            'offerPlacesNumber.required' => 'Pole jest wymagane.',
            'offerPlacesNumber.int' => 'Pole musi być liczbą.',
            'placesNumber.required' => 'Pole jest wymagane.',
            'placesNumber.int' => 'Pole musi być liczbą.',
            'isActive.boolean' => 'Pole musi być wartością logiczną.',
            'attachments' => 'Dodaj poprawne załączniki.',
        ];
    }
}
