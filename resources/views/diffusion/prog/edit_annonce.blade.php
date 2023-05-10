@extends('layouts.app')
@section('content')
@section('page_title')
    Ajouter une annonce
@endsection

@section('content')
    @if (session('ok'))
        <div class="alert alert-success alert-dismissible fade in">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

            <strong> {{ session('ok') }}</strong>
        </div>
    @endif
    <div class="row">
        <div class="card alert">

            <div class="col-lg-10">
                <a href="{{ route('annonce.index', $bien_id_crypt) }}"
                    class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5"><i
                        class="ti-arrow-left "></i>@lang('Retour')</a>
            </div>
            <hr>
            <hr>
            <hr>
            <div class="card-body">

                <div class="form-validation">
                    <form id="form" class="form-valide" action="{{ route('annonce.update', $annonce->id) }}"
                        method="post">
                        {{ csrf_field() }}

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="identifiant_annonce">@lang('Donnez un identifiant à votre annonce') <span
                                    class="text-danger">* </span></label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" id="identifiant_annonce"
                                    value="{{ old('identifiant_annonce') ? old('identifiant_annonce') : $annonce->identifiant_annonce }}"
                                    name="identifiant_annonce" required>
                                @if ($errors->has('identifiant_annonce'))
                                    <br>
                                    <div class="alert alert-warning ">
                                        <strong>{{ $errors->first('identifiant_annonce') }}</strong>
                                    </div>
                                @endif
                            </div>

                        </div>
                        <br>
                        <hr>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="titre">@lang('Titre') <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" id="titre"
                                    value="{{ old('titre') ? old('titre') : $annonce->titre }}" name="titre" required>
                                @if ($errors->has('titre'))
                                    <br>
                                    <div class="alert alert-warning ">
                                        <strong>{{ $errors->first('titre') }}</strong>
                                    </div>
                                @endif
                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="description">@lang('Description') <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <textarea class="form-control" required name="description" id="" cols="30" rows="10"> {{ old('description') ? old('description') : $annonce->description }} </textarea>
                                @if ($errors->has('description'))
                                    <br>
                                    <div class="alert alert-warning ">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="prix">@lang('Prix') <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <input type="number" class="form-control "
                                    value="{{ old('prix') ? old('prix') : $annonce->prix }}" id="titre" name="prix"
                                    required>
                                @if ($errors->has('prix'))
                                    <br>
                                    <div class="alert alert-warning ">
                                        <strong>{{ $errors->first('prix') }}</strong>
                                    </div>
                                @endif
                            </div>

                        </div>
                        <br><br><br>
                        <hr>

                    </form>
                </div>

                {{-- PHOTOS --}}

                <div class="row">
                    <div class="col-md-8 col-lg-8 col-sm-8 col-lg-offset-2 " style="background:#811767; color:white">
                        <h5> <strong>@lang('Choisissez vos photos pour cette annonce')</strong> </h5>
                    </div>

                    <div class="col-md-12 col-lg-12 col-sm-12 ">
                        <br>
                        <h5> @lang('Vous pouvez modifier la position des photos')</h5>
                    </div>

                </div>

                <hr>
                <div class="row">
                    <div class="col-md-12 col-lg-12" id="liste_photo_visible">
                        {{-- {{dd($liste_photos)}}          --}}
                        <ul id="sortable_visible">
                            @foreach ($liste_photos as $photosbien)
                                @if ($photosbien->visibilite == 'visible')
                                    <div class="col-lg-3 col-md-3" id="{{ $photosbien->id }}">
                                        <div
                                            style="margin: auto; width:70%; border: 1px solid white; padding-bottom: 50px; cursor: move;">
                                            <li><span class="badge badge-info "></span>
                                                <p><img src="{{ asset('/images/photos_bien/' . $photosbien->resized_name) }}"
                                                        alt="aaa" width="100%" height="120px"></p>
                                            </li>
                                            <p style="border: 3px solid green; text-align:center">
                                                <a href="{{ route('photoDelete', $photosbien->id) }}" class="delete"
                                                    data-toggle="tooltip" title="@lang('Supprimer cette photo')"><i
                                                        class="material-icons">delete_forever</i> </a>
                                                <a href="{{ route('bien.getPhoto', $photosbien->id) }}"
                                                    title="@lang('Télécharger cette photo')"><i class="material-icons">file_download</i>
                                                </a>
                                                <a title="@lang('Déplacer cette photo')"><i
                                                        class="large material-icons">zoom_out_map</i> </a>
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                        </ul>
                        <div class="col-lg-2 col-md-2 " id="clic_add_photo_visible"
                            style=" border: 1px solid grey; cursor: cell;">
                            <p><img src="{{ asset('/images/img_upload.png') }}" alt="" width="100%"
                                    height="200px"></p>
                        </div>

                    </div>
                    {{-- Ajout des photos visibles --}}
                    <div id="div_add_photo_visible">

                        <div class="row">
                            <div class="col-md-8 col-lg-8 col-sm-8  col-sm-offset-2 col-md-offset-2 col-lg-offset-2 ">
                                <h2 class="page-heading">@lang('Nouvelles photos ')</h2>

                                <form method="post"
                                    action="{{ route('annonce.store_photo', [$bien_id_crypt, $annonce->id]) }}"
                                    enctype="multipart/form-data" class="dropzone" id="fileupload">
                                    {{ csrf_field() }}
                                    <div class="dz-message">
                                        <div
                                            class="col-md-8 col-lg-8 col-sm-8  col-sm-offset-2 col-md-offset-2 col-lg-offset-2">
                                            <div class="message">
                                                <p>@lang('Déplacez les fichiers ici ou cliquez pour uploader')</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="fallback">
                                        <input type="file" name="file" multiple>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <br><br>
                        <div class="row">
                            <div class="col-md-8 col-lg-8 col-sm-8  col-sm-offset-2 col-md-offset-2 col-lg-offset-2">

                                <button id="refresh_div_visible" style="width:160px" name="ajouterSeul"
                                    class="btn btn-lg btn-success"> @lang('Terminer') </button>
                            </div>
                        </div>
                    </div>

                    <br>
                    <br>

                    <button class="btn btn-danger btn-small" id="btn_save_visible" type="submit"><i
                            class="large material-icons large">save</i> @lang('Sauvegarder')</button>


                </div>


                {{-- FIN PHOTOS --}}

                <br><br><br><br><br><br>
                <hr>

                <div class="form-group row">
                    <div class="col-lg-8 col-md-8 ml-auto">
                        <button id="save" class="btn btn-success btn-lg">@lang('Enregistrer') <i
                                class="ti-save"></i></button>
                    </div>
                </div>


            </div>
        </div>
    </div>


