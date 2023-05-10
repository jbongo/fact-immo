@extends('layouts.app')
@section('content')
@section('page_title')
    Liste des passerelles
@endsection

<style>
    .actif {
        color: #DAA520;
    }

    .non_actif {
        color: darkgreen;
    }
</style>
<div class="row">

    <div class="col-lg-12">
        @if (session('ok'))
            <div class="alert alert-success alert-dismissible fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <a href="#" class="alert-link"><strong> {{ session('ok') }}</strong></a>
            </div>
        @endif
        <div class="card alert">
            <!-- table -->
            <a href="{{ route('passerelle.add') }}" class="btn btn-success btn-flat btn-addon m-b-10 m-l-5"><i
                    class="ti-home"></i>@lang('Ajouter une passerelle')</a>

            <div class="card-body">
                <div class="table-responsive" style="overflow-x: inherit !important;">
                    <table id="example3" class=" table student-data-table  m-t-20 " style="width:100%">
                        <thead>
                            <tr>
                                <th>@lang('AVEC ABONNEMENT')</th>

                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>
                                    <div class="row">
                                        @foreach ($passerelles as $passerelle)
                                            @if ($passerelle->type == 'Avec abonnement')
                                                <div class="col-lg-2 col-md-4 col-sm-4">

                                                    <a class="btn btn-lg info_pass" href="#"
                                                        id="{{ $passerelle->id }}" data-toggle="modal"
                                                        data-target="#add-category" title="@lang('Modifier la passerelle ') ">
                                                        <img src="{{ asset('images/passerelles/' . $passerelle->logo) }}"
                                                            width="150px" height="100px" alt="">
                                                    </a>
                                                    <p>
                                                        <a href="{{ route('passerelle.delete', $passerelle->id) }}"
                                                            class="delete" data-toggle="tooltip"
                                                            title="@lang('Supprimer la passerelle')"><i
                                                                class="material-icons">delete_forever</i> </a>
                                                        <a href="{{ route('passerelle.edit', $passerelle->id) }}"
                                                            title="@lang('Modifier la passerelle')"><i class="material-icons">edit</i>
                                                        </a>

                                                        @if ($passerelle->statut == 1)
                                                            <a href="{{ route('passerelle.statut', [$passerelle->id, 0]) }}"
                                                                class="statut" title="@lang('Désactiver la passerelle')"><i
                                                                    class="material-icons">block</i> </a>

                                                            <span class="actif"> @lang('actif')</span>
                                                        @else
                                                            <a href="{{ route('passerelle.statut', [$passerelle->id, 1]) }}"
                                                                class="statut" title="@lang('Activer la passerelle')"><i
                                                                    class="material-icons">redo</i> </a>
                                                            <span class="non_actif"> @lang('non actif') </span>
                                                        @endif
                                                    </p>

                                                </div>
                                            @endif
                                        @endforeach
                                    </div>

                                </td>

                            </tr>

                        </tbody>
                    </table>
                </div>
                <hr>
                <hr>
                <hr>
                <hr>

                <div class="table-responsive" style="overflow-x: inherit !important;">
                    <table id="example2" class=" table student-data-table  m-t-20 " style="width:100%">
                        <thead>
                            <tr>
                                <th>@lang('SANS ABONNEMENT')</th>

                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>
                                    <div class="row">
                                        @foreach ($passerelles as $passerelle)
                                            @if ($passerelle->type == 'Sans abonnement')
                                                <div class="col-lg-2 col-md-4 col-sm-4">

                                                    <a class="btn btn-lg info_pass" href="#"
                                                        id="{{ $passerelle->id }}" data-toggle="modal"
                                                        data-target="#add-category" title="@lang('Modifier la passerelle ') ">
                                                        <img src="{{ asset('images/passerelles/' . $passerelle->logo) }}"
                                                            width="150px" height="100px" alt="">
                                                    </a>
                                                    <p>
                                                        <a href="{{ route('passerelle.delete', $passerelle->id) }}"
                                                            class="delete" data-toggle="tooltip"
                                                            title="@lang('Supprimer la passerelle')"><i
                                                                class="material-icons">delete_forever</i> </a>
                                                        <a href="{{ route('passerelle.edit', $passerelle->id) }}"
                                                            title="@lang('Modifier la passerelle')"><i
                                                                class="material-icons">edit</i> </a>

                                                        @if ($passerelle->statut == 1)
                                                            <a href="{{ route('passerelle.statut', [$passerelle->id, 0]) }}"
                                                                class="statut" title="@lang('Désactiver la passerelle')"><i
                                                                    class="material-icons">block</i> </a>

                                                            <span class="actif"> @lang('actif')</span>
                                                        @else
                                                            <a href="{{ route('passerelle.statut', [$passerelle->id, 1]) }}"
                                                                class="statut" title="@lang('Activer la passerelle')"><i
                                                                    class="material-icons">redo</i> </a>
                                                            <span class="non_actif"> @lang('non actif') </span>
                                                        @endif
                                                    </p>

                                                </div>
                                            @endif
                                        @endforeach
                                    </div>

                                </td>

                            </tr>

                        </tbody>
                    </table>
                </div>

                <hr>
                <hr>
                <hr>
                <hr>

                <div class="table-responsive" style="overflow-x: inherit !important;">
                    <table id="example" class=" table student-data-table  m-t-20 " style="width:100%">
                        <thead>
                            <tr>
                                <th>@lang('INSTITUTIONNELLE ET PARTENAIRE')</th>

                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>
                                    <div class="row">
                                        @foreach ($passerelles as $passerelle)
                                            @if ($passerelle->type == 'Institutionnelle et partenaire')
                                                <div class="col-lg-2 col-md-4 col-sm-4">

                                                    <a class="btn btn-lg info_pass" href="#"
                                                        id="{{ $passerelle->id }}" data-toggle="modal"
                                                        data-target="#add-category" title="@lang('Modifier la passerelle ') ">
                                                        <img src="{{ asset('images/passerelles/' . $passerelle->logo) }}"
                                                            width="150px" height="100px" alt="">
                                                    </a>
                                                    <p>
                                                        <a href="{{ route('passerelle.delete', $passerelle->id) }}"
                                                            class="delete" data-toggle="tooltip"
                                                            title="@lang('Supprimer la passerelle')"><i
                                                                class="material-icons">delete_forever</i> </a>
                                                        <a href="{{ route('passerelle.edit', $passerelle->id) }}"
                                                            title="@lang('Modifier la passerelle')"><i
                                                                class="material-icons">edit</i> </a>

                                                        @if ($passerelle->statut == 1)
                                                            <a href="{{ route('passerelle.statut', [$passerelle->id, 0]) }}"
                                                                class="statut" title="@lang('Désactiver la passerelle')"><i
                                                                    class="material-icons">block</i> </a>

                                                            <span class="actif"> @lang('actif')</span>
                                                        @else
                                                            <a href="{{ route('passerelle.statut', [$passerelle->id, 1]) }}"
                                                                class="statut" title="@lang('Activer la passerelle')"><i
                                                                    class="material-icons">redo</i> </a>
                                                            <span class="non_actif"> @lang('non actif') </span>
                                                        @endif
                                                    </p>

                                                </div>
                                            @endif
                                        @endforeach
                                    </div>

                                </td>

                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- end table -->
        </div>
    </div>

