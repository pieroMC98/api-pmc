Hola {{ $user->name }}
Gracias por crear una cuenta. verifica en link:
{{route('verify',['token' => $user->verification_token ])}}
