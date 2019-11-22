@component('mail::message')
<h1>Redefinir Senha</h1>

<p>Olá, esse é um email de redefinição de senha! 
Click no botão abaixo para redefinir sua senha</p>

@component('mail::button', ['url' => url("/reset/password?token=$token")])
Reset Password
@endcomponent

<p>Caso não tenha solicitado a redefinição de senha, ignore esse email</p>
<p>Obrigado</p>
{{ config('app.name') }}
@endcomponent
