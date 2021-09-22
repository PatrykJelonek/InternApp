@component('mail::message')
    <h2>{{ $fullName }}, twoja prośba o dodanie do firmy {{ $companyName }} została odrzucona.</h2>
    <div>
        <h4>Powód: </h4>
        <p>{{ $reason }}</p>
    </div>
@endcomponent
