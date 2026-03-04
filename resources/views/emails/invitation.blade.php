@component('mail::message')
# Vous êtes invité(e) à rejoindre une colocation !

Vous avez reçu une invitation pour rejoindre la colocation **{{ $invitation->colocation->name }}**.

Cliquez sur le bouton ci-dessous pour accepter l'invitation :

@component('mail::button', ['url' => route('invitations.accept', $invitation->token)])
Rejoindre la colocation
@endcomponent

Merci,
@endcomponent