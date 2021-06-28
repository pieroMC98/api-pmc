Hola {{ $user->name }}
Gracias por crear una cuenta. verifica en link:
{{route('verify', $user->verification_token)}}
