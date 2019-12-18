<body>

    <div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
        <div class="nano">
            <div class="nano-content">
                <ul>
                    <li class="active" ><a href="{{route('home')}}" ><i class="ti-home"></i> Accueil </a></li>
                    @if (Auth()->user()->role == "admin")
                        
                  
                    <li><a  href="{{route('mandataire.index')}}" class="">  <i class="ti-user"></i>Mandataires  </a>
                        {{-- <ul>
                            <li><a href="{{route('mandataire.index')}}">Gestion</a></li>
                            <li><a href="{{route('commissions.index')}}">Modèles commision</a></li>
                            <li><a href="page-login.html">Tarif pack pub</a></li>
                        </ul> --}}
                    </li>

                    @endif
                    <li class=""><a href="{{route('compromis.index')}}" ><i class="ti-pencil-alt"></i> Affaires </a></li>
                    <li><a  class="sidebar-sub-toggle"><i class="ti-pencil-alt"></i> Factures @if(auth()->user()->demande_facture > 0) <span class="badge badge-danger">{{auth()->user()->demande_facture}}</span> @endif<span class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>
                            <li><a href="{{route('facture.index')}}">Gestion</a></li>
                            @if (Auth()->user()->role == "admin")
                            <li  @if(auth()->user()->demande_facture > 0) style="background-color:#FFEEEB" @endif><a  href="{{route('facture.demande_stylimmo')}}" >  @if(auth()->user()->demande_facture > 0) <span class="badge badge-danger">{{auth()->user()->demande_facture}}</span> @endif Demandes de facture  </a></li>
                            @endif
                            <li><a href="#">Avoir</a></li>
                        </ul>
                    </li>
                    
                    
                    @if (Auth()->user()->role == "admin")
                    
                    <li><a  class="sidebar-sub-toggle"><i class="ti-target"></i> Paramètres <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>
                            {{-- <li><a href="page-login.html">Info Entreprise</a></li> --}}
                            <li><a href="{{route('modele_contrat.create')}}">Modèle contrat</a></li>
                            <li><a href="{{route('pack_pub.index')}}">Tarif pack pub</a></li>
                        </ul>
                    </li>
                    @endif
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
                
                {{-- <li class="header-icon dib"><a href="" class="waves-effect waves-light btn red"> <span><i class="material-icons left">arrow_back</i> Retourner </span>  </a> 
                    
                </li> --}}
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

                <li class="header-icon dib"><img class="avatar-img" src="{{ asset('images/avatar/1.jpg')}}" alt="" /> <span class="user-avatar"> {{auth()->user()->nom }} {{auth()->user()->prenom }}<i class="ti-angle-down f-s-10"></i></span>
                    <div class="drop-down dropdown-profile">
                      
                        <div class="dropdown-content-body">
                            <ul>
                            <li><a href="{{route('mandataire.show',Crypt::encrypt(Auth()->user()->id) )}}"><i class="ti-user"></i> <span>Mon Profil</span></a></li>
                            @if(session('is_switch') == true)
                            <li ><a href="{{ route('unswitch_user') }}" class="btn btn-success"><i class="ti-arrow-left"></i> <span>Retour ADMIN</span></a>
                            @endif
                            </li>
                            <li><a href="{{ route('logout') }}"  onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();" ><i class="ti-power-off"></i> <span>Se déconnecter</span></a>
                            </li>
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