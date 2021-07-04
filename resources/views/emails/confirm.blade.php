Hola {{ $user->name }}
Has cambiado de correo electronico. verifica en link:
{{route('verify', $user->verification_token)}}
