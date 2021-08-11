@extends('layouts.app') 
@section('content') 
@section ('page_title') 
   Historique du contrat de <span class="color-warning"> {{$contrat->user->nom}} {{$contrat->user->prenom}}</span> 
   <br>
   <br>
   <span class="color-danger">Modifié le {{$contrat->created_at->format('Y/m/d')}}</span>
@endsection
<div class="row">
    <div class="col-lg-12">
        @if (session('ok'))
        <div class="alert alert-success alert-dismissible fade in">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong> {{ session('ok') }}</strong>
        </div>
        @endif
        
        <div class="card">
            <div class="col-lg-10">
				<a href="{{route('contrat.historique', Crypt::encrypt($contrat->user->contrat->id))}}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5"><i class="ti-angle-double-left"></i>@lang('Retour')</a> 

            </div>
            <div class="card-body">
                <div class="panel-body">
 <hr>
                    <fieldset class="col-md-12">
                        <legend>Infos basiques</legend>
                        <div class="panel panel-warning">
                            <div class="panel-body">
                                <form class="form-valide3" action="{{ route('contrat.update',Crypt::encrypt($contrat->id)) }}" method="post">
                                    {{ csrf_field() }}

                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6">

                                            <div class="form-group row">
                                                <label   class="col-lg-4 col-form-label"  @if($contrat->modif_forfait_administratif == true) style="background:#f291bf"  @endif for="forfait_administratif">Forfait administratif (€)<span class="text-danger">*</span></label>
                                                <div class="col-lg-4">
                                                    <input type="number" class="form-control" min="0" value="{{$contrat->forfait_administratif}}" id="forfait_administratif" name="forfait_administratif" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label"  @if($contrat->modif_forfait_carte_pro == true) style="background:#f291bf"  @endif for="forfait_carte_pro">Attestation de collaborateur (€)<span class="text-danger">*</span></label>
                                                <div class="col-lg-4">
                                                    <input type="number" class="form-control" min="0" value="{{$contrat->forfait_carte_pro}}" id="forfait_carte_pro" name="forfait_carte_pro" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" @if($contrat->modif_forfait_pack_info == true) style="background:#f291bf"  @endif for="forfait_pack_info">Forfait pack informatique (€)<span class="text-danger">*</span></label>
                                                <div class="col-lg-4">
                                                    <input type="number" class="form-control" min="0" value="{{$contrat->forfait_pack_info}}" id="forfait_pack_info" name="forfait_pack_info" required>
                                                </div>
                                            </div>
                                            @php
                                               $check =  ($contrat->est_demarrage_starter == true) ? "checked" : "unchecked";
                                            @endphp
                                            <div class="form-group row">
                                                <label class="col-lg-6 col-form-label"  @if($contrat->modif_est_demarrage_starter == true) style="background:#f291bf"  @endif for="est_starter">Démarrage en tant que Starter ?</label>
                                                <input type="checkbox" {{$check}} data-toggle="toggle" id="est_starter" name="est_starter" data-off="Non" data-on="Oui" data-onstyle="success" data-offstyle="danger">
                                            </div>
                                            @php
                                               $check_p =  ($contrat->a_parrain == true) ? "checked" : "unchecked";
                                            @endphp
                                            <div class="form-group row">
                                                <label class="col-lg-6 col-form-label"  @if($contrat->modif_a_parrain == true) style="background:#f291bf"  @endif for="a_parrain">Le mandataire a t'il un parrain ?</label>
                                                <input type="checkbox" {{$check_p}} data-toggle="toggle" id="a_parrain" name="a_parrain" data-off="Non" data-on="Oui" data-onstyle="success" data-offstyle="danger">
                                            </div>
                                     
                                            <div id="parrain-id">

                                            
                                                {{-- <div class="form-group row">
                                                <label class="col-lg-4 col-form-label"  @if($contrat->modif_parrain_id == true) style="background:#f291bf"  @endif for="parrain_id">Choisir le parrain</label>
                                                    <div class="col-lg-8">
                                                        <select class="selectpicker col-lg-6" id="parrain_id" name="parrain_id" data-live-search="true" data-style="btn-warning btn-rounded">
                                                            @if ($contrat->a_parrain == true)
                                                            <option value="{{ $parrain->id }}" data-tokens="{{ $parrain->nom }} {{ $parrain->prenom }}">{{ $parrain->nom }} {{ $parrain->prenom }}</option>
                                                            @endif
                                                           
                                                        </select>
                                                    </div>
                                                </div> --}}
                                                
                                                @php
                                                    $check_parr =  ($contrat->a_condition_parrain == true) ? "checked" : "unchecked";
                                                @endphp
                                              
                                                <div class="form-group row">
                                                    <label class="col-lg-6 col-form-label"  @if($contrat->modif_a_condition_parrain == true) style="background:#f291bf"  @endif for="a_condition_parrain">Appliquer des conditions au parrain ?</label>
                                                    <div class="col-lg-6">

                                                        <input type="checkbox" {{$check_parr}} data-toggle="toggle" id="a_condition_parrain" name="a_condition_parrain" data-off="Non" data-on="Oui" data-onstyle="success" data-offstyle="danger">
                                                   
                                                    </div>
                                                </div>
                                            </div>
                                                
                                            
                                           

                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label"  @if($contrat->modif_date_entree == true) style="background:#f291bf"  @endif for="date_entree">Date d'entrée<span class="text-danger">*</span></label>
                                                <div class="col-lg-4">
                                                    <input type="date" class="form-control" value="{{$contrat->date_entree->format('Y-m-d')}}" id="date_entree" name="date_entree" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label"  @if($contrat->modif_date_deb_activite == true) style="background:#f291bf"  @endif for="date_debut">Date de début d'activité<span class="text-danger">*</span></label>
                                                <div class="col-lg-4">
                                                    <input type="date" class="form-control" value="{{$contrat->date_deb_activite->format('Y-m-d')}}" id="date_debut" name="date_debut" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label"  @if($contrat->modif_ca_depart == true) style="background:#f291bf"  @endif for="ca_depart">Chiffre d'affaires de depart HT<span class="text-danger">*</span></label>
                                                <div class="col-lg-4">
                                                    <input type="number" min="0" step="0.01" class="form-control" value="{{$contrat->ca_depart}}" id="ca_depart" name="ca_depart" required>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label"  @if($contrat->modif_ca_depart_sty == true) style="background:#f291bf"  @endif for="ca_depart_sty">Chiffre d'affaires rapporté à stylimmo HT<span class="text-danger">*</span></label>
                                                <div class="col-lg-4">
                                                    <input type="number" min="0" class="form-control" value="{{$contrat->ca_depart_sty}}" id="ca_depart_sty" name="ca_depart_sty" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            @php
                                                $check_fact_pub =  ($contrat->est_soumis_fact_pub == true) ? "checked" : "unchecked";
                                                $check_tva =  ($contrat->est_soumis_tva == true) ? "checked" : "unchecked";
                                            @endphp
                                            <div class="form-group row">
                                                <label class="col-lg-6 col-form-label"  @if($contrat->modif_est_soumis_tva == true) style="background:#f291bf"  @endif for="est_soumis_tva">Le mandataire est soumis à la TVA ?</label>
                                                <div class="col-lg-6">
                                                    <input type="checkbox" {{$check_tva}} data-toggle="toggle" id="est_soumis_tva" name="est_soumis_tva" data-off="Non" data-on="Oui" data-onstyle="success" data-offstyle="danger">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            @php
                                                $check_deduis =  ($contrat->deduis_jeton == true) ? "checked" : "unchecked";
                                            @endphp
                                            <div class="form-group row">
                                                <label class="col-lg-6 col-form-label"  @if($contrat->modif_deduis_jeton == true) style="background:#f291bf"  @endif for="deduis_jeton">Le mandataire déduit des jetons ?</label>
                                                <div class="col-lg-6">
                                                    <input type="checkbox" {{$check_deduis}} data-toggle="toggle" id="deduis_jeton" name="deduis_jeton" data-off="Non" data-on="Oui" data-onstyle="success" data-offstyle="danger">
                                                </div>
                                            </div>
                                        </div>
                                        
                                       
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                           
                                            <div class="form-group row">
                                                <label class="col-lg-6 col-form-label"  @if($contrat->modif_est_soumis_fact_pub == true) style="background:#f291bf"  @endif for="est_soumis_fact_pub">Générer des factures pub s'il n'est pas soumis aux jetons ?</label>
                                                <div class="col-lg-6">
                                                    <input type="checkbox" {{$check_fact_pub}} data-toggle="toggle" id="est_soumis_fact_pub" name="est_soumis_fact_pub" data-off="Non" data-on="Oui" data-onstyle="success" data-offstyle="danger">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                    </div>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <div class="panel-body">
                    <fieldset class="col-md-12">
                        <legend>Commission directe</legend>
                        <div class="panel panel-warning">
                            <div class="panel-body">

                                {{-- PACK STARTER --}}
                            <div class="row" id="pack_starter">
                                    <div class="row">
                                        <div class="col-md-12 col-lg-12 col-sm-12 "style="color: #5c96b3; ">
                                            <h4> <strong><center> @lang('Starter') </center></strong></h4>                          
                                        </div>
                                    </div>
                                    <hr>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                       
                                        <div class="form-group row">
                                            <label class="col-lg-6 col-md-6 col-sm-6 col-form-label"  @if($contrat->modif_pourcentage_depart_starter == true) style="background:#f291bf"  @endif for="pourcentage_depart_starter">Pourcentage de départ du mandataire<span class="text-danger">*</span></label>
                                            <div class="col-lg-4 col-md-4 col-sm-4 ">
                                                <input type="number" class="form-control" value="{{$contrat->pourcentage_depart_starter}}" id="pourcentage_depart_starter" name="pourcentage_depart_starter" min="0" max="100" hidden required>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                    
                                        <div class="form-group row" >
                                            <label class="col-lg-6 col-md-6 col-sm-6 col-form-label" @if($contrat->modif_nb_vente_passage_expert == true) style="background:#f291bf"  @endif for="nb_vente_passage_expert">Nombre de vente pour passer expert<span class="text-danger">*</span></label>
                                            <div class="col-lg-4 col-md-4 col-sm-4 ">
                                                <input type="number" class="form-control" id="nb_vente_passage_expert" name="nb_vente_passage_expert" min="0" value="{{$contrat->nb_vente_passage_expert}}"  required>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row" id="max-starter-parrent">
                                            <label class="col-lg-6 col-md-6 col-sm-6 col-form-label"  @if($contrat->modif_duree_max_starter == true) style="background:#f291bf"  @endif for="duree_max_starter">Durée maximum du pack Starter<span class="text-danger">*</span></label>
                                            <div class="col-lg-4 col-md-4 col-sm-4 ">
                                                <input type="number" class="form-control" id="duree_max_starter" name="duree_max_starter" min="0" value="{{$contrat->duree_max_starter}}" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-6 col-form-label"  @if($contrat->modif_duree_gratuite_starter == true) style="background:#f291bf"  @endif for="duree_gratuite_starter">Durée de la gratuité (mois)<span class="text-danger">*</span></label>
                                            <div class="col-lg-4 col-md-4 col-sm-4 ">
                                                <input type="number" class="form-control" id="duree_gratuite_starter" name="duree_gratuite_starter" min="0" value="{{$contrat->duree_gratuite_starter}}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        @php
                                            $check1 =  ($contrat->a_palier_starter == true) ? "checked" : "unchecked";
                                        @endphp
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label"  @if($contrat->modif_a_palier_starter == true) style="background:#f291bf"  @endif for="check_palier_starter">Paliers<span class="text-danger">*</span></label>
                                            <div class="col-lg-2">
                                                <input type="checkbox" {{$check1}} data-toggle="toggle" id="check_palier_starter" name="check_palier_starter" data-off="Non" data-on="Oui" data-onstyle="success" data-offstyle="danger">
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12" id="palier_starter">
                                            <div class="panel panel-pink m-t-15">
                                                <div class="panel-heading"><strong>Paliers Starter</strong></div>
                                                <div class="panel-body">
                                                    <div class="input_fields_wrap_starter">
                                                        <a class="btn btn-warning add_field_button_starter" style="margin-left: 53px;">Ajouter un niveau</a>
                                                        <div class="form-inline field1">
                                                                <div class="form-group">
                                                                    <label   for="level_starter1">Niveau: </label>
                                                                    <input class="form-control" type="text" value="1" id="level_starter1" name="level_starter1" readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="percent_starter1">% en + : </label>
                                                                    <input class="form-control" type="number" min="0" max="0" step="0.10" value="0" id="percent_starter1" name="percent_starter1" readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label  for="ca_min_starter1">CA min (€) : </label>
                                                                    <input class="form-control" type="number" value="0" id="ca_min_starter1" name="ca_min_starter1" readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label   for="ca_max_starter1">CA max (€) : </label>
                                                                    <input class="form-control" type="number" min="0" value="50000" id="ca_max_starter1" name="ca_max_starter1" />
                                                                </div>
                                                            </div>
                                                            @php
                                                                $percent_diff = 95 - $contrat->pourcentage_depart_starter;
                                                                $nb_palier_starter = sizeof($palier_starter);
                                                                $x =1;
                                                            @endphp
                                                        @foreach ($palier_starter as $num=>$palier)
                                                            
                                                            @php
                                                                $niveau=$palier[0] ;
                                                                $pourcent_plus=$palier[1] ;
                                                                $ca_min=$palier[2] ;
                                                                $ca_max=$palier[3] ;
                                                                $percent_diff -= $pourcent_plus;
                                                                $x=$niveau;
                                                            @endphp
                                                        <div class="form-inline field{{$niveau}}">
                                                            <div class="form-group">
                                                                <label  for="level_starter{{$niveau}}">Niveau: </label>
                                                                <input class="form-control" type="text" value="{{$niveau}}" id="level_starter{{$niveau}}" name="level_starter{{$niveau}}" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label  for="percent_starter{{$niveau}}">% en + : </label>
                                                                <input class="form-control" type="number" min="0" max="{{$percent_diff}}" step="0.10" value="{{$pourcent_plus}}" id="percent_starter{{$niveau}}" name="percent_starter{{$niveau}}" >
                                                            </div>
                                                            <div class="form-group">
                                                                <label  for="ca_min_starter{{$niveau}}">CA min (€) : </label>
                                                                <input class="form-control" type="number" value="{{$ca_min}}" id="ca_min_starter{{$niveau}}" name="ca_min_starter{{$niveau}}" readonly >
                                                            </div>
                                                            <div class="form-group">
                                                                <label  for="ca_max_starter{{$niveau}}">CA max (€) : </label>
                                                                <input class="form-control" type="number" min="0" value="{{$ca_max}}" id="ca_max_starter{{$niveau}}" name="ca_max_starter{{$niveau}}" />
                                                            </div>
                                                            @if ($niveau == $nb_palier_starter+1 )
                                                                <button href="#" id="pal_starter{{$niveau}}" class="btn btn-danger remove_field">Enlever</button></br>
                                                            @else
                                                                <button href="#" id="pal_starter{{$niveau}}" class="btn btn-danger cacher_btn_remove_field remove_field">Enlever</button></br>
                                                            @endif
                                                            
                                                        </div>
                                                        @endforeach

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            {{-- FIN PACK STARTER --}}



                            {{-- PACK EXPERT --}}
                            <br>
                            <hr>
                            <div class="row">
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-sm-12 "style="color: #5c96b3; ">
                                        <h4> <strong><center> @lang('Expert') </center></strong></h4>                          
                                    </div>
                                </div><hr>
                                
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                       
                                        <div class="form-group row">
                                            <label class="col-lg-6 col-md-6 col-sm-6 col-form-label"  @if($contrat->modif_pourcentage_depart_expert == true) style="background:#f291bf"  @endif for="pourcentage_depart_expert">Pourcentage de départ du mandataire<span class="text-danger">*</span></label>
                                            <div class="col-lg-4 col-md-4 col-sm-4 ">
                                                <input type="number" class="form-control" id="pourcentage_depart_expert" value="{{$contrat->pourcentage_depart_expert}}" name="pourcentage_depart_expert" min="0" max="100" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                       
                                        <div class="form-group row">
                                            <label class="col-lg-6 col-form-label" @if($contrat->modif_duree_gratuite_expert == true) style="background:#f291bf"  @endif for="duree_gratuite_expert">Durée de la gratuité (mois)<span class="text-danger">*</span></label>
                                            <div class="col-lg-4 col-md-4 col-sm-4 ">
                                                <input type="number" class="form-control" id="duree_gratuite_expert" name="duree_gratuite_expert" min="0" value="{{$contrat->duree_gratuite_expert}}" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-6 col-form-label" @if($contrat->modif_nb_vente_gratuite_expert == true) style="background:#f291bf"  @endif for="nb_vente_gratuite_expert">Nombre de vente de la gratuité <span class="text-danger">*</span></label>
                                            <div class="col-lg-4 col-md-4 col-sm-4 ">
                                                <input type="number" class="form-control" id="nb_vente_gratuite_expert" name="nb_vente_gratuite_expert" min="0" value="{{$contrat->nb_vente_gratuite_expert}}" required>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        @php
                                            $check2 =  ($contrat->a_palier_expert == true) ? "checked" : "unchecked";
                                        @endphp
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label"  @if($contrat->modif_a_palier_expert == true) style="background:#f291bf"  @endif for="check_palier_expert">Paliers<span class="text-danger">*</span></label>
                                            <div class="col-lg-2">
                                                <input type="checkbox" {{$check2}} data-toggle="toggle" id="check_palier_expert" name="check_palier_expert" data-off="Non" data-on="Oui" data-onstyle="success" data-offstyle="danger">
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12" id="palier_expert">
                                            <div class="panel panel-pink m-t-15">
                                                <div class="panel-heading"><strong>Paliers Expert</strong></div>
                                                <div class="panel-body">
                                                    <div class="input_fields_wrap_expert">
                                                        <a class="btn btn-warning add_field_button_expert" style="margin-left: 53px;">Ajouter un niveau</a>
                                                        <div class="form-inline field1">
                                                            <div class="form-group">
                                                                <label for="level_expert1">Niveau: </label>
                                                                <input class="form-control" type="text" value="1" id="level_expert1" name="level_expert1" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="percent_expert1">% en + : </label>
                                                                <input class="form-control" type="number" min="0" max="0" step="0.10" value="0" id="percent_expert1" name="percent_expert1" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="ca_min_expert1">CA min (€) : </label>
                                                                <input class="form-control" type="number" value="0" id="ca_min_expert1" name="ca_min_expert1" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="ca_max_expert1">CA max (€) : </label>
                                                                <input class="form-control" type="number" min="0" value="50000" id="ca_max_expert1" name="ca_max_expert1" />
                                                            </div>
                                                        </div>
                                                        @php
                                                            $percent_diff = 95 - $contrat->pourcentage_depart_expert;
                                                            $nb_palier_expert = sizeof($palier_expert);
                                                            $y=1;
                                                        @endphp
                                                        @foreach ($palier_expert as $num=>$palier)
                                                            
                                                            @php
                                                                $niveau=$palier[0] ;
                                                                $pourcent_plus=$palier[1] ;
                                                                $ca_min=$palier[2] ;
                                                                $ca_max=$palier[3] ;
                                                                $percent_diff -= $pourcent_plus;
                                                                $y=$niveau;
                                                            @endphp
                                                        <div class="form-inline field{{$niveau}}">
                                                            <div class="form-group">
                                                                <label for="level_expert{{$niveau}}">Niveau: </label>
                                                                <input class="form-control" type="text" value="{{$niveau}}" id="level_expert{{$niveau}}" name="level_expert{{$niveau}}" readonly >
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="percent_expert{{$niveau}}">% en + : </label>
                                                                <input class="form-control" type="number" min="0" max="{{$percent_diff}}" step="0.10" value="{{$pourcent_plus}}" id="percent_expert{{$niveau}}" name="percent_expert{{$niveau}} " >
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="ca_min_expert{{$niveau}}">CA min (€) : </label>
                                                                <input class="form-control" type="number" value="{{$ca_min}}" id="ca_min_expert{{$niveau}}" name="ca_min_expert{{$niveau}}" readonly >
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="ca_max_expert{{$niveau}}">CA max (€) : </label>
                                                                <input class="form-control" type="number" min="0" value="{{$ca_max}}" id="ca_max_expert{{$niveau}}" name="ca_max_expert{{$niveau}}" />
                                                            </div>
                                                            @if ($niveau == $nb_palier_expert+1 )
                                                                <button href="#" id="pal_expert{{$niveau}}" class="btn btn-danger remove_field">Enlever</button></br>
                                                            @else
                                                                <button href="#" id="pal_expert{{$niveau}}" class="btn btn-danger cacher_btn_remove_field remove_field">Enlever</button></br>
                                                            @endif
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">

                                        <div class="col-lg-12" id="expert-par">
                                            <div class="panel panel-default m-t-15">
                                                <div class="panel-heading-default"><strong>conditions du pack expert</strong></div>
                                                <div class="panel-body">
                                                    <strong>Pour garder le pourcentage de départ défini en haut à l'année N voici les conditions à réaliser sur l'année N-1:
                                                    <br>
                                                    <br>
                                                    </strong>

                                                    <div class="row">
                                                        <div class="col-lg-6-col-md-6 col-sm-6">
                                                            <div class="form-group row">
                                                                <label class="col-lg-6 col-md-6 col-sm-6 col-form-label"  @if($contrat->modif_nombre_vente_min == true) style="background:#f291bf"  @endif for="nombre_vente_min">Nombre de vente minimum</label>
                                                                <div class="col-lg-4 col-md-4 col-sm-4 ">
                                                                    <input class="form-control" type="number" min="0" value="{{$contrat->nombre_vente_min}}" id="nombre_vente_min" name="nombre_vente_min" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-lg-6 col-md-6 col-sm-6 col-form-label"  @if($contrat->modif_nombre_mini_filleul == true) style="background:#f291bf"  @endif for="nombre_mini_filleul">Nombre minimum de filleuls parrainés</label>
                                                                <div class="col-lg-4 col-md-4 col-sm-4 ">
                                                                    <input class="form-control" type="number" min="0" value="{{$contrat->nombre_mini_filleul}}" id="nombre_mini_filleul" name="nombre_mini_filleul" required>
                                                                </div>
                                                            </div>
                                                            @php
                                                                $check_exp =  ($contrat->a_condition_expert == true) ? "checked" : "unchecked";
                                                            @endphp
                                                            <div class="form-group row">
                                                                <label class="col-lg-6 col-form-label"  @if($contrat->modif_a_condition_expert == true) style="background:#f291bf"  @endif for="a_condition_expert">Appliquer ces conditions au mandataire ?</label>
                                                                <div class="col-lg-6">
                                                                    <input type="checkbox" {{$check_exp}} data-toggle="toggle" id="a_condition_expert" name="a_condition_expert" data-off="Non" data-on="Oui" data-onstyle="success" data-offstyle="danger">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6-col-md-6 col-sm-6">
                                                            <div class="form-group row">
                                                                <label class="col-lg-6 col-md-6 col-sm-6 col-form-label"  @if($contrat->modif_chiffre_affaire == true) style="background:#f291bf"  @endif for="chiffre_affaire">Chiffre d'affaires HT (€) </label>
                                                                <div class="col-lg-4 col-md-4 col-sm-4 ">
                                                                    <input class="form-control" type="number" min="0" value="{{$contrat->chiffre_affaire_mini}}" id="chiffre_affaire" name="chiffre_affaire" required>
                                                                </div>
                                                            </div>
                                                            <strong>Si ces conditions ne sont pas réunies alors:
                                                            <br>
                                                            <br>
                                                            </strong>
                                                            <div class="form-group row">
                                                                <label class="col-lg-6 col-md-6 col-sm-6 col-form-label"  @if($contrat->modif_a_soustraitre == true) style="background:#f291bf"  @endif for="a_soustraitre">A soustraire (%)</label>
                                                                <div class="col-lg-4 col-md-4 col-sm-4 ">
                                                                    <input class="form-control" type="number" min="0" value="{{$contrat->a_soustraitre}}" step="0.10" id="a_soustraitre" name="a_soustraitre" required>
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
                            {{-- FIN PACK EXPERT --}}




                            </div>
                        </div>
                    </fieldset>
                </div>
                <br>

                
                <div class="panel-body" id="parrainage_div">
                    <fieldset class="col-md-12">
                        <legend>Parrainage</legend>
                        <div class="panel panel-warning">
                            <div class="panel-body">

                                <div class="row">
                                                            <!-- /# column -->
                        <div class="col-lg-12">
                                <div class="card alert">
                                    <div class="card-header">
                                        <h4>&Eacute;volution de l'impact </h4>
            
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                       
                                                        <th>Année</th>
                                                        <th>1er filleul</th>
                                                        <th>2<sup> ème</sup> filleul</th>
                                                        <th>3<sup> ème</sup> filleul</th>
                                                        <th>n<sup> ème</sup> filleul</th>
                                                        <th  style="background-color:#928E81" >&nbsp;</th>
                                                        <th>Seuil (CA)  parrain</th>
                                                        <th>Seuil (CA)  filleul</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{-- {{dd($comm_parrain)}} --}}
                                                    <tr>
                                                        <th class="color-primary" scope="row">1</th>
                                                        <td><input type="number" style="background-color:#ecf0f9;" min="0" max="50" class="form-control" value="{{$comm_parrain['p_1_1']}}" id="p_1_1" name="p_1_1" required>  </td>
                                                        <td><input type="number" style="background-color:#ecf0f9" min="0" max="50" class="form-control" value="{{$comm_parrain['p_1_2']}}" id="p_1_2" name="p_1_2" required></td>
                                                        <td><input type="number" style="background-color:#ecf0f9" min="0" max="50" class="form-control" value="{{$comm_parrain['p_1_3']}}" id="p_1_3" name="p_1_3" required></td>
                                                        <td><input type="number" style="background-color:#ecf0f9" min="0" max="50" class="form-control" value="{{$comm_parrain['p_1_n']}}" id="p_1_n" name="p_1_n" required></td>
                                                        <td>&nbsp;</td>
                                                        <td><input type="number" style="background-color:#FFF8DC " min="0"  class="form-control" value="{{$comm_parrain['seuil_parr_1']}}" id="seuil_parr_1" name="seuil_parr_1" required></td>
                                                        <td><input type="number" style="background-color:#FFF8DC" min="0"  class="form-control" value="{{$comm_parrain['seuil_fill_1']}}" id="seuil_fill_1" name="seuil_fill_1" required></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="color-primary" scope="row">2</th>
                                                        <td><input type="number" style="background-color:#ecf0f9" min="0" max="50" class="form-control" value="{{$comm_parrain['p_2_1']}}" id="p_2_1" name="p_2_1" required></td>
                                                        <td><input type="number" style="background-color:#ecf0f9" min="0" max="50" class="form-control" value="{{$comm_parrain['p_2_2']}}" id="p_2_2" name="p_2_2" required></td>
                                                        <td><input type="number" style="background-color:#ecf0f9" min="0" max="50" class="form-control" value="{{$comm_parrain['p_2_3']}}" id="p_2_3" name="p_2_3" required></td>
                                                        <td><input type="number" style="background-color:#ecf0f9" min="0" max="50" class="form-control" value="{{$comm_parrain['p_2_n']}}" id="p_2_n" name="p_2_n" required></td>
                                                        <td>&nbsp;</td>
                                                        <td><input type="number" style="background-color:#FFF8DC " min="0"  class="form-control" value="{{$comm_parrain['seuil_parr_2']}}" id="seuil_parr_2" name="seuil_parr_2" required></td>
                                                        <td><input type="number" style="background-color:#FFF8DC" min="0"  class="form-control" value="{{$comm_parrain['seuil_fill_2']}}" id="seuil_fill_2" name="seuil_fill_2" required></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="color-primary" scope="row">3</th>
                                                        <td><input type="number" style="background-color:#ecf0f9" min="0" max="50" class="form-control" value="{{$comm_parrain['p_3_1']}}" id="p_3_1" name="p_3_1" required></td>
                                                        <td><input type="number" style="background-color:#ecf0f9" min="0" max="50" class="form-control" value="{{$comm_parrain['p_3_2']}}" id="p_3_2" name="p_3_2" required></td>
                                                        <td><input type="number" style="background-color:#ecf0f9" min="0" max="50" class="form-control" value="{{$comm_parrain['p_3_3']}}" id="p_3_3" name="p_3_3" required></td>
                                                        <td><input type="number" style="background-color:#ecf0f9" min="0" max="50" class="form-control" value="{{$comm_parrain['p_3_n']}}" id="p_3_n" name="p_3_n" required></td>
                                                        <td>&nbsp;</td>
                                                        <td><input type="number" style="background-color:#FFF8DC " min="0"  class="form-control" value="{{$comm_parrain['seuil_parr_3']}}" id="seuil_parr_3" name="seuil_parr_3" required></td>
                                                        <td><input type="number" style="background-color:#FFF8DC" min="0"  class="form-control" value="{{$comm_parrain['seuil_fill_3']}}" id="seuil_fill_3" name="seuil_fill_3" required></td>
                                                    </tr>
                                                   
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group row" id="max-starter-parrent">
                                        <label class="col-lg-6 col-md-6 col-sm-6 col-form-label col-form-label"  @if($contrat->modif_seuil_comm == true) style="background:#f291bf"  @endif for="seuil_comm">Seuil de la commission de parrainage<span class="text-danger">*</span></label>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <input type="number" class="form-control" id="seuil_comm" name="seuil_comm" min="0" value="{{$contrat->seuil_comm}}" required>
                                        </div>
                                    </div>
                                </div>
                                </div>


                            </div>
                        </div>
                    </fieldset>
                </div>
                <br>

                <div class="panel-body">
                    <fieldset class="col-md-12">
                        <legend>Pack pub</legend>
                        <div class="panel panel-warning">
                            <div class="panel-body">

                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="form-group row">
                                            <select class="col-lg-4 col-md-4 col-sm-4 form-control" id="pack_pub" name="pack_pub">
                                                <option value="{{$contrat->packpub->id}}">{{$contrat->packpub->nom}}</option>
                                               
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </fieldset>
                </div>


                {{-- GESTION DE LA DEMISSION --}}

                
                <div class="panel-body">
                    <fieldset class="col-md-12">
                        <legend>Démission</legend>
                        <div class="panel panel-warning">
                            <div class="panel-body">

                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="form-group row">
                                            <label class="col-lg-6 col-form-label"  @if($contrat->modif_a_demission == true) style="background:#f291bf"  @endif for="a_demission">Le mandataire démissionne ?</label>
                                            <div class="col-lg-6">
                                            @php $check_demi =  ($contrat->a_demission == true) ? "checked" : "unchecked"; @endphp                                           

                                                <input type="checkbox" {{$check_demi}} data-toggle="toggle" id="a_demission" name="a_demission" data-off="Non" data-on="Oui" data-onstyle="success" data-offstyle="danger">
                                           
                                            </div>
                                        </div>
                                        </div>


                                        <div class="col-lg-6 col-md-6 col-sm-6 div_demission">
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label"  @if($contrat->modif_date_demission == true) style="background:#f291bf"  @endif for="date_demission">Date de démission<span class="text-danger">*</span></label>
                                                <div class="col-lg-4">
                                                    <input type="date" class="form-control" value="@if($contrat->date_demission != null ){{$contrat->date_demission->format('Y-m-d')}}@endif" id="date_demission" name="date_demission" >
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="col-lg-6 col-md-6 col-sm-6 div_demission">
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label"  @if($contrat->modif_date_fin_preavis == true) style="background:#f291bf"  @endif for="date_fin_preavis">Date de fin de préavis<span class="text-danger">*</span></label>
                                                <div class="col-lg-4">
                                                    <input type="date" class="form-control" value="@if($contrat->date_fin_preavis != null ){{$contrat->date_fin_preavis->format('Y-m-d')}}@endif" id="date_fin_preavis" name="date_fin_preavis" >
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="col-lg-6 col-md-6 col-sm-6 div_demission">
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label"  @if($contrat->modif_date_fin_droit_suite == true) style="background:#f291bf"  @endif for="date_fin_droit_suite">Date fin de droit de suite<span class="text-danger">*</span></label>
                                                <div class="col-lg-4">
                                                    <input type="date" class="form-control" value="@if($contrat->date_fin_droit_suite != null ){{$contrat->date_fin_droit_suite->format('Y-m-d')}}@endif" id="date_fin_droit_suite" name="date_fin_droit_suite" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <div class="panel-body">
                                    <fieldset class="col-md-12">
                                        <legend>Documents</legend>
                                        <div class="panel panel-warning">
                                            <div class="panel-body">
                
                                                
                
                                                <div class="row"  @if($contrat->modif_contrat_pdf == true) style="background:#f291bf"  @endif>
                                                    @if($contrat->contrat_pdf)
                                                    <a href="{{route('historiquecontrat.telecharger', Crypt::encrypt($contrat->id))}}"data-toggle="tooltip" title="Réinitialiser le contrat"  class="btn btn-danger btn-flat btn-addon "><i class="ti-download"></i>télécharger le contrat</a> 
                
                                                    @endif
                                                      
                                                      
                                                </div>
                      
                                            </div>
                
                                        </div>
                                </div>
                                        
                               
                               

                               

                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>

          

            </form>
        </div>
    </div>