@stop
@section('js-content')
    {{-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> --}}
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        //    cette fonction permet de réccupérer les photos du bloc id et de recalculer leurs positions afin de l'afficher 
        //  dans le span (children[0])   
        function display_position(id) {
            // élement du dom sur lequel on clic
            var index = $('ul' + id + ' li').index(this);
            var list = $('ul' + id + ' li');

            //on reparcour les photos pour leur attribuer une position
            for (var i = 0; i < list.length; i++) {
                list[i].children[0].innerHTML = i + 1;
            }
        }

        display_position("#sortable_visible");


        // @@@@@@@@ Liste des photos visibles

        $('#btn_save_visible').hide();

        $(function() {
            $("#sortable_visible").sortable({
                grid: [20, 10],
            });
        });

        $('#sortable_visible').mousemove(function() {
            display_position("#sortable_visible");

        });


        $('#sortable_visible').mouseup(function() {
            $('#btn_save_visible').show();

        });

        // Ajouter une photo visible 
        $('#div_add_photo_visible').hide();

        $('#clic_add_photo_visible').click(function() {
            $('#div_add_photo_visible').fadeIn();
        });

        $('#refresh_div_visible').click(function() {
            $('#div_add_photo_visible').fadeOut();
            $("#sortable_visible").load(" #sortable_visible");
        });


        $('#btn_save_visible').click(function() {

            // élement du dom sur lequel on clic
            var list_id = $('ul#sortable_visible div');
            var list_id_tab = Array();
            // var list_position = $('ul#sortable_visible li');

            //on reparcour les photos pour leur attribuer une position
            for (var i = 0; i < list_id.length; i++) {
                // console.log(list_id[i].getAttribute("id"));
                list_id_tab.push(list_id[i].getAttribute("id"));
                i++;

            }

            //On envoie les nouvelles positions pour les sauvegarder
            $.ajax({
                type: "POST",
                url: '/images-update',
                datatype: 'json',
                data: {
                    "list": JSON.stringify(list_id_tab)
                },

                success: function(data) {
                    console.log(data);
                    swal("Super!", "Nouvelles positions enregistrées!", "success");
                },
                error: function(data) {
                    console.log(data);
                },


            });

            $('#btn_save_visible').hide();
            //   });

            // @@@@@@@@@ fin

        });


        // @@@@@@@@@ fin




        //@@@@@@@@@@@@@@@@@@@@@ SUPPRESSION DES PHOTOS DU BIEN @@@@@@@@@@@@@@@@@@@@@@@@@@

        $(document).ready(function() {

            $(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                $('[data-toggle="tooltip"]').tooltip()
                $('#photos').on('click', '.delete', function(e) {
                    let that = $(this)
                    e.preventDefault()
                    const swalWithBootstrapButtons = swal.mixin({
                        confirmButtonClass: 'btn btn-success',
                        cancelButtonClass: 'btn btn-danger',
                        buttonsStyling: false,
                    })

                    swalWithBootstrapButtons({
                        title: '@lang('Vraiment supprimer cette photo  ?')',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#DD6B55',
                        confirmButtonText: '@lang('Oui')',
                        cancelButtonText: '@lang('Non')',

                    }).then((result) => {
                        if (result.value) {
                            // $('[data-toggle="tooltip"]').tooltip('hide')
                            $.ajax({
                                    url: that.attr('href'),
                                    type: 'GET'
                                })
                                .done(function() {
                                    // that.parents('tr').remove()
                                    that.parent().parent().parent().remove();



                                    var index = $('ul#sortable_visible li').index(this);
                                    var list = $('ul#sortable_visible li');
                                    for (var i = 0; i < list.length; i++) {
                                        list[i].children[0].innerHTML = i + 1;
                                        // console.log(list[i].children[0].innerHTML);
                                    }



                                })

                            swalWithBootstrapButtons(
                                'Supprimé!',
                                'Photo supprimée.',
                                'success'
                            )


                        } else if (
                            result.dismiss === swal.DismissReason.cancel
                        ) {
                            swalWithBootstrapButtons(
                                'Annulé',
                                'Cette photo n\'a pas été supprimée :)',
                                'error'
                            )
                        }
                    })
                })
            })

        });
        //@@@@@@@@@@@@@@@@@@@@@ FIN @@@@@@@@@@@@@@@@@@@@@@@@@@


        //@@@@@@@@@@@ ENREGISTREMENT DE L'ANNONCE @@@@@@@@@@@@

        $('#save').click(function() {


            $("#form").submit();
            // $.ajax({
            //     type : "PUT",
            //     url: ':annonce/update/{{ $annonce->id }}',
            //     datatype: 'json',
            //     data : $(form).serialize(),

            //     success: function(data){
            //         console.log((data));
            //         swal("Super!", "Nouvelles positions enregistrées!", "success");
            //     },
            //     error: function(data){
            //         console.log(data);
            //     },
            // });
        });


        //@@@@@@@@@@@ ENREGISTREMENT DE L'ANNONCE @@@@@@@@@@@@
    </script>

@endsection
