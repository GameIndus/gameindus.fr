<div class="user-info-container" style="background-image:url(https://www.arcticnorth.ca/skin/frontend/fengo/default/images/chestnut/avatar/avatar.png);">
    <div class="row-container">
        <div class="left">
            <img src="https://www.arcticnorth.ca/skin/frontend/fengo/default/images/chestnut/avatar/avatar.png" class="avatar" alt="Avatar de {{ Auth::user()->name }}">

            @if(strlen(Auth::user()->name) > 10)
                <span class="username" style="font-size:1.2em">{{ Auth::user()->name }}</span>
            @else
                <span class="username">{{ Auth::user()->name }}</span>
            @endif
            <span class="role"><i class="fa fa-user"></i> Créateur débutant</span>
            <span class="registered-in"><i class="fa fa-calendar"></i> Membre depuis le {{ Auth::user()->created_at->format('d/m/Y') }}</span>

            <div class="clear"></div>
        </div>

        <div class="right">

        </div>

        <div class="clear"></div>
    </div>
</div>

<div class="user-menu">
    <div class="row-container">
        <a href="{{ route('account') }}" title="Mon profil">
            <div class="menu-item<?= (Route::current()->getName() == "account") ? " active" : ""; ?>"><i class="fa fa-user"></i> <span>Mon profil</span>
            </div>
        </a>
        <a href="{{ route('account.games') }}" title="Mes jeux">
            <div class="menu-item<?= (Route::current()->getName() == "account.games") ? " active" : ""; ?>"><i
                        class="fa fa-gamepad"></i> <span>Mes jeux</span></div>
        </a>
        <a href="{{ route('account.badges') }}" title="Mes succès">
            <div class="menu-item<?= (Route::current()->getName() == "account.badges") ? " active" : ""; ?>"><i
                        class="fa fa-certificate"></i> <span>Mes succès</span></div>
        </a>
        <a href="{{ route('account.edit') }}" title="Editer le compte">
            <div class="menu-item<?= (Route::current()->getName() == "account.edit") ? " active" : ""; ?>"><i class="fa fa-pencil"></i>
                <span>Editer mon profil</span></div>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('logout') }}" title="Se déconnecter">
                <button class="menu-item item-logout"><i class="fa fa-lock"></i> <span>Se déconnecter</span></button>
            </a>
        </form>
    </div>
</div>