</div>
@stop @section('js-content') 


<script>

$("input").prop('disabled', true)

</script>
{{-- ###### Parrainage --}}
<script>

    if ("{{$contrat->a_parrain}}" == false){
         $('#parrain-id').hide();
    $('#parrainage_div').hide();

         
    }

    $('#a_parrain').change(function(e) {
        e.preventDefault();
        if($("#a_parrain").prop('checked')){
            $('#parrain-id').slideDown();
            $('#parrainage_div').slideDown();
        }else{
            $('#parrain-id').slideUp();
            $('#parrainage_div').slideUp();
            
        }
        

    });
</script>
{{-- ###### Fin parrain --}}
{{-- ##### Pack Starter  --}}

<script>
    // console.log("{{$contrat->est_demarrage_starter}}");
    
    if("{{$contrat->est_demarrage_starter}}" == 0){
        $('#pack_starter').hide();
    }
    if("{{$contrat->a_palier_starter}}" == 0){
            $('#palier_starter').hide();           
    }

    
    $("#est_starter").change(function(e) {
        e.preventDefault();
        if($("#est_starter").prop('checked')){
            $('#pack_starter').slideDown();
        }else{
            $('#pack_starter').slideUp();            
        }

    });
    $("#check_palier_starter").change(function(e) {
        e.preventDefault();
        if($("#check_palier_starter").prop('checked')){
            $('#palier_starter').slideDown();
        }else{
            $('#palier_starter').slideUp();            
        }

    });
</script>



<script>
    var x = "{{$x}}";
    $(".cacher_btn_remove_field").hide();
    $(document).ready(function() {
        var max_fields = 15;
        var wrapper = $(".input_fields_wrap_starter");
        var add_button = $(".add_field_button_starter");

      
        $(add_button).click(function(e) {
            e.preventDefault();
            if (x < max_fields) {
                var ca_min_starter = parseInt($("#ca_max_starter" + x + '').change().val()) + 1;
            
                
                var percent_diff = (95  - (parseFloat($("#pourcentage_depart_starter").change().val() ))) ;
                var i = 1;
                while (i <= x) {
                    let tmp = parseFloat($("#percent_starter" + i + '').change().val() ) ;
                    percent_diff = (percent_diff  - tmp ) ;
                    i++;
                }
                if (x > 1 && percent_diff > 0)
                    $("#pal_starter" + x + '').hide();
                if (percent_diff > 0)
                    x++;
                if (percent_diff < 0) {
                    percent_diff = 0;

                }
                var val_chiffre = parseInt(ca_min_starter) + 19999;
                
                if (percent_diff > 5)
                    $(wrapper).append('<div class = "form-inline field' + x + '"><div class="form-group"><label  @if($contrat->modif_level_starter == true) style="background:#f291bf"  @endif for="level_starter' + x + '">Niveau: </label> <input class="form-control" type="text" value="' + x + '" id="level_starter' + x + '" name="level_starter' + x + '"/ readonly></div> <div class="form-group"><label  @if($contrat->modif_percent_starter == true) style="background:#f291bf"  @endif for="percent_starter' + x + '">% en + : </label> <input class="form-control" type="number" step="0.10" min="0" max="' + percent_diff + '" value="' + percent_diff + '" id="percent_starter' + x + '" name="percent_starter' + x + '"/> </div> <div class="form-group"><label  @if($contrat->modif_ca_min_starter == true) style="background:#f291bf"  @endif for="ca_min_starter' + x + '">CA min (€): </label> <input class="form-control" type="number" value="' + ca_min_starter + '" id="ca_min_starter' + x + '" name="ca_min_starter' + x + '" readonly></div> <div class="form-group"><label  @if($contrat->modif_ca_max_starter == true) style="background:#f291bf"  @endif for="ca_max_starter' + x + '">CA max (€): </label> <input class="form-control" type="number" min="' + ca_min_starter + '" value="' + val_chiffre + '" id="ca_max_starter' + x + '" name="ca_max_starter' + x + '"/></div>  <button href="#" id="pal_starter' + x + '" class="btn btn-danger remove_field">Enlever</button></br></div>'); //add input box
                else if (percent_diff <= 5 && percent_diff > 0)
                    $(wrapper).append('<div class = "form-inline field' + x + '"><div class="form-group"><label  @if($contrat->modif_level_starter == true) style="background:#f291bf"  @endif for="level_starter' + x + '">Niveau: </label> <input class="form-control" type="text" value="' + x + '" id="level_starter' + x + '" name="level_starter' + x + '"/ readonly></div> <div class="form-group"><label  @if($contrat->modif_percent_starter == true) style="background:#f291bf"  @endif for="percent_starter' + x + '">% en + : </label> <input class="form-control" type="number" step="0.10" min="0" max="' + percent_diff + '" value="' + percent_diff + '" id="percent_starter' + x + '" name="percent_starter' + x + '"/> </div> <div class="form-group"><label  @if($contrat->modif_ca_min_starter == true) style="background:#f291bf"  @endif for="ca_min_starter' + x + '">CA min (€): </label> <input class="form-control" type="number" value="' + ca_min_starter + '" id="ca_min_starter' + x + '" name="ca_min_starter' + x + '" readonly></div> <div class="form-group"><label  @if($contrat->modif_ca_max_starter == true) style="background:#f291bf"  @endif for="ca_max_starter' + x + '">CA max (€): </label> <input class="form-control" type="number" min="' + ca_min_starter + '" value="' + val_chiffre + '" id="ca_max_starter' + x + '" name="ca_max_starter' + x + '"/></div>  <button href="#" id="pal_starter' + x + '" class="btn btn-danger remove_field">Enlever</button></br></div>'); //add input box
                else {
                    
                    swal(
                        'Ajout impossible!',
                        'Le maximum de 95% en pourcentage est atteint, vous ne pouvez pas ajouter d\'avantages de paliers!',
                        'error'
                    );
                }
            }
        });

        $(wrapper).on("click", ".remove_field", function(e) {
            e.preventDefault();
            if (x > 2) $("#pal_starter" + (x - 1) + '').show();
            $(this).parent('div').remove();
            x--;
        })
    });

</script>

{{--########### Fin pack starter --}}




{{-- ##### Pack Expert  --}}

<script>
  
   
    if("{{$contrat->a_palier_expert}}" == 0){
            $('#palier_expert').hide();           
    }

    
    
    $("#check_palier_expert").change(function(e) {
        e.preventDefault();
        if($("#check_palier_expert").prop('checked')){
            $('#palier_expert').slideDown();
        }else{
            $('#palier_expert').slideUp();            
        }

    });
</script>
    
    
<script>
    var y = "{{$y}}" ;

    $(document).ready(function() {
        var max_fields = 15;
        var wrapper = $(".input_fields_wrap_expert");
        var add_button = $(".add_field_button_expert");

        
        $(add_button).click(function(e) {
            e.preventDefault();
            if (y < max_fields) {
                var ca_min_expert = parseInt($("#ca_max_expert" + y + '').change().val()) + 1;
            
                console.log(ca_min_expert);
                
                var percent_diff = (95  - (parseFloat($("#pourcentage_depart_expert").change().val() ))) ;
                var i = 1;
                while (i <= y) {
                    let tmp = parseFloat($("#percent_expert" + i + '').change().val() ) ;
                    percent_diff = (percent_diff  - tmp ) ;
                    i++;
                }
                if (y > 1 && percent_diff > 0)
                    $("#pal_expert" + y + '').hide();
                if (percent_diff > 0)
                    y++;
                if (percent_diff < 0) {
                    percent_diff = 0;

                }
                var val_chiffre = parseInt(ca_min_expert) + 19999;
                
                if (percent_diff > 5)
                    $(wrapper).append('<div class = "form-inline field' + y + '"><div class="form-group"><label  @if($contrat->modif_level_expert == true) style="background:#f291bf"  @endif for="level_expert' + y + '">Niveau: </label> <input class="form-control" type="text" value="' + y + '" id="level_expert' + y + '" name="level_expert' + y + '"/ readonly></div> <div class="form-group"><label  @if($contrat->modif_percent_expert == true) style="background:#f291bf"  @endif for="percent_expert' + y + '">% en + : </label> <input class="form-control" type="number" step="0.10" min="0" max="' + percent_diff + '" value="' + percent_diff + '" id="percent_expert' + y + '" name="percent_expert' + y + '"/> </div> <div class="form-group"><label  @if($contrat->modif_ca_min_expert == true) style="background:#f291bf"  @endif for="ca_min_expert' + y + '">CA min (€): </label> <input class="form-control" type="number" value="' + ca_min_expert + '" id="ca_min_expert' + y + '" name="ca_min_expert' + y + '" readonly></div> <div class="form-group"><label  @if($contrat->modif_ca_max_expert == true) style="background:#f291bf"  @endif for="ca_max_expert' + y + '">CA max (€): </label> <input class="form-control" type="number" min="' + ca_min_expert + '" value="' + val_chiffre + '" id="ca_max_expert' + y + '" name="ca_max_expert' + y + '"/></div>  <button href="#" id="pal_expert' + y + '" class="btn btn-danger remove_field">Enlever</button></br></div>'); //add input box
                else if (percent_diff <= 5 && percent_diff > 0)
                    $(wrapper).append('<div class = "form-inline field' + y + '"><div class="form-group"><label  @if($contrat->modif_level_expert == true) style="background:#f291bf"  @endif for="level_expert' + y + '">Niveau: </label> <input class="form-control" type="text" value="' + y + '" id="level_expert' + y + '" name="level_expert' + y + '"/ readonly></div> <div class="form-group"><label  @if($contrat->modif_percent_expert == true) style="background:#f291bf"  @endif for="percent_expert' + y + '">% en + : </label> <input class="form-control" type="number" step="0.10" min="0" max="' + percent_diff + '" value="' + percent_diff + '" id="percent_expert' + y + '" name="percent_expert' + y + '"/> </div> <div class="form-group"><label  @if($contrat->modif_ca_min_expert == true) style="background:#f291bf"  @endif for="ca_min_expert' + y + '">CA min (€): </label> <input class="form-control" type="number" value="' + ca_min_expert + '" id="ca_min_expert' + y + '" name="ca_min_expert' + y + '" readonly></div> <div class="form-group"><label  @if($contrat->modif_ca_max_expert == true) style="background:#f291bf"  @endif for="ca_max_expert' + y + '">CA max (€): </label> <input class="form-control" type="number" min="' + ca_min_expert + '" value="' + val_chiffre + '" id="ca_max_expert' + y + '" name="ca_max_expert' + y + '"/></div>  <button href="#" id="pal_expert' + y + '" class="btn btn-danger remove_field">Enlever</button></br></div>'); //add input box
                else {
                    swal(
                        'Ajout impossible!',
                        'Le maximum de 95% en pourcentage est atteint, vous ne pouvez pas ajouter d\'avantages de paliers!',
                        'error'
                    );
                }
            }
        });

        $(wrapper).on("click", ".remove_field", function(e) {
            e.preventDefault();
            if (y > 2) $("#pal_expert" + (y - 1) + '').show();
            $(this).parent('div').remove();
            y--;
        })
    });
</script>

{{-- Fin pack Expert --}}



{{-- DEMISSION DU MANDATAIRE --}}
<script>


if($("#a_demission").prop('checked')){
    $('.div_demission').show();
}else{
    $('.div_demission').hide();
    
}
$('#a_demission').change(function(e) {
        e.preventDefault();
        if($("#a_demission").prop('checked')){
            $('.div_demission').show();

            $('#date_fin_preavis').attr('required','required');
            $('#date_demission').attr('required','required');
            $('#date_fin_droit_suite').attr('required','required');

        }else{
            $('.div_demission').hide();

            $('#date_fin_preavis').removeAttr('required');
            $('#date_demission').removeAttr('required');
            $('#date_fin_droit_suite').removeAttr('required');
        }
});




</script>
@endsection