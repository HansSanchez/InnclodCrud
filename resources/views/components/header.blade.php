<header class="text-white c-header c-header-light c-header-fixed bg-dark c-header-with-subheader">
    <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar"
        data-class="c-sidebar-show">
        <i class="text-white fas fa-bars c-icon c-icon-lg"></i>
    </button>
    <div>
        <a class="text-center c-header-brand d-lg-none justify-content-center" href="#">
            <img src="{{ asset('assets/blk/img/logo_innclod.png') }}" width="32px" height="32px">
            <b
                style="padding-top: 5px!important; padding-left: 5px !important; font-size: 20px; color: white !important;">
                INNCLODCRUD
            </b>
        </a>
    </div>
    <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar"
        data-class="c-sidebar-lg-show" responsive="true">
        <i class="text-white fas fa-bars c-icon c-icon-lg"></i>
    </button>
    <ul class="ml-auto mr-4 c-header-nav">
        <li class="c-header-nav-item dropdown">
            <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                aria-expanded="false">
                <div class="c-avatar">
                    @if (auth()->check())
                        @if (auth()->user()->profile_photo_path != null)
                            <img class="c-avatar-img"
                                src="{{ asset('storage/users/' . auth()->user()->profile_photo_path) }}"
                                alt="user@email.com" />
                        @else
                            <img class="c-avatar-img" src="{{ asset('assets/img/avatars/pngwing.com.png') }}"
                                alt="user@email.com" />
                        @endif
                    @else
                        <img class="c-avatar-img" src="{{ asset('assets/img/avatars/pngwing.com.png') }}"
                            alt="user@email.com" />
                    @endif
                </div>
            </a>
            <div class="pt-0 dropdown-menu dropdown-menu-right">
                <div class="py-2 dropdown-header bg-light">
                    <strong>Mi cuenta</strong>
                </div>
                <span class="dropdown-item">
                    <i class="mr-2 fas fa-mail-bulk c-icon"></i>
                    @if (auth()->check())
                        {{ auth()->user()->email }}
                    @else
                        NO USER
                    @endif
                </span>
                <a class="dropdown-item" href="{{ route('logout') }}">
                    <i class="mr-2 fas fa-sign-out-alt c-icon"></i>
                    Cerrar sesión
                </a>
            </div>
        </li>
    </ul>
</header>
