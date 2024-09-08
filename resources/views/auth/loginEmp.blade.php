<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Salaire</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:700,600" rel="stylesheet" type="text/css" />
    @vite(['resources/css/auth.css'])
</head>
<body>

<form method="post" action="{{route('handleLoginEmp')}}">
    @csrf
    @method('POST')

    <div class="box">
        <h1>Espace de connexion emp</h1>

        @if (Session::get('success_message'))
            <b style="font-size: 10px; color:rgb(29,255,199)">{{Session::get('error_msg')}}</b>
        @endif

        @if (Session::get('error_msg'))
            <b style="font-size: 10px; color:rgb(185,81,81)">{{Session::get('error_msg')}}</b>
        @endif

        <input type="email" name="email" class="email" placeholder="Email" required />

        <input type="password" name="password" class="email" placeholder="Mot de passe" required />

        <div class="btn-container">
            <button type="submit">Connexion</button>
        </div>
    </div>
</form>

</body>
</html>
