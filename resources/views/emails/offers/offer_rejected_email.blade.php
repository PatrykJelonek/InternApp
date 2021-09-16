@component('mail::message')
    <h2>{{ $fullName }}, twoja oferta {{ $offerName }} w firmie {{ $companyName }} została odrzucona!</h2>
    <div>
        <h4>Powód: </h4>
        <p>{{ $reason }}</p>
    </div>
@endcomponent
