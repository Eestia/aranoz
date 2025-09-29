@component('mail::message')
# Bonjour {{ $commande->user->name }},

Votre commande **#{{ $commande->id }}** est en route !

@component('mail::button', ['url' => route('commandes.show', $commande)])
Voir ma commande
@endcomponent

Merci pour votre achat,<br>
{{ config('app.name') }}
@endcomponent