</div>


<!-- BEGIN MODAL -->

<!-- Modal Add Category -->
<div class="modal fade none-border" id="add-category">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><strong>@lang('Détails passerelle') </strong></h4>
            </div>
            <div class="modal-body">

                <div class="form-group row">
                    <label class="col-lg-4 col-form-label"> @lang('Libellé de la passerelle') : </label>
                    <div class="col-lg-4">
                        <span id="libelle_lb"> </span>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-4 col-form-label"> @lang('Référence') : </label>
                    <div class="col-lg-4">
                        <span id="nom_lb"> </span>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-4 col-form-label"> @lang('site (site)') : </label>
                    <div class="col-lg-4">
                        <span id="site_lb"> </span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label" for="contact">@lang('Contact') : </label>
                    <div class="col-lg-6">
                        <span id="contact_lb"> </span>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-4 col-form-label" for="text_ajouter">@lang('Texte à ajouter en fin d\'annonce') :</label>
                    <div class="col-lg-6">
                        <span id="texte_lb"> </span>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-4 col-form-label" for="text_ajouter">@lang('Statut') :</label>
                    <div class="col-lg-6" style="color:#DAA520">
                        <span id="statut"> </span>
                    </div>
                </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect"
                    data-dismiss="modal">@lang('Fermer')</button>
            </div>
        </div>
    </div>
