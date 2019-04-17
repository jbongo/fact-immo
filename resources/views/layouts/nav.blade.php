<body>

    <div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
        <div class="nano">
            <div class="nano-content">
                <ul>
                    <li class="active"><a ><i class="ti-home"></i> Accueil </a></li>
                    <li><a  class="sidebar-sub-toggle"><i class="ti-target"></i>Mandataires  <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>
                            <li><a href="{{route('mandataire.index')}}">Gestion</a></li>
                            <li><a href="page-login.html">Modèles commision</a></li>
                            <li><a href="page-login.html">Tarif pack pub</a></li>
                        </ul>
                    </li>
                    <li class="active"><a href="{{route('offre.index')}}" ><i class="ti-pencil-alt"></i> Offres </a></li>
                    <li class="active"><a href="{{route('mandataire.index')}}" ><i class="ti-pencil-alt"></i> Factures </a></li>
                    <li><a class="sidebar-sub-toggle"><i class="ti-pencil-alt"></i>Utilisateurs <span class="badge badge-primary">2</span></a></li>
                    <li><a  class="sidebar-sub-toggle"><i class="ti-target"></i> Paramètres <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>
                            <li><a href="page-login.html">Info Entreprise</a></li>
                            <li><a href="page-login.html">Modèles commision</a></li>
                            <li><a href="page-login.html">Tarif pack pub</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('logout') }}"  onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();" ><i class="ti-close"></i> Déconnexion</a></li>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                </ul>
            </div>
        </div>
    </div>
    <!-- /# sidebar -->

    <div class="header">
        <div class="pull-left">
            <div class="logo"><a href="index.html"><!-- <img src="assets/images/logo.png" alt="" /> --><span>Fact-Immo</span></a></div>
            <div class="hamburger sidebar-toggle">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </div>
        </div>
        <div class="pull-right p-r-15">
            <ul>
                <li class="header-icon dib"><i class="ti-bell"></i>
                    <div class="drop-down">
                        <div class="dropdown-content-heading">
                            <span class="text-left"> Notifications </span>
                        </div>
                        <div class="dropdown-content-body">
                            <ul>
                                <li>
                                    <a href="#">
                                        <img class="pull-left m-r-10 avatar-img" src="{{ asset('images/avatar/3.jpg')}}" alt="" />
                                        <div class="notification-content">
                                            <small class="notification-timestamp pull-right">02:34 PM</small>
                                            <div class="notification-heading">Mr.  Ajay</div>
                                            <div class="notification-text">5 members joined today </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="text-center">
                                    <a href="#" class="more-link">Voir tout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>

                <li class="header-icon dib"><img class="avatar-img" src="{{ asset('images/avatar/1.jpg')}}" alt="" /> <span class="user-avatar"> admin <i class="ti-angle-down f-s-10"></i></span>
                    <div class="drop-down dropdown-profile">
                      
                        <div class="dropdown-content-body">
                            <ul>
                                <li><a href="#"><i class="ti-user"></i> <span>Mon Profil</span></a></li>
                                <li><a href="{{ route('logout') }}"  onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();" ><i class="ti-power-off"></i> <span>Se déconnecter</span></a></li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 p-r-0 title-margin-right">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>@yield('page_title')</h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                            
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>
                <!-- /# row -->