@component('mail::message')
    Kliknij w poniższy aby przejść do formularza zmiany hasła
    @component('mail::button', ['url' => $url])
        Zmień hasło
    @endcomponent

    Lub skorzystaj z linku: {{ $url }}
@endcomponent
