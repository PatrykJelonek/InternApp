@component('mail::message')
    <h2>Twoja prośba o dodanie firmy {{ $companyName }} została odrzucona.</h2>
    <div>
        <h4>Powód: </h4>
        <p>{{ $reason }}</p>
    </div>
@endcomponent