</div>
<!-- END MODAL -->
@endsection

@section('js-content')
<script>
    // AFFICHER UNE PASSERELLE
    $('.info_pass').on('click', function() {

        var id = $(this).attr('id');
        $.ajax({
            url: '/passerelle/' + id,
            type: 'GET',
            dataType: 'text',
            success: function(data, statut) {
                var passerelle = JSON.parse(data);;

                $('#libelle_lb').html(passerelle["nom"]);
                $('#nom_lb').html(passerelle["nom"]);
                $('#site_lb').html(passerelle["site"]);
                $('#contact_lb').html(passerelle["contact"]);
                $('#texte_lb').html(passerelle["texte_fin_annonce"]);
                if (passerelle["statut"] == 1) {
                    $('#statut').html("actif");
                } else {
                    $('#statut').html("non actif");
                }





            },
            error: function(resultat, statut, erreur) {
                console.log(resultat + 'le statut' + statut);

            }

        });

    });


    // SUPPRIMER UNE PASSERELLE
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        $('[data-toggle="tooltip"]').tooltip()
        $('a.delete').click(function(e) {

            let that = $(this)
            e.preventDefault()
            const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
            });

            swalWithBootstrapButtons({
                title: '@lang('Vraiment supprimer cette passerelle  ?')',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: '@lang('Oui')',
                cancelButtonText: '@lang('Non')',

            }).then((result) => {
                if (result.value) {
                    $('[data-toggle="tooltip"]').tooltip('hide')
                    $.ajax({
                            url: that.attr('href'),
                            type: 'POST'
                        })
                        .done(function() {
                            window.location.reload(true);

                        })

                    swalWithBootstrapButtons(
                        'Supprimé!',
                        'La passerelle été supprimée.',
                        'success'
                    )


                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons(
                        'Annulé',
                        'La passerelle n\'a pas été supprimée :)',
                        'error'
                    )
                }
            });
        });
    });

    // MODIFIER  LESTATUT D'UNE PASSERELLE
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        $('[data-toggle="tooltip"]').tooltip()
        $('a.statut').click(function(e) {

            let that = $(this)
            e.preventDefault()
            const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
            });

            swalWithBootstrapButtons({
                title: '@lang('Vraiment modifier le statut  ?')',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: '@lang('Oui')',
                cancelButtonText: '@lang('Non')',

            }).then((result) => {
                if (result.value) {
                    $('[data-toggle="tooltip"]').tooltip('hide')
                    $.ajax({
                            url: that.attr('href'),
                            type: 'GET'
                        })
                        .done(function() {
                            window.location.reload(true);

                        })

                    swalWithBootstrapButtons(
                        'Modifié!',
                        'Le statut a été.',
                        'success'
                    )


                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons(
                        'Annulé',
                        'Le statut n\'a pas été modifié :)',
                        'error'
                    )
                }
            });
        });
    });
</script>
@endsection
