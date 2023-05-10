@extends('layouts.app')
@section('content')
@section('page_title')
    Informations du contact
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-6">
                        <div class="panel panel-default lobipanel-basic">
                            <div class="panel-heading" style="background-color:#2b4457; border-color:#2b4457; color:#fff">
                                Informations du contact.</div>
                            <div class="panel-body">
                                <div class="card alert">
                                    <div class="card-body">
                                        <div class="user-profile">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="col-lg-12">
                                                        <div class="user-photo m-b-30">

                                                            @if ($contact->nature == 'Personne morale')
                                                                <i class="material-icons"
                                                                    style="font-size: 150px;color: #f0f0f0;background: #ab599c;border-radius: 27px;">
                                                                    corporate_fare
                                                                </i>
                                                            @elseif($contact->nature == 'Groupe')
                                                                <i class="material-icons"
                                                                    style="font-size: 150px;color: #f0f0f0;background: #ab599c;border-radius: 27px;">
                                                                    groups
                                                                </i>
                                                            @else
                                                                <i class="material-icons"
                                                                    style="font-size: 150px;color: #f0f0f0;background: #ab599c;border-radius: 27px;">
                                                                    contacts
                                                                </i>
                                                            @endif

                                                        </div>
                                                    </div>
                                                    <div class="user-work">
                                                        <h4 style="color: #32ade1;text-decoration: underline;">Statistiques
                                                        </h4>
                                                        <div class="work-content">
                                                            @if ($contact->est_partenaire)
                                                                <span class="badge badge-pink">Partenaire</span>
                                                            @endif

                                                            @if ($contact->est_acquereur)
                                                                <span class="badge badge-warning">Acquéreur</span>
                                                            @endif

                                                            @if ($contact->est_proprietaire)
                                                                <span class="badge badge-primary">Propriétaire</span>
                                                            @endif

                                                            @if ($contact->est_locataire)
                                                                <span class="badge badge-success">Locataire</span>
                                                            @endif

                                                            @if ($contact->est_notaire)
                                                                <span class="badge badge-danger">Notaire</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="user-skill">
                                                        <h4 style="color: #32ade1;text-decoration: underline;">Options</h4>
                                                        <a type="button"
                                                            href="{{ route('contact.edit', Crypt::encrypt($contact->id)) }}"
                                                            class="btn btn-warning btn-rounded btn-addon btn-xs m-b-10"><i
                                                                class="ti-pencil"></i>Modifier</a>
                                                        <a type="button" data-toggle="modal"
                                                            data-target="#entite_attache_individu"
                                                            class="btn btn-info btn-rounded btn-addon btn-xs m-b-10"><i
                                                                class="ti-key"></i>Associer des individus</a>
                                                        {{-- <a type="button" data-toggle="modal" data-target="#planifiate_usr" class="btn btn-danger btn-rounded btn-addon btn-xs m-b-10"><i class="ti-email"></i>Envoyer un email</a> --}}
                                                    </div>
                                                </div>
                                                <div class="col-lg-8">
                                                    <div class="user-profile-name" style="color: #d68300;">
                                                        {{ $contact->entite->raison_sociale }}</div>
                                                    <div class="user-Location"><i class="ti-location-pin"></i>
                                                        {{ $contact->entite->ville }}</div>

                                                    <div class="custom-tab user-profile-tab">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            <li role="presentation" class="active"><a href="#1"
                                                                    aria-controls="1" role="tab"
                                                                    data-toggle="tab">Détails</a></li>
                                                        </ul>
                                                        <div class="tab-content">
                                                            <div role="tabpanel" class="tab-pane active" id="1">
                                                                <div class="contact-information">
                                                                    <div class="phone-content">
                                                                        <span
                                                                            class="contact-title"><strong>Téléphone:</strong></span>
                                                                        <span class="phone-number"
                                                                            style="color: #ff435c; ">{{ $contact->entite->telephone_fixe }}
                                                                            - {{ $contact->entite->telephone_fixe }}</span>
                                                                    </div>
                                                                    <div class="address-content">
                                                                        <span
                                                                            class="contact-title"><strong>Adresse:</strong></span>
                                                                        <span
                                                                            class="mail-address">{{ $contact->entite->adresse }}</span>
                                                                    </div>
                                                                    <div class="website-content">
                                                                        <span class="contact-title"><strong>Code
                                                                                postal:</strong></span>
                                                                        <span
                                                                            class="contact-website">{{ $contact->entite->code_postal }}</span>
                                                                    </div>
                                                                    <div class="website-content">
                                                                        <span
                                                                            class="contact-title"><strong>Ville:</strong></span>
                                                                        <span
                                                                            class="contact-website">{{ $contact->entite->ville }}</span>
                                                                    </div>
                                                                    <div class="email-content">
                                                                        <span
                                                                            class="contact-title"><strong>Email:</strong></span>
                                                                        <span class="contact-email"
                                                                            style="color: #ff435c; text-decoration: underline;">{{ $contact->entite->email }}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="basic-information">
                                                                    <h4 style="color: #32ade1;text-decoration: underline;">
                                                                        Informations juridiques</h4>
                                                                    <div class="birthday-content">
                                                                        <span
                                                                            class="contact-title"><strong>Personnalité:</strong></span>
                                                                        @if ($contact->entite->sous_type === 'personne_simple' || $contact->entite->sous_type === 'couple')
                                                                            <span class="birth-date"><span
                                                                                    class="badge badge-success">{{ $contact->entite->sous_type }}</span></span>
                                                                        @else
                                                                            <span class="birth-date"><span
                                                                                    class="badge badge-warning">{{ $contact->entite->sous_type }}</span></span>
                                                                        @endif
                                                                    </div>
                                                                    <div class="gender-content">
                                                                        <span class="contact-title"><strong>Ajout
                                                                                le:</strong></span>
                                                                        <span
                                                                            class="gender">{{ date('d/m/Y', strtotime($contact->entite->created_at)) }}</span>
                                                                    </div>
                                                                    @if ($contact->entite->sous_type != 'personne_simple' && $contact->entite->sous_type != 'couple')
                                                                        <div class="address-content">
                                                                            <span class="contact-title"><strong>Forme
                                                                                    juridique:</strong></span>
                                                                            <span
                                                                                class="mail-address">{{ $contact->entite->forme_juridique }}</span>
                                                                        </div>
                                                                        <div class="address-content">
                                                                            <span class="contact-title"><strong>Numéro
                                                                                    SIRET:</strong></span>
                                                                            <span
                                                                                class="mail-address">{{ $contact->entite->numero_siret }}</span>
                                                                        </div>
                                                                        <div class="address-content">
                                                                            <span class="contact-title"><strong>Numéro
                                                                                    TVA:</strong></span>
                                                                            <span
                                                                                class="mail-address">{{ $contact->entite->numero_tva }}</span>
                                                                        </div>
                                                                        <div class="address-content">
                                                                            <span class="contact-title"><strong>Numéro
                                                                                    RCS:</strong></span>
                                                                            <span
                                                                                class="mail-address">{{ $contact->entite->numero_rcs }}</span>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="panel panel-default lobipanel-basic">
                            <div class="panel-heading" style="background-color:#43471f; border-color:#43471f; color:#fff">
                                Biens attachés au contact.</div>
                            <div class="panel-body">
                                <div class="card alert">
                                    <div class="card-body">
                                        <div class="user-profile">
                                            <div class="row">

                                                <div class="container-biens">


                                                    @foreach ($contact->biens as $bien)
                                                        <div class="item-bien">
                                                            <div>
                                                                @foreach ($bien->photosbiens as $photos)
                                                                    @if ($photos->visibilite == 'visible' && $photos->image_position == 1)
                                                                        <img src="{{ asset('images/photos_bien/' . $photos->filename) }}"
                                                                            width="200px" height="150px" alt="">
                                                                        @php break; @endphp
                                                                    @endif
                                                                @endforeach
                                                            </div>

                                                            <div>
                                                                <h4>
                                                                    <b> {{ $bien->type_bien }}</b>
                                                                    @if ($bien->type_bien != 'terrain')
                                                                        - {{ $bien->nombre_piece }} @lang('pièces') <br>
                                                                        - {{ $bien->surface_habitable }} @lang('m²')
                                                                    @endif

                                                                </h4>

                                                                <h5> {{ $bien->ville }} ({{ $bien->code_postal }})</h5>

                                                                @if ($bien->type_offre == 'vente')
                                                                    <h4><b> <span style="color:blue">
                                                                                {{ $bien->prix_public }}@lang('€')</b>
                                                                        </span>
                                                                    </h4>
                                                                @else
                                                                    <h4><b> <span style="color:blue">{{ $bien->loyer }}
                                                                                @lang('€')</b>
                                                                        </span> </h4>
                                                                @endif
                                                                <h6>@lang('Ajouté le '){{ $bien->created_at->format('d-m-Y') }}
                                                                </h6>
                                                                </h5>

                                                            </div>

                                                            <div>

                                                                <a href="{{ route('bien.show', Crypt::encrypt($bien->id)) }}"
                                                                    title="@lang('Détails') {{ $bien->nom }}">
                                                                    <img src="{{ asset('images/fleche-direction.png') }}"
                                                                        width="50px" height="55px" alt="">
                                                                </a>

                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-6">
                        <div class="panel panel-default lobipanel-basic">
                            <div class="panel-heading">Individus associés.</div>
                            <div class="panel-body">
                                <div class="table-responsive" style="overflow-x: inherit !important;">
                                    <table id="entite_individu" class=" table student-data-table  m-t-20 table-hover"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>@lang('Infos contact')</th>
                                                <th>@lang('Adresse')</th>
                                                <th>@lang('Actions')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($contact->entite->individus as $cont)
                                                <tr>


                                                    <td style=" min-width: 120px; border-top: 4px solid #b8c7ca;">
                                                        @if ($cont->contact->nature == 'Personne morale')
                                                            <img class="img-thumbnail"
                                                                style=" width: 50px; height: 50px; border: 2px solid #8ba2ad;  border-radius: 20px; padding: 3px;"
                                                                src="{{ asset('/images/photo_profile/' . 'entreprise.png') }}"
                                                                alt="" />
                                                            <p>
                                                                <span style="font-size: 18px; font-weigth:bold;">
                                                                    {{ $cont->entite->forme_juridique }} </span>
                                                                <span
                                                                    style="font-size: 18px; font-weigth:bold; color:#8031db">
                                                                    {{ $cont->entite->raison_sociale }}</span>
                                                            </p>
                                                        @elseif($cont->contact->nature == 'Personne seule')
                                                            <img class="img-thumbnail"
                                                                style=" width: 50px; height: 50px; border: 2px solid #8ba2ad;  border-radius: 20px; padding: 3px;"
                                                                src="{{ asset('/images/photo_profile/' . 'user1.png') }}"
                                                                alt="" />
                                                            <p>
                                                                <span style="font-size: 18px; font-weigth:bold;">
                                                                    {{ $cont->civilite }} </span>
                                                                <span
                                                                    style="font-size: 18px; font-weigth:bold; color:#8031db">{{ $cont->prenom }}
                                                                    {{ $cont->nom }}</span>
                                                            </p>
                                                        @elseif($cont->contact->nature == 'Groupe')
                                                            <img class="img-thumbnail"
                                                                style=" width: 50px; height: 50px; border: 2px solid #8ba2ad;  border-radius: 20px; padding: 3px;"
                                                                src="{{ asset('/images/photo_profile/' . 'groupe.svg') }}"
                                                                alt="" />
                                                            <p>
                                                                <span style="font-size: 18px; font-weigth:bold;">
                                                                    {{ $cont->entite->type }} </span>

                                                                <span
                                                                    style="font-size: 18px; font-weigth:bold; color:#8031db">
                                                                    {{ $cont->entite->nom }} </span>
                                                            </p>
                                                        @elseif($cont->contact->nature == 'Couple')
                                                            <img class="img-thumbnail"
                                                                style=" width: 50px; height: 50px; border: 2px solid #8ba2ad;  border-radius: 20px; padding: 3px;"
                                                                src="{{ asset('/images/photo_profile/' . 'couple.png') }}"
                                                                alt="" />
                                                            <p>
                                                                <span style="font-size: 18px; font-weigth:bold;">
                                                                    {{ $cont->civilite1 }} /
                                                                    {{ $cont->civilite2 }} </span> <br>
                                                                <span
                                                                    style="font-size: 18px; font-weigth:bold; color:#8031db">
                                                                    {{ $cont->nom1 }} /
                                                                    {{ $cont->nom2 }} </span>
                                                            </p>
                                                        @else
                                                            <img class="img-thumbnail"
                                                                style=" width: 50px; height: 50px; border: 2px solid #8ba2ad;  border-radius: 20px; padding: 3px;"
                                                                src="{{ asset('/images/photo_profile/' . 'contact.jpg') }}"
                                                                alt="" />
                                                        @endif
                                                    </td>




                                                    @if ($cont->contact->nature == 'Personne morale')
                                                        <td style=" min-width: 120px; border-top: 4px solid #b8c7ca;">
                                                            <p>
                                                                <span style=" font-weigth:bold;">
                                                                    {{ $cont->entite->email }} </span> <br>
                                                                <span style=" font-weigth:bold;">
                                                                    {{ $cont->entite->telephone_fixe }} - </span> <span
                                                                    style="font-weigth:bold;">
                                                                    {{ $cont->entite->telephone_mobile }} </span> <br>
                                                            </p>
                                                        </td>

                                                        <td style=" min-width: 120px; border-top: 4px solid #b8c7ca;">
                                                            <p>
                                                                <span style=" font-weigth:bold;">
                                                                    {{ $cont->entite->adresse }} </span> <br>
                                                                <span style=" font-weigth:bold;">
                                                                    {{ $cont->entite->code_postal }} - </span> <span
                                                                    style="font-weigth:bold;"> {{ $cont->entite->ville }}
                                                                </span> <br>
                                                            </p>
                                                        </td>
                                                    @elseif($cont->contact->nature == 'Personne seule')
                                                        <td style=" min-width: 120px; border-top: 4px solid #b8c7ca;">
                                                            <p>
                                                                <span style=" font-weigth:bold;">
                                                                    {{ $cont->email }} </span> <br>
                                                                <span style=" font-weigth:bold;">
                                                                    {{ $cont->telephone_fixe }} - </span> <span
                                                                    style="font-weigth:bold;">
                                                                    {{ $cont->telephone_mobile }} </span> <br>
                                                            </p>
                                                        </td>

                                                        <td style=" min-width: 120px; border-top: 4px solid #b8c7ca;">
                                                            <p>
                                                                <span style=" font-weigth:bold;">
                                                                    {{ $cont->adresse }} </span> <br>
                                                                <span style=" font-weigth:bold;">
                                                                    {{ $cont->code_postal }} - </span> <span
                                                                    style="font-weigth:bold;">
                                                                    {{ $cont->ville }} </span> <br>
                                                            </p>
                                                        </td>
                                                    @elseif($cont->contact->nature == 'Groupe')
                                                        <td style=" min-width: 120px; border-top: 4px solid #b8c7ca;">
                                                            <p>
                                                                <span style=" font-weigth:bold;">
                                                                    {{ $cont->email }} </span> <br>
                                                                <span style=" font-weigth:bold;">
                                                                    {{ $cont->telephone_fixe }} - </span> <span
                                                                    style="font-weigth:bold;">
                                                                    {{ $cont->telephone_mobile }} </span> <br>
                                                            </p>
                                                        </td>

                                                        <td style=" min-width: 120px; border-top: 4px solid #b8c7ca;">
                                                            <p>
                                                                <span style=" font-weigth:bold;">
                                                                    {{ $cont->adresse }} </span> <br>
                                                                <span style=" font-weigth:bold;">
                                                                    {{ $cont->code_postal }} - </span> <span
                                                                    style="font-weigth:bold;">
                                                                    {{ $cont->ville }} </span> <br>
                                                            </p>
                                                        </td>

                                                        <td style=" min-width: 120px; border-top: 4px solid #b8c7ca;">

                                                        </td>
                                                    @elseif($cont->contact->nature == 'Couple')
                                                        <td style=" min-width: 120px; border-top: 4px solid #b8c7ca;">
                                                            <p>
                                                                <span style=" font-weigth:bold;">
                                                                    {{ $cont->email1 }} /
                                                                    {{ $cont->email2 }}</span> <br>
                                                                <span style=" font-weigth:bold;">
                                                                    {{ $cont->telephone_fixe1 }} - </span> <span
                                                                    style="font-weigth:bold;">
                                                                    {{ $cont->telephone_mobile1 }} </span> /
                                                                <span style=" font-weigth:bold;">
                                                                    {{ $cont->telephone_fixe2 }} - </span> <span
                                                                    style="font-weigth:bold;">
                                                                    {{ $cont->telephone_mobile2 }} </span> <br>
                                                            </p>
                                                        </td>

                                                        <td style=" min-width: 120px; border-top: 4px solid #b8c7ca;">
                                                            <p>
                                                                <span style=" font-weigth:bold;">
                                                                    {{ $cont->adresse }} </span> <br>
                                                                <span style=" font-weigth:bold;">
                                                                    {{ $cont->code_postal }} - </span> <span
                                                                    style="font-weigth:bold;">
                                                                    {{ $cont->ville }} </span> <br>
                                                            </p>
                                                        </td>
                                                    @else
                                                    @endif



                                                    {{-- <td style="border-top: 4px solid #b8c7ca;">
                                                        <span><a class="show1"
                                                                href="{{ route('contact.show', Crypt::encrypt($cont->id)) }}"
                                                                title="@lang('Détails')"><i
                                                                    class="large material-icons color-info">visibility</i></a></span>
                                                        <span><a class="show1"
                                                                href="{{ route('contact.edit', Crypt::encrypt($cont->id)) }}"
                                                                title="@lang('modifier')"><i
                                                                    class="large material-icons color-success">edit</i></a></span>
                                                        <span><a href="#" class="archive_notaire"
                                                                data-toggle="tooltip" title="@lang('Archiver')"><i
                                                                    class="large material-icons color-danger">delete</i></a></span>
                                                    </td> --}}

                                                    <td style="border-top: 4px solid #b8c7ca;">
                                                        <span><a class="show1"
                                                                href="{{ route('contact.show', Crypt::encrypt($cont->contact->id)) }}"
                                                                title="@lang('Détails')"><i
                                                                    class="large material-icons color-info">visibility</i></a></span>
                                                        <span>
                                                            <a data-href="{{ route('contact.detach', [Crypt::encrypt($contact->entite->id), Crypt::encrypt($cont->id)]) }}"
                                                                class="dissociate_individu" data-toggle="tooltip"
                                                                title="@lang('Dissocier')" style="cursor: pointer;">
                                                                <i class="large material-icons color-danger">clear</i>
                                                            </a>
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('components.contact.entite_edit')
    @include('components.contact.attache_individu')
