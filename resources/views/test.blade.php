@extends('layouts.app')
@section('content')
    @section ('page_title')
    Agenda
    @endsection
    <div class="row"> 
       
        <div class="col-lg-12">
                @if (session('ok'))
       
                <div class="alert alert-success alert-dismissible fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <a href="#" class="alert-link"><strong> {{ session('ok') }}</strong></a> 
                </div>
             @endif       
             <style>
                body {
                    /* background: #20262E; */
                    /* padding: 20px; */
                    font-family: Helvetica;
                }
                #planning table {
                    background-color: white;
                    user-select: none;
                    /* pointer-events:none; */
                }
                #planning table td,
                #planning table th {
                    border: solid 1px grey;
                    /* width: 100%; */
                }
                #planning table th:first-child {
                    width: 200px;
                }
                #planning table td.selectable {
                    cursor: pointer;
                }
                #planning table td.selected {
                    /* background-image: -webkit-linear-gradient(bottom, #fbc2eb 30%, #a6c1ee 100%);       
                        background-image: -webkit-linear-gradient(top, white 70%, #a6c1ee 100%);  */
                    background: linear-gradient(to bottom, white 20%, #471B61 60%, white 20%);
                }
                tr.aborder {
                    border-width: 1px;
                    border-style: dashed double none;
                    border-bottom-color: white;
                }
            </style>
            
            
            <div class="row">
                <div class="card alert">
            
                    <div class="col-lg-10">
                        <a href="{{url()->previous()}}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5"><i class="ti-arrow-left "></i>@lang('Retour')</a>
                    </div>
                    <hr>
                    <hr>
                    <hr>
            
            
            
            
                    <div class="card-body col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="" style="float: left;">
                            <input type="hidden" id="type_selection" value="add_diff" name="type_selection">
                        </div>
                        <div class="" style="float: right;">
                            <nav aria-label="navigation">
                                <ul class="pager">
                                    <li><a href="#" id="precedent" title="Précédent">
                                            < Précédent</a> </li> <li><a href="#" id="suivant" title="Suivant">Suivant ></a></li>
                                </ul>
                            </nav>
                        </div>
            
                        <div id="planning">
                            <table id="tab_planning" class="table-responsive  student-data-table  m-t-20 " style="width:100%; height:100px">
                                <thead>
                                    <tr id="head-weeks">
                                        <th></th>
                                    </tr>
                                    <tr id="head-days">
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
            
                                </tbody>
                            </table>
                        </div>
            
                    </div>
                    
                </div>
            </div>
            
            <a class="btn btn-lg btn_modal" href="#" id="" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#add-category">
            </a>
            <!-- Modal Add Category -->
            <div class="modal fade none-border" id="add-category">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close annuler_sauvegarde" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title"><strong>@lang('Planifier') </strong></h4>
                        </div>
                        <div class="modal-body">
                            <form id="formRole">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <label class="control-label">@lang('Date début')</label> <input class="form-control"  disabled="disabled"  value="" type="text" id="datepicker1">
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <label class="control-label">@lang('Date fin')</label> <input class="form-control" disabled="disabled"  type="text" id="datepicker2">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 ">
                                        <label class="control-label">@lang('Ajouter une annonce ?')</label>
                                        <input type="checkbox" unchecked data-toggle="toggle" id="choose_annonce" name="choose_annonce" data-off="Non" data-on="Oui" data-onstyle="success" data-offstyle="danger">
            
                                    </div>
                                   
                                    <div id="annonce" class="col-lg-6 col-md-6 col-sm-6 annonce">
                                        <label class="control-label">@lang('Choisissez une annonce')</label>
                                        <select class="form-control form-white" id="select_annonce" data-placeholder="choisir une annonce" name="annonce">
                                           
                                            <option data-titre="" value="bb">bbb</option>
                                         
            
                                        </select>
                                    </div>
                                    <br> <br>
                                    <div id="title" class="annonce"></div>
                                 
                                    <div id="annonce" class="col-lg-6 col-md-6 col-sm-6 annonce">
                                        <label class="control-label">@lang('Pas d\'annonces disponibles')</label>
                                    </div>
            
                                   
                                </div>
                                <hr>
            
                                <input type="hidden" id="_token" value="{{ csrf_token() }}">
                                <input type="hidden" id="user_id" value="">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default waves-effect annuler_sauvegarde" data-dismiss="modal">@lang('annuler')</button>
                            <button type="button" id="sauvegarder" class="btn btn-danger waves-effect waves-light save-category" data-dismiss="modal">@lang('Planifier')</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- END MODAL -->
            
            
            @stop
            
            @section('js-content')
            {{-- TABLEAU DES PLANIFICATIONS --}}
            
            <script>
                // alert(window.screen.availHeight+'----'+window.screen.availWidth);
                    // interdiction du clic gauche sur la page
                    // document.oncontextmenu = new Function("return false");
                    var startDate = new Date();
                    // on trunc les heures pour avoir des timesstamps uniformes
                    startDate.setHours(00);
                    startDate.setMinutes(00);
                    startDate.setSeconds(00);
                    startDate.setMilliseconds(00);
                    
                    
                    startDate = Date.parse(startDate)/1000;
                    console.log(startDate);
                    const monthNames = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin",
                        "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Decembre"
                    ];
                
                
                    var dates_de_diffusion = '2021-07-29';
                
                    // ### Fonction de Construction du tableau
                    function construction_tableau(startDate, dates_de_diffusion, premier_construction) {
                        var nbWeeks = 5;
                        var nbWeekDays = 7;
                
                
                        // ### Construction de l'entête du tableau
                        for (var week = 0; week < nbWeeks; week++) {
                            var from = new Date((week * 7 * 86400 + startDate) * 1000);
                            var to = new Date(((week * 7 + 6) * 86400 + startDate) * 1000);
                           // Por avoir des timestamps uniformes
                            from.setHours(00);
                            from.setMinutes(00);
                            from.setSeconds(00);
                            from.setMilliseconds(00);
                            to.setHours(00);
                            to.setMinutes(00);
                            to.setSeconds(00);
                            to.setMilliseconds(00);
                            
                            
                            $("#head-weeks").append("<th colspan='" + nbWeekDays + "'>" + ("0" + from.getUTCDate()).slice(-2) + "-" + ("0" + to.getUTCDate()).slice(-2) + " " + monthNames[to.getMonth()] + "</th>");
                            // deuximème ligne de l'entête
                            for (var day = 0; day < nbWeekDays; day++) {
                                var date = new Date(((week * 7 + day) * 86400 + startDate) * 1000);
                
                                $("#head-days").append("<th>" + ("0" + date.getUTCDate()).slice(-2) + "</th>");
                            }
                        }
                        // ##Fin
                
                        // ## construction du corps tableau
                        var nbPlatforms = 5;
                        var passerelles = ''
                        // var passerelles = JSON.parse(passerelles.replace(/&quot;/g, '"'));
                
                
                        if (premier_construction == 1) 
                            // dates_de_diffusion = JSON.parse(dates_de_diffusion.replace(/&quot;/g, '"'));
                
                        for (var platform = 0; platform < nbPlatforms; platform++) {
                            // # première colonne du tableau
                            // var row = '<th>' + passerelles[platform]["reference"] + ' <img src="/images/passerelles/' + passerelles[platform]["logo"] + '" width="50px" height="20px" alt="">  </th>';
                            for (var week = 0; week < nbWeeks; week++) {
                                for (var day = 0; day < nbWeekDays; day++) {
                                    // var timestamp = (week * 7 + day) * 86400 + startDate;
                
                                    // if ($.inArray(timestamp, dates_de_diffusion[passerelles[platform]["id"]]) > -1) {
                                        // row += "<td class='selectable aborder selected first_build'  data-timestamp='" + timestamp + "'></td>";
                                    // } else {
                                        // row += "<td class='selectable aborder '  data-timestamp='" + timestamp + "'></td>";
                                    // }
                                    
                                    
                                }
                            }
                            
                            row = ` <tr class="aborder" data-platform-id="1"><th>logicimmo <img src="/images/passerelles/fcebfbf7576ff8b5e6c5d8a2a49f5dcb2984f3c3ml.jpg" width="50px" height="20px" alt="">  </th><td class="selectable aborder " data-timestamp="1627509600"></td><td class="selectable aborder " data-timestamp="1627596000"></td><td class="selectable aborder " data-timestamp="1627682400"></td><td class="selectable aborder " data-timestamp="1627768800"></td><td class="selectable aborder " data-timestamp="1627855200"></td><td class="selectable aborder " data-timestamp="1627941600"></td><td class="selectable aborder " data-timestamp="1628028000"></td><td class="selectable aborder " data-timestamp="1628114400"></td><td class="selectable aborder " data-timestamp="1628200800"></td><td class="selectable aborder " data-timestamp="1628287200"></td><td class="selectable aborder " data-timestamp="1628373600"></td><td class="selectable aborder " data-timestamp="1628460000"></td><td class="selectable aborder " data-timestamp="1628546400"></td><td class="selectable aborder " data-timestamp="1628632800"></td><td class="selectable aborder " data-timestamp="1628719200"></td><td class="selectable aborder " data-timestamp="1628805600"></td><td class="selectable aborder " data-timestamp="1628892000"></td><td class="selectable aborder " data-timestamp="1628978400"></td><td class="selectable aborder " data-timestamp="1629064800"></td><td class="selectable aborder " data-timestamp="1629151200"></td><td class="selectable aborder " data-timestamp="1629237600"></td><td class="selectable aborder " data-timestamp="1629324000"></td><td class="selectable aborder " data-timestamp="1629410400"></td><td class="selectable aborder " data-timestamp="1629496800"></td><td class="selectable aborder " data-timestamp="1629583200"></td><td class="selectable aborder " data-timestamp="1629669600"></td><td class="selectable aborder " data-timestamp="1629756000"></td><td class="selectable aborder " data-timestamp="1629842400"></td><td class="selectable aborder " data-timestamp="1629928800"></td><td class="selectable aborder " data-timestamp="1630015200"></td><td class="selectable aborder " data-timestamp="1630101600"></td><td class="selectable aborder " data-timestamp="1630188000"></td><td class="selectable aborder " data-timestamp="1630274400"></td><td class="selectable aborder " data-timestamp="1630360800"></td><td class="selectable aborder " data-timestamp="1630447200"></td></tr> `
                            // row = "<tr class='aborder' data-platform-id='" + passerelles[platform]["id"] + "'>" + row + "</tr>";
                            $("tbody").append(row);
                        }
                        // ##Fin
                
                    }
                    // ###Fin
                
                    // ##Première construction du tableau
                    construction_tableau(startDate, dates_de_diffusion, 1);
                
                
                    var SELECT_MODE = false;
                    var SELECT_PASSERELLE_ID = null;
                    var SELECT_FROM = null;
                    var SELECT_TO = null;
                
                    // ## Fonction qui colorie les cellules entre deux dates selectionnées
                    function refresh() {
                
                        if (!SELECT_FROM || !SELECT_TO) {
                            return;
                        }
                        // ## On colorie les cases sélectionées
                        var from = Math.min(SELECT_FROM, SELECT_TO);
                        var to = Math.max(SELECT_FROM, SELECT_TO);
                        for (var timestamp = from; timestamp <= to; timestamp += 86400) {
                            var cell = $("#planning tbody tr[data-platform-id=" + SELECT_PASSERELLE_ID + "] td[data-timestamp=" + timestamp + "]");                
                            cell.addClass("selected");
                        }
                    }
                    // ## Fin
                
                    function unrefresh() {
                        
                        if (!SELECT_FROM || !SELECT_TO) {
                            return;
                        }
                        // ## On decolorie les cases sélectionées
                        var from = Math.min(SELECT_FROM, SELECT_TO);
                        var to = Math.max(SELECT_FROM, SELECT_TO);
                        for (var timestamp = from; timestamp <= to; timestamp += 86400) {
                            var cell = $("#planning tbody tr[data-platform-id=" + SELECT_PASSERELLE_ID + "] td[data-timestamp=" + timestamp + "]");
                            cell.removeClass("selected");
                        }
                    }
                
                    function select_cellule() {
                        // # Au clic d'une cellule
                        $(".selectable").on("mousedown", function(e) {
                            
                            // Si la case sélectionnée n'est pas déjà cochée, alors on aura une suppression 
                            $(this).hasClass('selected') == false ? $('#type_selection').val("add_diff") : $('#type_selection').val("supp_diff");                
                            
                            // seulement au clic gauche
                            if (e.which == 1) {
                                SELECT_MODE = true;
                                SELECT_PASSERELLE_ID = $(this).parent().data("platform-id");
                                SELECT_FROM = $(this).data("timestamp");
                
                                SELECT_TO = SELECT_FROM;
                                if ($('#type_selection').val() == "add_diff") {
                                    refresh();
                                } else if ($('#type_selection').val() == "supp_diff") {
                                    unrefresh();
                                }
                            }
                        });
                
                        // # Lorsqu'on relache le clic sur la cellule
                        $("body").on("mouseup", function(e) {
                            if (!SELECT_MODE) {
                                return;
                            }
                            var from = new Date(SELECT_FROM * 1000);
                            var to = new Date(SELECT_TO * 1000);
                
                            if (from > to) {
                                var tmp = from;
                                from = to;
                                to = tmp;
                            }
                            // si nous diffuson alors on ajout les infos nécessaires (date deb, date fin) dans le modal de planification
                            if ($('#type_selection').val() == "add_diff") {
                                // # on déclenche le modal
                                $('#datepicker1').val(from.getDate() - 1 + ' ' + monthNames[from.getMonth()] + ', ' + from.getFullYear());
                                $('#datepicker1').attr('datetime', SELECT_FROM);
                                $('#datepicker2').val(to.getDate() - 1 + ' ' + monthNames[to.getMonth()] + ', ' + to.getFullYear());
                                $('#datepicker2').attr('datetime', SELECT_TO);
                
                                $('.btn_modal').trigger('click');
                            
                                // SUPPRIMER DES DIFFUSIONS 
                            }else{
                                date_deb = SELECT_FROM; 
                                date_fin = SELECT_TO; 
                                passerelle_id = SELECT_PASSERELLE_ID;
                
                                
                                $(function() {
                                   
                                    $('[data-toggle="tooltip"]').tooltip();
                                    
                                        let that = $(this);
                                        e.preventDefault();
                                        const swalWithBootstrapButtons = swal.mixin({
                                            confirmButtonClass: 'btn btn-success',
                                            cancelButtonClass: 'btn btn-danger',
                                            buttonsStyling: false,
                                        });
                            
                                        swalWithBootstrapButtons({
                                            title: '@lang('Vraiment supprimer des diffusions ? ')',
                                            type : 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#DD6B55',
                                            confirmButtonText: '@lang('Oui ')',
                                            cancelButtonText: '@lang('Non ')',
                            
                                        }).then((result) => {
                                            if (result.value) {
                                                $('[data-toggle="tooltip"]').tooltip('hide');
                                                $.ajax({                        
                                                    url: '/diffusion/prog/delete/' + '5',
                                                    type: 'POST',
                                                    dataType: 'text',
                                                    data: {
                                                        'passerelle_id': passerelle_id,
                                                        'date_deb': date_deb,
                                                        'date_fin': date_fin,
                                                        _token: "{!! csrf_token() !!}"
                                                    },
                                                    success: function(data, statut) {
                                                        console.log(data);
                                                    },
                                                    error: function(resultat, statut, erreur) {
                                                        console.log(resultat + 'le statut' + statut);
                                                    }
                                                })
                                                .done(function () {
                                                        that.parents('tr').remove()
                                                })
                            
                                                swalWithBootstrapButtons(
                                                'Supprimé!',
                                                '',
                                                'success'
                                                ) 
                                            }
                                            else   {
                                                swalWithBootstrapButtons(
                                                'Annulé',
                                                'Suppression annulée :)',
                                                'error'
                                                );
                                                // ## On decolorie les cases sélectionées
                                                var from = Math.min(date_deb, date_fin);
                                                var to = Math.max(date_deb, date_fin);
                                                for (var timestamp = from; timestamp <= to; timestamp += 86400) {
                                                    var cell = $("#planning tbody tr[data-platform-id=" + passerelle_id + "] td[data-timestamp=" + timestamp + "]");
                                                    // si c'est la première construction alors la case était déjà sélectionnée, donc pas de déselection
                                                    cell.hasClass("first_build") ? cell.addClass("selected")  : null  ;
                                                    
                                                }
                                                
                                            }
                                        });
                                    // });
                                });
                            }
                
                            // ajout de l'id de la passerelle dans le bouton sauvegarder du modal
                            $('#sauvegarder').attr('passerelle_id', SELECT_PASSERELLE_ID);
                
                
                            SELECT_MODE = false;
                            SELECT_PASSERELLE_ID = null;
                            SELECT_FROM = null;
                            SELECT_TO = null;
                            
                        });
                        // # au survole d'une cellule
                        $(".selectable").on("mousemove", function(e) {
                            if (!SELECT_MODE) {
                                return;
                            }
                            SELECT_TO = $(this).data("timestamp");
                            if ($('#type_selection').val() == "add_diff") {
                                refresh();
                            } else if ($('#type_selection').val() == "supp_diff") {
                                unrefresh();
                            }
                        });
                    }
                
                    select_cellule();
                
                
                
                    // ### Tableau suivant et precedent
                
                    function tab_suiv_prec(type) {
                        $(type).on('click', function() {
                
                            $('#tab_planning').remove();
                            var tab = `<table id="tab_planning" class=" table-responsive student-data-table  m-t-20 "  style="width:100%; height:100px">
                                        <thead>
                                            <tr id="head-weeks">
                                            <th></th>
                                            </tr>
                                            <tr id="head-days">
                                            <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                        </table>`;
                            $('#planning').html(tab);
                
                            $.ajax({
                                url: '/diffusion/prog/create_suiv_prec/' + '2',
                                type: 'POST',
                                dataType: 'json',
                                data: {
                
                                    _token: "{!! csrf_token() !!}"
                                },
                
                                success: function(data, statut) {
                                    construction_tableau(startDate, data, 0);
                                    (type == "#suivant") ? startDate += 86400 * 7: startDate -= 86400 * 7;
                
                                    select_cellule();
                                },
                                error: function(resultat, statut, erreur) {
                                    console.log(resultat + 'le statut' + statut);
                
                                }
                
                            });
                
                        });
                
                    }
                
                    tab_suiv_prec('#suivant');
                    tab_suiv_prec('#precedent');
                    // ### Tableau précendent
                </script>
                {{-- FIN TAB --}}
                
                {{-- MODAL PLANIFICATION--}}
                
                <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
                <script>
                    var annonce_title = "";
                
                    $('.annonce').hide();
                    annonce_title = $("#annonce option:selected").attr('data-titre');
                    annonce_title = "<br><strong> Titre de l'annonce : </strong>" + annonce_title;
                    $('#title').html(annonce_title);
                
                    $("#select_annonce").change(function() {
                        annonce_title = $("#annonce option:selected").attr('data-titre');
                        annonce_title = "<br><strong> Titre de l'annonce: </strong>" + annonce_title;
                        $('#title').html(annonce_title);
                
                    });
                
                   
                
                
                    // # Choix des annonces dans le modal de planification
                    $('#choose_annonce').change(function(e) {
                        e.preventDefault();
                        $('#choose_annonce').is(':unchecked') ? $('.annonce').hide() : $('.annonce').show();
                    });
                
                
                    // # Enregistrement de la planification 
                
                    $('#sauvegarder').on('click', function() {
                        
                        // on ajoute cette classe lorsque la selection est validée, pour la différencier des selections abandonnées
                        $('.selected').addClass('first_build');
                        var passerelle_id = $(this).attr('passerelle_id');
                        var datepicker1 = $('#datepicker1').attr('datetime');
                        var datepicker2 = $('#datepicker2').attr('datetime');
                        var choose_annonce = $('#choose_annonce').is(':checked');
                        var annonce_id = $('#select_annonce').val();
               
                        $.ajax({
                            url: '/diffusion/prog/planifier/' + '5',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                'passerelle_id': passerelle_id,
                                'datepicker1': datepicker1,
                                'datepicker2': datepicker2,
                                'choose_annonce': choose_annonce,
                                'annonce_id': annonce_id,
                                _token: "{!! csrf_token() !!}"
                            },
                            success: function(data, statut) {
                                console.log(data);
                            },
                            error: function(resultat, statut, erreur) {
                                console.log(resultat + 'le statut' + statut);
                            }
                
                        });
                
                    });
                    
                </script>
                {{-- FIN MODAL --}}
                
            
                <script>
                    
                </script>
            
            @endsection