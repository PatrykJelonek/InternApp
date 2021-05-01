<?php

namespace App\Http\Requests;

use App\Rules\Attachments;
use Illuminate\Foundation\Http\FormRequest;

class StoreOfferRequest extends FormRequest
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
            'name' => 'required|string|unique:App\Models\Offer',
            'placesNumber' => 'required|integer|min:1',
            'program' => 'required|string',
            'schedule' => 'nullable|string',
            'offerCategoryId' => 'required|exists:App\Models\OfferCategory,id',
            'companySupervisorId' => 'required|exists:App\Models\User,id',
            'dateFrom' => 'required|date|after:yesterday',
            'dateTo' => 'required|date|after:dateFrom',
            'interview' => 'sometimes|boolean',
            'attachments' => [new Attachments()],
            'companyId' => 'required|exists:App\Models\Company,id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nazwa oferty jest wymagana.',
            'name.string' => 'Nazwa oferty musi być tekstem.',
            'name.unique' => 'Podana nazwa oferty istnieje już w systemie',
            'placesNumber.required' => 'Ilość miejsc jest wymagana.',
            'placesNumber.integer' => 'Wartość musi być liczbą.',
            'placesNumber.min' => 'Wartość musi być nie mniejsza niż 1.',
            'program.required' => 'Program oferty jest wymagany.',
            'program.string' => 'Program oferty powinien być tekstem.',
            'schedule.string' => 'Harmonogram powinien być tekstem.',
            'offerCategoryId.required' => 'Kategoria oferty jest wymagana.',
            'offerCategoryId.exists' => 'Podana kategoria nie istnieje.',
            'companySupervisorId.required' => 'Opiekun praktyki jest wymagany.',
            'companySupervisorId.exists' => 'Podany użytkownik nie istnieje.',
            'dateFrom.required' => 'Początkowa data praktyki jest wymagana.',
            'dateFrom.date' => 'Nie podano poprawnej daty.',
            'dateFrom.after' => 'Data powinna być późniejsza niż :attribute',
            'dateTo.required' => 'Data końcowa jest wymagana.',
            'dateTo.date' => 'Nie podano poprawnej daty',
            'dateTo.after' => 'Data powinna być późniejsza niż :value',
            'interview.boolean' => 'Wartość powinna być wartością logiczną.',
            'companyId.required' => 'ID firmy jest wymagane.',
            'companyId.exists' => 'Firma o podanym ID nie istnieje.',
        ];
    }
}
