<body>
@php
    $curent_url = $_SERVER['REQUEST_URI']; 
    $curent_url = explode("/", $curent_url);


    $li_home = $li_mandataire = $li_affaire = $li_facture = $li_facture_gestion = $li_facture_demande = $li_parametre = $li_parametre_modele = $li_parametre_pub = $li_parametre_generaux= "";
    
    switch ($curent_url[1]) {
        case 'home':       
            $li_home = "active";
            break;
        case 'mandataires':
            $li_mandataire = "active";
            break;
        case 'compromis':
            $li_affaire = "active";
            break;
        case 'factures':
            $li_facture= "active open";
            if( sizeof($curent_url) == 2 )
            $li_facture_gestion = "active";
            break;
        case 'demande':
            $li_facture_demande= "active open";
            break;
        case 'parametre':
            $li_parametre= "active open";
            break;
        
        default:
            // dd("default");
            break;
    }
    if(sizeof($curent_url) > 2){

        switch ($curent_url[2]) {
            case 'modele_contrat':       
                $li_parametre_modele = "active";
                break;
            case 'pack_pub':
                $li_parametre_pub = "active";
                break;
            case 'generaux':
                $li_parametre_generaux = "active";
                break;    
            
            default:
                // dd("default");
                break;
        }
    }

    //  Factures honoraires en attente de validation 
    $nb = App\Facture::where('statut','en attente de validation')->get()->count();

    $nb_notif =  auth()->user()->demande_facture + $nb ;
    

@endphp

    <div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
        <div class="nano">
            <div class="nano-content">


                <ul>
                <li class="{{$li_home}}" ><a href="{{route('home')}}" ><i class="large material-icons" style="font-size:20px;">home</i> Accueil </a></li>
                    
                @if (Auth()->user()->role == "admin")
                        
               
                    <li class="{{$li_mandataire}}"><a  href="{{route('mandataire.index')}}" class=""> <i class="large material-icons" style="font-size:20px;">person</i></i>Mandataires  </a>
                    </li>

                @endif
                <li class="{{ $li_affaire}}"><a href="{{route('compromis.index')}}" ><i class="large material-icons" style="font-size:20px;">folder_open</i>  Affaires </a></li>
                
                <li class="{{$li_facture}} {{$li_facture_demande}}" ><a  class="sidebar-sub-toggle"><i class="large material-icons">description</i> Factures @if($nb_notif > 0 && auth::user()->role == "admin") <span class="badge badge-danger">{{$nb_notif}}</span> @endif<span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        <li class="{{$li_facture_gestion}}" ><a href="{{route('facture.index')}}">Gestion</a></li>
                        @if (Auth()->user()->role == "admin")
                        <li class="{{$li_facture_demande}}" ><a  href="{{route('facture.demande_stylimmo')}}" >  @if(auth()->user()->demande_facture > 0) <span class="badge badge-danger">{{auth()->user()->demande_facture}}</span> @endif Demandes </a></li>
                        @endif
                        
                        @if (Auth()->user()->role == "admin")
                        <li class="{{$li_facture_demande}}" ><a  href="{{route('facture.honoraire_a_valider')}}" >  @if($nb > 0) <span class="badge badge-danger">{{$nb}}</span> @endif A valider </a></li>
                        @endif
                        {{-- <li><a href="#">Avoir</a></li> --}}
                    </ul>
                </li>
                    
                    
                    @if (Auth()->user()->role == "admin")
                    
                <li class="{{$li_parametre}}"><a  class="sidebar-sub-toggle"><i class="large material-icons" style="font-size:20px;">build</i> Paramètres <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>
                            {{-- <li><a href="page-login.html">Info Entreprise</a></li> --}}
                            <li class="{{$li_parametre_generaux}}"><a href="{{route('parametre_generaux.create')}}">Généraux</a></li>
                            <li class="{{$li_parametre_modele}}"><a href="{{route('modele_contrat.create')}}">Modèle contrat</a></li>
                            <li class="{{$li_parametre_pub}}"><a href="{{route('pack_pub.index')}}">Publicité</a></li>
                        </ul>
                    </li>
                    @endif
                    <li><a href="{{ route('logout') }}"  onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();" ><i class="large material-icons" style="font-size:20px;">close</i></i> Déconnexion</a></li>

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
            <div class="logo"><a href="{{route('home')}}"><!-- <img src="assets/images/logo.png" alt="" /> --><span>Mini Curieux</span></a></div>
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

                <li class="header-icon dib"><img class="avatar-img" src="{{ asset('/images/avatar/'.((auth()->user()->civilite == "Mme." || auth()->user()->civilite == "Mme") ? "user_female.jpg ": "user_male.jpg"))}}" alt="" /> <span class="user-avatar"> {{auth()->user()->nom }} {{auth()->user()->prenom }}<i class="ti-angle-down f-s-10"></i></span>
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
                    <div class="col-lg-12 p-r-0 title-margin-right">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>@yield('page_title')</h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    {{-- <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                            
                                </ol>
                            </div>
                        </div>
                    </div> --}}
                    <!-- /# column -->
                </div>
                <!-- /# row -->