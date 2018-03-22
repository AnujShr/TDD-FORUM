@component('mail::message')
# One Last Step

We just need you to confirm your email address to prove thay you're a human. You get it right? Cool

@component('mail::button', ['url' => url('/register/confirm?token='.$user->confirmation_token)])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
