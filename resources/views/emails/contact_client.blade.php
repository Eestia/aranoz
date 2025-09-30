@component('mail::message')
# Bonjour {{ $commande->user->name }},

Vous avez reçu un message de notre équipe concernant votre commande **#{{ $commande->id }}** :

> {{ $messageContent }}

Merci de votre confiance,<br>
{{ config('app.name') }}
@endcomponent