@stop
@section('js-content')
    <script src="{{ asset('js/autocomplete_cp_ville.js') }}"></script>
    <script src={{ 'https://code.jquery.com/ui/1.13.2/jquery-ui.js' }}></script>


    <script>
        $(document).ready(function() {
            $('#entite_individu').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
                }
            });
        });
    </script>


    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $('[data-toggle="tooltip"]').tooltip()


            $('body').on('click', 'a.dissociate_individu', function(e) {
                let that = $(this)
                e.preventDefault()
                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                    title: 'Le contact sera dissocié, continuer ?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: '@lang('Oui')',
                    cancelButtonText: '@lang('Non')',

                }).then((result) => {
                    if (result.value) {

                        $.ajax({
                                type: "GET",
                                // url: "{{ route('document.create') }}",
                                url: that.attr('data-href'),

                                // data: data,
                                success: function(data) {

                                    swal(
                                        'Terminé',
                                        'Contact associé\n ',
                                        'success'
                                    )



                                },
                                error: function(data) {
                                    console.log(data);

                                    swal(
                                        'Echec',
                                        'Le contact n\'a pas été associé :)',
                                        'error'
                                    );
                                }
                            })
                            .done(function() {
                                that.parents('tr').remove()
                            });




                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons(
                            'Annulé',
                            'Le contact n\'a pas été associé :)',
                            'error'
                        )
                    }
                })
            })
        })
    </script>
    <!--ajax individu association-->
    <script>
        $(document).ready(function() {
            $('#ajax_individus').hide();
            $('#individu_tps').on('change', function(e) {
                if ($('#individu_tps').is(':checked')) {
                    $('#ajax_individus').show();
                    $('#mvc55').hide()
                } else {
                    $('#ajax_individus').hide();
                    $('#mvc55').show();
                }
            });
        });
    </script>
    <!--fin ajax individus-->


    <script>
        $(document).ready(function() {
            $(".div_proprietaire").show();
            $(".div_partenaire").hide();

            $(".div_personne_seule").show();
            $(".div_personne_morale").hide();
            $(".div_personne_couple").hide();
            $(".div_personne_groupe").hide();



            $('#statut').change(function(e) {
                let statut = e.currentTarget.value;
                if (statut != "Partenaire") {
                    $(".div_proprietaire").show();
                    $(".div_partenaire").hide();
                } else {
                    $(".div_proprietaire").hide();
                    $(".div_partenaire").show();
                }
            });

            $("input[type='radio']").click(function(e) {

                let nature = e.currentTarget.value;

                // if (nature == "Personne morale") {

                //     $("input[type='text']").removeAttr("required");
                //     $("select").removeAttr("required");
                //     $("#type").val("entité");

                //     $(".div_personne_seule").hide();
                //     $(".div_personne_morale").show();
                //     $(".div_personne_couple").hide();
                //     $(".div_personne_groupe").hide();
                //     $(".div_personne_tout").show();

                //     $("#forme_juridique").attr("required", "required");
                //     $("#raison_sociale").attr("required", "required");
                //     $("#email").attr("required", "required");

                // } 
                if (nature == "Personne seule") {
                    $("input[type='text']").removeAttr("required");
                    $("input[type='email']").removeAttr("required");
                    $("select").removeAttr("required");

                    $(".div_personne_seule").show();
                    $(".div_personne_morale").hide();
                    $(".div_personne_couple").hide();
                    $(".div_personne_groupe").hide();
                    $(".div_personne_tout").show();

                    $("#civilite").attr("required", "required");
                    $("#nom").attr("required", "required");
                    $("#prenom").attr("required", "required");
                    $("#email").attr("required", "required");

                    $("#type").val("individu");


                } else if (nature == "Couple") {
                    $("input[type='text']").removeAttr("required");
                    $("input[type='email']").removeAttr("required");
                    $("select").removeAttr("required");

                    $(".div_personne_seule").hide();
                    $(".div_personne_morale").hide();
                    $(".div_personne_couple").show();
                    $(".div_personne_groupe").hide();
                    $(".div_personne_tout").hide();

                    $("#civilite1").attr("required", "required");
                    $("#nom1").attr("required", "required");
                    $("#prenom1").attr("required", "required");
                    $("#email1").attr("required", "required");

                    $("#civilite2").attr("required", "required");
                    $("#nom2").attr("required", "required");
                    $("#prenom2").attr("required", "required");
                    $("#email2").attr("required", "required");

                    $("#type").val("individu");

                }
                // else if (nature == "Groupe") {
                //     $("input[type='text']").removeAttr("required");
                //     $("select").removeAttr("required");

                //     $(".div_personne_seule").hide();
                //     $(".div_personne_morale").hide();
                //     $(".div_personne_couple").hide();
                //     $(".div_personne_tout").show();
                //     $(".div_personne_groupe").show();


                //     $("#nom_groupe").attr("required", "required");
                //     $("#email").attr("required", "required");
                //     $("#type").val("entité");

                // }

            });


        });
    </script>


    {{-- //   Auto complète adresses  --}}
    <script>
        $("#code_postal").autocomplete({
            source: function(request, response) {
                $.ajax({
                    beforeSend: function() {},
                    url: "https://api-adresse.data.gouv.fr/search/?postcode=" + $(
                        "input[name='code_postal']").val(),
                    data: {
                        q: request.term
                    },
                    dataType: "json",
                    success: function(data) {
                        var postcodes = [];
                        response($.map(data.features, function(item) {
                            // Ici on est obligé d'ajouter les CP dans un array pour ne pas avoir plusieurs fois le même
                            if ($.inArray(item.properties.city, postcodes) == -1) {
                                postcodes.push(item.properties.postcode);
                                return {
                                    label: item.properties.postcode + " - " + item
                                        .properties.city,
                                    city: item.properties.city,
                                    value: item.properties.postcode
                                };
                            }
                        }));
                    }
                });
            },
            // On remplit aussi la ville
            select: function(event, ui) {
                $('#ville').val(ui.item.city);
            }
        });
        $("#ville").autocomplete({

            source: function(request, response) {
                $.ajax({
                    beforeSend: function() {},
                    url: "https://api-adresse.data.gouv.fr/search/?city=" + $("input[name='ville']")
                        .val(),
                    data: {
                        q: request.term
                    },
                    dataType: "json",
                    success: function(data) {
                        var cities = [];

                        response($.map(data.features, function(item) {
                            // Ici on est obligé d'ajouter les villes dans un array pour ne pas avoir plusieurs fois la même
                            if ($.inArray(item.properties.postcode, cities) == -1) {
                                cities.push(item.properties.postcode);
                                return {
                                    label: item.properties.postcode + " - " + item
                                        .properties.city,
                                    postcode: item.properties.postcode,
                                    value: item.properties.city
                                };
                            }
                        }));
                    }
                });
            },
            // On remplit aussi le CP
            select: function(event, ui) {
                $('#code_postal').val(ui.item.postcode);
            }

        });
        $("#adresse").autocomplete({
            source: function(request, response) {
                $.ajax({
                    beforeSend: function() {},
                    url: "https://api-adresse.data.gouv.fr/search/?postcode=" + $(
                        "input[name='code_postal']").val(),
                    data: {
                        q: request.term
                    },
                    dataType: "json",
                    success: function(data) {
                        response($.map(data.features, function(item) {
                            return {
                                label: item.properties.name,
                                value: item.properties.name
                            };
                        }));
                    }
                });
            }
        });
    </script>




    <script>
        function autocomplete(inp, arr) {


            /*the autocomplete function takes two arguments,
            the text field element and an array of possible autocompleted values:*/
            var currentFocus;
            /*execute a function when someone writes in the text field:*/
            inp.addEventListener("input", function(e) {
                var a, b, i, val = this.value;
                /*close any already open lists of autocompleted values*/
                closeAllLists();
                if (!val) {
                    return false;
                }
                currentFocus = -1;
                /*create a DIV element that will contain the items (values):*/
                a = document.createElement("DIV");
                a.setAttribute("id", this.id + "autocomplete-list");
                a.setAttribute("class", "autocomplete-items");
                /*append the DIV element as a child of the autocomplete container:*/
                this.parentNode.appendChild(a);
                /*for each item in the array...*/
                for (i = 0; i < arr.length; i++) {
                    /*check if the item starts with the same letters as the text field value:*/
                    if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                        /*create a DIV element for each matching element:*/
                        b = document.createElement("DIV");
                        /*make the matching letters bold:*/
                        b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                        b.innerHTML += arr[i].substr(val.length);
                        /*insert a input field that will hold the current array item's value:*/
                        b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                        /*execute a function when someone clicks on the item value (DIV element):*/
                        b.addEventListener("click", function(e) {
                            /*insert the value for the autocomplete text field:*/
                            inp.value = this.getElementsByTagName("input")[0].value;
                            /*close the list of autocompleted values,
                            (or any other open lists of autocompleted values:*/
                            closeAllLists();
                        });
                        a.appendChild(b);
                    }
                }
            });
            /*execute a function presses a key on the keyboard:*/
            inp.addEventListener("keydown", function(e) {
                var x = document.getElementById(this.id + "autocomplete-list");
                if (x) x = x.getElementsByTagName("div");
                if (e.keyCode == 40) {
                    /*If the arrow DOWN key is pressed,
                    increase the currentFocus variable:*/
                    currentFocus++;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 38) { //up
                    /*If the arrow UP key is pressed,
                    decrease the currentFocus variable:*/
                    currentFocus--;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 13) {
                    /*If the ENTER key is pressed, prevent the form from being submitted,*/
                    e.preventDefault();
                    if (currentFocus > -1) {
                        /*and simulate a click on the "active" item:*/
                        if (x) x[currentFocus].click();
                    }
                }
            });

            function addActive(x) {
                /*a function to classify an item as "active":*/
                if (!x) return false;
                /*start by removing the "active" class on all items:*/
                removeActive(x);
                if (currentFocus >= x.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = (x.length - 1);
                /*add class "autocomplete-active":*/
                x[currentFocus].classList.add("autocomplete-active");
            }

            function removeActive(x) {
                /*a function to remove the "active" class from all autocomplete items:*/
                for (var i = 0; i < x.length; i++) {
                    x[i].classList.remove("autocomplete-active");
                }
            }

            function closeAllLists(elmnt) {
                /*close all autocomplete lists in the document,
                except the one passed as an argument:*/
                var x = document.getElementsByClassName("autocomplete-items");
                for (var i = 0; i < x.length; i++) {
                    if (elmnt != x[i] && elmnt != inp) {
                        x[i].parentNode.removeChild(x[i]);
                    }
                }
            }
            /*execute a function when someone clicks in the document:*/
            document.addEventListener("click", function(e) {
                closeAllLists(e.target);
            });
        }

        /*An array containing all the country names in the world:*/
        // var countries = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia & Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central Arfrican Republic","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauro","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","North Korea","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre & Miquelon","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain","Sri Lanka","St Kitts & Nevis","St Lucia","St Vincent","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad & Tobago","Tunisia","Turkey","Turkmenistan","Turks & Caicos","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States of America","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];

        var countries = ["Afghanistan", "Afrique du Sud", "Albanie", "Algérie", "Allemagne", "Andorre", "Angola",
            "Anguilla", "Arabie Saoudite", "Argentine", "Arménie", "Australie", "Autriche", "Azerbaidjan", "Bahamas",
            "Bangladesh", "Barbade", "Bahrein", "Belgique", "Bélize", "Bénin", "Biélorussie", "Bolivie", "Botswana",
            "Bhoutan", "Boznie-Herzégovine", "Brésil", "Brunei", "Bulgarie", "Burkina Faso", "Burundi", "Cambodge",
            "Cameroun", "Canada", "Cap-Vert", "Chili", "Chine", "Chypre", "Colombie", "Comores", "République du Congo",
            "République Démocratique du Congo", "Corée du Nord", "Corée du Sud", "Costa Rica", "Côte d’Ivoire",
            "Croatie", "Cuba", "Danemark", "Djibouti", "Dominique", "Egypte", "Emirats Arabes Unis", "Equateur",
            "Erythrée", "Espagne", "Estonie", "Etats-Unis d’Amérique", "Ethiopie", "Fidji", "Finlande", "France",
            "Gabon", "Gambie", "Géorgie", "Ghana", "Grèce", "Grenade", "Guatémala", "Guinée", "Guinée Bissau",
            "Guinée Equatoriale", "Guyana", "Haïti", "Honduras", "Hongrie", "Inde", "Indonésie", "Iran", "Iraq",
            "Irlande", "Islande", "Israël", "italie", "Jamaïque", "Japon", "Jordanie", "Kazakhstan", "Kenya",
            "Kirghizistan", "Kiribati", "Koweït", "Laos", "Lesotho", "Lettonie", "Liban", "Liberia", "Liechtenstein",
            "Lituanie", "Luxembourg", "Lybie", "Macédoine", "Madagascar", "Malaisie", "Malawi", "Maldives", "Mali",
            "Malte", "Maroc", "Marshall", "Maurice", "Mauritanie", "Mexique", "Micronésie", "Moldavie", "Monaco",
            "Mongolie", "Mozambique", "Namibie", "Nauru", "Nepal", "Nicaragua", "Niger", "Nigéria", "Nioué", "Norvège",
            "Nouvelle Zélande", "Oman", "Ouganda", "Ouzbékistan", "Pakistan", "Palau", "Palestine", "Panama",
            "Papouasie Nouvelle Guinée", "Paraguay", "Pays-Bas", "Pérou", "Philippines", "Pologne", "Portugal", "Qatar",
            "République centrafricaine", "République Dominicaine", "République Tchèque", "Roumanie", "Royaume Uni",
            "Russie", "Rwanda", "Saint-Christophe-et-Niévès", "Sainte-Lucie", "Saint-Marin",
            "Saint-Vincent-et-les Grenadines", "Iles Salomon", "Salvador", "Samoa Occidentales", "Sao Tomé et Principe",
            "Sénégal", "Serbie", "Seychelles", "Sierra Léone", "Singapour", "Slovaquie", "Slovénie", "Somalie",
            "Soudan", "Sri Lanka", "Suède", "Suisse", "Suriname", "Swaziland", "Syrie", "Tadjikistan", "Taiwan",
            "Tanzanie", "Tchad", "Thailande", "Timor Oriental", "Togo", "Tonga", "Trinité et Tobago", "Tunisie",
            "Turkménistan", "Turquie", "Tuvalu", "Ukraine", "Uruguay", "Vanuatu", "Vatican", "Vénézuela", "Vietnam",
            "Yemen", "Zambie", "Zimbabwe"
        ]
        /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
        autocomplete(document.getElementById("pays"), countries);
    </script>

@endsection
