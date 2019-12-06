@component('mail::message')
<h1>Verifição de Email</h1>

<p>Olá {{ $name }}, click no botão abaixo para ativar seu email! </p>

@component('mail::button', ['url' => url("/register/verify/$token")])
Confimar Email
@endcomponent

<p>Se não criou uma conta, por favor desconsiderar esse email!</p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
