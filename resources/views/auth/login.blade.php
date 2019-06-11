@extends('layouts.app')

@section('title', 'Se connecter')

@section('content')
    <div class="row-container login-container">
        <h1 class="title" style="padding-top:20px">Connexion</h1>
        <h3 class="subtitle" style="margin-top:-15px;font-size:1.2em">Connectez-vous pour pouvoir continuer...</h3>

        <hr>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="input">
                <label>Identifiant</label>
                <input type="text" name="name"{{ $errors->has('name') ? ' class=error' : '' }} placeholder="Pseudonyme" required>

                @if ($errors->has('name'))
                    <span class="input-error" role="alert">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
            <div class="input">
                <label>Mot de passe</label>
                <input type="password" name="password"{{ $errors->has('password') ? ' class=error' : '' }} placeholder="Mot de passe" autocomplete="off" required>

                @if ($errors->has('password'))
                    <span class="input-error" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="input submit">
                <input type="submit" style="float:right" value="Se connecter">
                <div class="clear"></div>
            </div>
        </form>

        <hr>

        <div class="login-others-links">
            <p>
                <i class="fa fa-angle-right"></i> Pas inscrit ? <a href="{{ route('register') }}" title="Inscription">Inscrivez-vous
                    ici</a>. <br>
                <i class="fa fa-angle-right"></i> Mot de passe perdu ? <a href="{{ route('password.request') }}"
                                                                          title="Changement du mot de passe">Changez-le
                    ici</a>.
            </p>
        </div>

    </div>
@endsection