<body>
    @php
        $curent_url = $_SERVER['REQUEST_URI'];
        $curent_url = explode('/', $curent_url);
        
        $li_home = $li_stats = $li_mandataire = $li_prospect_gestion = $li_prospect_archive = $li_affaire = $li_affaire_filleul = $li_affaire_archive = $li_facture = $li_facture_gestion = $li_facture_demande = $li_facture_a_payer = $li_facture_a_valider = $li_parametre = $li_parametre_modele = $li_parametre_fournisseur = $li_parametre_bareme_honoraire = $li_parametre_pack_pub = $li_parametre_generaux = $li_outil = $li_affaire_toutes = $li_affaire_cloture = $li_facture_hors_delais = $li_jetons = $li_facture_pub = $li_parrainage = $li_documents = $li_documents_gestion = $li_documents_a_valider = $li_fournisseurs = $li_fournisseurs_passerelle = $li_fournisseurs_autre = '';
        
        switch ($curent_url[1]) {
            case 'home':
                $li_home = 'active';
                break;
            case 'stats':
                $li_stats = 'active';
                break;
            case 'outil-calcul':
                $li_outil = 'active';
                break;
            case 'mandataires':
                $li_mandataire = 'active';
                break;
            case 'parrainage':
                $li_parrainage = 'active';
                break;
            case 'prospects':
                $li_prospect_gestion = 'active';
                break;
            case 'compromis':
                if (sizeof($curent_url) < 3) {
                    $li_affaire = 'active open';
                }
                break;
        
            case 'affaires-clotures':
                $li_affaire_cloture = 'active open';
                break;
        
            case 'affaires-toutes':
                $li_affaire_toutes = 'active open';
                break;
        
            case 'factures':
                $li_facture = 'active open';
                if (sizeof($curent_url) == 2) {
                    $li_facture_gestion = 'active';
                }
                break;
            case 'demande':
                $li_facture_demande = 'active open';
                break;
            case 'parametre':
                $li_parametre = 'active open';
                break;
            case 'documents':
                $li_documents = 'active open';
                $li_documents_gestion = 'active';
        
                break;
        
            default:
                // dd("default");
                break;
        }
        if (sizeof($curent_url) > 2) {
            switch ($curent_url[2]) {
                case 'modele_contrat':
                    $li_parametre_modele = 'active';
                    break;
                case 'jetons':
                    $li_jetons = 'active';
                    break;
                case 'facture-pub':
                    $facture_pub = 'active';
                    break;
                case 'fournisseur':
                    $li_parametre_fournisseur = 'active';
                    break;
                case 'bareme-honoraire':
                    $li_parametre_bareme_honoraire = 'active';
                    break;
                case 'generaux':
                    $li_parametre_generaux = 'active';
                    break;
                case 'pack_pub':
                    $li_parametre_pack_pub = 'active';
                    break;
        
                case 'archive':
                    if ($curent_url[1] == 'compromis') {
                        $li_affaire_archive = 'active open';
                    } elseif ($curent_url[1] == 'prospects') {
                        $li_affaire_archive = 'active open';
                    }
                    break;
        
                case 'page_filleul':
                    if ($curent_url[1] == 'compromis') {
                        $li_prospect_archive = 'active open';
                    }
                    break;
        
                case 'a_valider':
                    if ($curent_url[1] == 'documents') {
                        $li_documents_a_valider = 'active';
                        $li_documents_gestion = '';
                    }
                    break;
        
                case 'type':
                    if ($curent_url[1] == 'documents') {
                    }
                    break;
        
                default:
                    // dd("default");
                    break;
            }
        
            if (sizeof($curent_url) == 4) {
                switch ($curent_url[3]) {
                    case 'a-payer':
                        if ($curent_url[2] == 'honoraire') {
                            $li_facture_a_payer = 'active open';
                        }
                        break;
                    case 'a_valider':
                        if ($curent_url[2] == 'honoraire') {
                            $li_facture_a_valider = 'active open';
                        }
                        break;
        
                    case 'passerelle':
                        if ($curent_url[1] == 'fournisseur' && $curent_url[2] == 'type') {
                            $li_fournisseurs = 'active open';
                            $li_fournisseurs_passerelle = 'active';
                        }
                        break;
        
                    case 'autre':
                        if ($curent_url[1] == 'fournisseur' && $curent_url[2] == 'type') {
                            $li_fournisseurs = 'active open';
                            $li_fournisseurs_autre = 'active';
                        }
                        break;
        
                    default:
                        // dd("default");
                        break;
                }
            }
        }
        
        //  Factures honoraires en attente de validation
        $nb = App\Facture::where('statut', 'en attente de validation')
            ->get()
            ->count();
        $nb_a_payer = App\Facture::nb_facture_a_payer();
        $nb_liste_pub = App\Factpub::where([['validation', 0]])
            ->orderBy('id', 'desc')
            ->get()
            ->count();
        $nb_doc_a_valider = App\Fichier::where([['valide', 0]])
            ->get()
            ->count();
        
        $nb_notif_pub =
            Auth()->user()->role == 'mandataire'
                ? App\Facture::where([['user_id', auth()->user()->id], ['reglee', false], ['a_avoir', false]])
                    ->whereIn('type', ['pack_pub', 'carte_visite'])
                    ->count()
                : 0;
        
        $nb_notif = auth()->user()->demande_facture + $nb + $nb_a_payer + $nb_liste_pub;
        
    @endphp

    <div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
        <div class="nano">
            <div class="nano-content">


                <ul>
                    <li class="{{ $li_home }}"><a href="{{ route('home') }}"><i class="large material-icons"
                                style="font-size:20px;">home</i> Accueil </a></li>
                    @if (Auth()->user()->role == 'mandataire')
                        <li class="{{ $li_mandataire }}"><a
                                href="{{ route('mandataire.show', Crypt::encrypt(Auth()->user()->id)) }}" class="">
                                <i class="large material-icons" style="font-size:20px;">person</i></i>Mon profil </a>
                        </li>
                    @endif


                    @if (Auth()->user()->role == 'admin')
                        <li class="{{ $li_stats }}" style=" background:#e6ea9a"><a
                                href="{{ route('stats.index', date('Y')) }}"><i class="large material-icons"
                                    style="font-size:20px;">equalizer</i> Statistiques </a></li>
                    @endif

                    @if (Auth()->user()->role == 'admin')
                        <li class="{{ $li_mandataire }}"><a href="{{ route('mandataire.index') }}" class=""> <i
                                    class="large material-icons" style="font-size:20px;">person</i></i>Mandataires </a>
                        </li>
                    @endif
                    @if (Auth()->user()->role == 'admin' || Auth()->user()->is_superviseur == true)
                        <li class="{{ $li_prospect_gestion }} {{ $li_prospect_archive }}"><a href=""
                                class="sidebar-sub-toggle"> <i class="large material-icons"
                                    style="font-size:20px;">person</i></i> Prospects <span
                                    class="sidebar-collapse-icon ti-angle-down"></span> </a>
                            <ul>
                                <li class="{{ $li_prospect_gestion }}"><a
                                        href="{{ route('prospect.index') }}">Gestion</a></li>
                                <li class="{{ $li_prospect_archive }}"><a
                                        href="{{ route('prospect.archives') }}">Archivés</a></li>

                                {{-- <li><a href="#">Avoir</a></li> --}}
                            </ul>


                        </li>
                    @endif

                    @if (Auth()->user()->role == 'admin')


                        <li class="{{ $li_jetons }}"><a href="{{ route('mandataires.jetons') }}" class=""> <i
                                    class="large material-icons" style="font-size:20px;">adjust</i></i>Gestion des
                                jetons </a></li>
                        <li class="{{ $li_facture_pub }}"><a href="{{ route('mandataires.facture_pub') }}"
                                class=""> <i class="large material-icons"
                                    style="font-size:20px;">receipt</i></i>Gestion des Facts pub </a></li>
                        <li class="{{ $li_parrainage }}" style=" background:#e6ea9a"><a
                                href="{{ route('parrainage.index') }}" class=""> <i class="large material-icons"
                                    style="font-size:20px;">receipt</i></i>Gestion des Parrainages </a></li>
                    @else
                        @if (Auth()->user()->contrat->deduis_jeton == true)
                            <li class="{{ $li_jetons }}"><a
                                    href="{{ route('mandataire.historique_jeton', Crypt::encrypt(Auth::id())) }}"
                                    class=""> <i class="large material-icons"
                                        style="font-size:20px;">adjust</i></i>Gestion des jetons </a></li>
                        @endif

                    @endif
                    <li
                        class="{{ $li_affaire }} {{ $li_affaire_archive }} {{ $li_affaire_toutes }} {{ $li_affaire_cloture }} {{ $li_affaire_filleul }}">
                        <a class="sidebar-sub-toggle" href=""><i class="large material-icons"
                                style="font-size:20px;">folder_open</i>
                            Affaires <span class="sidebar-collapse-icon ti-angle-down"></span> </a>
                        <ul>
                            @if (Auth()->user()->role == 'admin')
                                <li class="{{ $li_affaire }}"><a href="{{ route('compromis.index') }}">En cours</a>
                                </li>
                            @else
                                <li class="{{ $li_affaire }}"><a href="{{ route('compromis.index') }}">Mes affaires
                                        en cours</a></li>
                                <li class="{{ $li_affaire_filleul }}"><a
                                        href="{{ route('compromis.filleul.index') }}">Affaires de mes filleuls</a></li>
                            @endif
                            <li class="{{ $li_affaire_cloture }}"><a
                                    href="{{ route('compromis.affaire_cloture') }}">Cloturées</a></li>
                            <li class="{{ $li_affaire_archive }}"><a
                                    href="{{ route('compromis.archive') }}">Archivées</a></li>
                            <li class="{{ $li_affaire_toutes }}"><a
                                    href="{{ route('compromis.affaire_toutes') }}">Toutes les affaires</a></li>

                        </ul>
                    </li>

                    <li
                        class="{{ $li_facture }} {{ $li_facture_demande }} {{ $li_facture_a_payer }} {{ $li_facture_hors_delais }} {{ $li_facture_a_valider }}">
                        <a class="sidebar-sub-toggle"><i class="large material-icons">description</i> Factures
                            @if ($nb_notif > 0 && Auth()->user()->role == 'admin')
                                <span class="badge badge-danger">{{ $nb_notif }}</span>
                            @endif
                            @if ($nb_notif_pub > 0 && Auth()->user()->role == 'mandataire')
                                <span class="badge badge-danger">{{ $nb_notif_pub }}</span>
                            @endif

                            <span class="sidebar-collapse-icon ti-angle-down"></span>
                        </a>
                        <ul>
                            <li class="{{ $li_facture_gestion }}"><a href="{{ route('facture.index') }}">Gestion</a>
                            </li>
                            @if (Auth()->user()->role == 'admin')
                                <li class="{{ $li_facture_demande }}"><a
                                        href="{{ route('facture.demande_stylimmo') }}">
                                        @if (Auth()->user()->demande_facture > 0)
                                            <span
                                                class="badge badge-danger">{{ Auth()->user()->demande_facture }}</span>
                                        @endif Demandes
                                    </a></li>
                            @endif

                            @if (Auth()->user()->role == 'admin')
                                <li class="{{ $li_facture_a_valider }}"><a
                                        href="{{ route('facture.honoraire_a_valider') }}">
                                        @if ($nb > 0)
                                            <span class="badge badge-danger">{{ $nb }}</span>
                                        @endif Fac H à valider
                                    </a></li>
                                <li class="{{ $li_facture_a_payer }}"><a
                                        href="{{ route('facture.honoraire_a_payer') }}">
                                        @if ($nb_a_payer > 0)
                                            <span class="badge badge-warning">{{ $nb_a_payer }}</span>
                                        @endif Fac H à payer
                                    </a></li>
                                <li class="{{ $li_facture_hors_delais }}"><a
                                        href="{{ route('facture.hors_delais') }}"> Fac S hors délais </a></li>
                                <li class="{{ $li_facture_hors_delais }}"><a
                                        href="{{ route('facture.pub_a_valider') }}">
                                        @if ($nb_liste_pub > 0)
                                            <span class="badge badge-warning">{{ $nb_liste_pub }}</span>
                                        @endif Fac pub à valider
                                    </a></li>
                            @endif
                            {{-- <li><a href="#">Avoir</a></li> --}}
                        </ul>
                    </li>


                    @if (Auth()->user()->role == 'admin')
                        <li class="{{ $li_parametre }}"><a class="sidebar-sub-toggle"><i class="large material-icons"
                                    style="font-size:20px;">build</i> Paramètres <span
                                    class="sidebar-collapse-icon ti-angle-down"></span></a>
                            <ul>
                                {{-- <li><a href="page-login.html">Info Entreprise</a></li> --}}
                                <li class="{{ $li_parametre_generaux }}"><a
                                        href="{{ route('parametre_generaux.create') }}">Généraux</a></li>
                                <li class="{{ $li_parametre_pack_pub }}"><a
                                        href="{{ route('pack_pub.index') }}">Pack Pub</a></li>
                                <li class="{{ $li_parametre_modele }}"><a
                                        href="{{ route('modele_contrat.create') }}">Modèle contrat</a></li>
                                <li class="{{ $li_parametre_fournisseur }}"><a
                                        href="{{ route('fournisseur.index') }}">Fournisseur</a></li>
                                <li class="{{ $li_parametre_bareme_honoraire }}"><a
                                        href="{{ route('bareme_honoraire.index') }}">Barème d'honoraire</a></li>

                            </ul>
                        </li>

                        <li class=""><a href="{{ route('winfic.index') }}" class=""> <i
                                    class="large material-icons"
                                    style="font-size:20px;">vertical_align_center</i></i>Export WINFIC </a></li>
                        {{-- <li class=""><a  href="{{route('export_facture.index')}}" class=""> <i class="large material-icons" style="font-size:20px;">vertical_align_center</i></i>Export   </a> --}}
                        <li class=""><a href="{{ route('historique.index') }}" class=""> <i
                                    class="large material-icons" style="font-size:20px;">access_time</i></i>Historique
                            </a> </li>
                        {{-- <li class=""><a  href="{{route('etat_financier')}}" class=""> <i class="large material-icons" style="font-size:20px;">enhanced_encryption</i></i>Etat financier   </a></li> --}}
                        <li class="{{ $li_parametre_generaux }}"><a class="sidebar-sub-toggle"><i
                                    class="large material-icons" style="font-size:20px;">view_agenda</i> Agenda <span
                                    class="sidebar-collapse-icon ti-angle-down"></span></a>
                            <ul>
                                {{-- <li><a href="page-login.html">Info Entreprise</a></li> --}}
                                <li class="{{ $li_parametre_generaux }}"><a
                                        href="{{ route('agendas.index') }}">Gestion</a></li>

                            </ul>
                        </li>
                    @endif


                    @if (Auth()->user()->role == 'admin')
                        <li class="{{ $li_documents }}"><a class="sidebar-sub-toggle"><i
                                    class="large material-icons" style="font-size:20px;">vertical_align_bottom</i>
                                Documents @if ($nb_doc_a_valider > 0)
                                    <span class="badge badge-danger">{{ $nb_doc_a_valider }}
                                @endif
                                </span>
                                <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                            <ul>

                                <li class="{{ $li_documents_gestion }}"><a
                                        href="{{ route('document.index') }}">Gestion</a></li>
                                <li class="{{ $li_documents_a_valider }}"><a
                                        href="{{ route('document.a_valider') }}">A valider @if ($nb_doc_a_valider > 0)
                                            <span class="badge badge-danger">{{ $nb_doc_a_valider }}
                                        @endif
                                        </span> </a></li>

                            </ul>
                        </li>
                    @else
                        <li class="" style=" background:#144542"><a
                                href="{{ route('document.show', Crypt::encrypt(Auth::user()->id)) }} "> <i
                                    class="large material-icons"
                                    style="font-size:20px;">vertical_align_bottom</i></i>Mes documents </a></li>

                    @endif



                    @if (Auth()->user()->role == 'admin')
                        <li class="{{ $li_fournisseurs }}"><a class="sidebar-sub-toggle"><i
                                    class="large material-icons" style="font-size:20px;">business</i> Fournisseurs
                                <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                            <ul>

                                <li class="{{ $li_fournisseurs }}"><a
                                        href="{{ route('fournisseur.index') }}">Gestion</a></li>


                            </ul>
                        </li>
                    @endif




                    {{-- @if (Auth()->user()->role == 'admin') --}}
                    <li class=""><a href="{{ route('outil_calcul.index') }}"><i class="large material-icons"
                                style="font-size:20px;">iso</i> Outil de calcul </a></li>
                    {{-- @endif --}}

                    @if (Auth()->user()->role == 'admin')
                        <li class=""><a href="{{ route('outil_info.index') }}"><i class="large material-icons"
                                    style="font-size:20px;">computer</i> Outils informatique </a></li>
                    @endif

                    <li><a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();"><i
                                class="large material-icons" style="font-size:20px;">close</i></i> Déconnexion</a>
                    </li>

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
            <div class="logo"><a href="{{ route('home') }}">
                    <!-- <img src="assets/images/logo.png" alt="" /> --><span>Mini Curieux</span>
                </a></div>
            <div class="hamburger sidebar-toggle">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </div>
        </div>
        <div class="pull-right p-r-15">
            <ul>



                @if (Auth::user()->role == 'admin')
                    <li class="header-icon dib" style="background-color:#c31e3c; color:#fff"><i
                            class="ti-check-box">{{ \App\Agenda::nb_taches('a_faire') + \App\Agenda::nb_taches('en_retard') }}</i>
                        <div class="drop-down">
                            <div class="dropdown-content-heading">
                                <span class="text-left" style="font-weight: bold;"> Tâches</span>
                            </div>
                            <div class="dropdown-content-body">
                                <ul>



                                    <li>
                                        <a href="{{ route('agendas.listing_a_faire') }}">
                                            <img class="pull-left m-r-10 avatar-img"
                                                src="{{ asset('images/avatar/3.jpg') }}" alt="" />

                                            <div class="notification-content">
                                                <small class="notification-timestamp pull-right"> </small>

                                                <div class="notification-heading" style="color: rgb(13, 194, 58)">
                                                    &Agrave; Faire :
                                                    <span>{{ \App\Agenda::nb_taches('a_faire') }}</span>
                                                </div>

                                            </div>
                                        </a>
                                    </li>


                                    <li>
                                        <a href="{{ route('agendas.listing_en_retard') }}">
                                            <img class="pull-left m-r-10 avatar-img"
                                                src="{{ asset('images/avatar/3.jpg') }}" alt="" />
                                            <div class="notification-content">
                                                <small class="notification-timestamp pull-right"> </small>

                                                <div class="notification-heading" style="color: rgb(220, 20, 20)">En
                                                    retard : <span>{{ \App\Agenda::nb_taches('en_retard') }}</span>
                                                </div>

                                            </div>
                                        </a>
                                    </li>

                                    <li class="text-center">
                                        {{-- <a href="{{route('notifications.index')}}" class="more-link">Liste des tâches</a> --}}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                @endif

                <li class="header-icon dib"><i class="ti-bell"></i>
                    <div class="drop-down">
                        <div class="dropdown-content-heading">
                            <span class="text-left"> Notifications récentes</span>
                        </div>
                        <div class="dropdown-content-body">
                            <ul>

                                @foreach (Auth::user()->unReadNotifications as $key => $notification)
                                    <li>
                                        <a href="#">
                                            <img class="pull-left m-r-10 avatar-img"
                                                src="{{ asset('images/avatar/3.jpg') }}" alt="" />
                                            <div class="notification-content">
                                                <small
                                                    class="notification-timestamp pull-right">{{ $notification->created_at->format('d-m-Y à H:i') }}
                                                </small>

                                                <div class="notification-heading">{{ $notification->nom }}</div>
                                                <div class="notification-text"> {{ $notification->data['message'] }}
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    @if ($key > 5)
                                        @php break; @endphp
                                    @endif
                                @endforeach

                                <li class="text-center">
                                    <a href="{{ route('notifications.index') }}" class="more-link">Voir tout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>

                <li class="header-icon dib"><img class="avatar-img"
                        src="{{ asset('/images/avatar/' . (auth()->user()->civilite == 'Mme.' || auth()->user()->civilite == 'Mme' ? 'user_female.jpg ' : 'user_male.jpg')) }}"
                        alt="" /> <span class="user-avatar"> {{ auth()->user()->nom }}
                        {{ auth()->user()->prenom }}<i class="ti-angle-down f-s-10"></i></span>
                    <div class="drop-down dropdown-profile">

                        <div class="dropdown-content-body">
                            <ul>
                                <li><a href="{{ route('mandataire.show', Crypt::encrypt(Auth()->user()->id)) }}"><i
                                            class="ti-user"></i> <span>Mon Profil</span></a></li>
                                @if (session('is_switch') == true)
                                    <li><a href="{{ route('unswitch_user') }}" class="btn btn-success"><i
                                                class="ti-arrow-left"></i> <span>Retour ADMIN</span></a>
                                @endif
                </li>
                <li><a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();"><i
                            class="ti-power-off"></i> <span>Se déconnecter</span></a>
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
