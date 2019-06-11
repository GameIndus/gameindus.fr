@extends('layouts.app')

@section('content')
    <div class="account-container">
        <div class="user-menu-container">
            @include('account.topbar')
        </div>

        <div class="user-account-container row-container">
            <h1 class="title" style="font-size:2em">Mes succès</h1>

            <blockquote>
                <p><i class="fa fa-warning"></i> Page encore en développement. Veuillez nous excuser pour la gène
                    occasionnée.</p>
            </blockquote>

        </div>

        <div class="clear"></div>
    </div>
@endsection