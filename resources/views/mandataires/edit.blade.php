@extends('layouts.app')
@section('content')
@section ('page_title')
Modifier mandataire {{$mandataire->nom}}
@endsection
<div class="row">
   <div class="col-lg-12 col-md-12 col-sm-12">
      @if (session('ok'))
      <div class="alert alert-success alert-dismissible fade in">
         <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
         <strong> {{ session('ok') }}</strong>
      </div>
      @endif      
      <div class="card">
         <div class="col-lg-12">
            <a href="{{route('mandataire.index')}}" class="btn btn-default btn-flat btn-addon m-b-10 m-l-5"><i class="ti-angle-double-left"></i>@lang('Liste des mandataires')</a>
            
            @if($mandataire->contrat != null) 
            <a href="{{route('contrat.edit',Crypt::encrypt($mandataire->contrat->id) )}}"  class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5"><i class="ti-pencil"></i>Modifier le contrat</a>
            @else
            <a href="{{route('contrat.create',Crypt::encrypt($mandataire->id) )}}"  class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5"><i class="ti-pencil"></i>Ajouter un contrat</a>
            @endif
         </div>
         <div class="card-body">
            <div class="form-validation">
               <form class="form-valide form-horizontal" action="{{ route('mandataire.update',$mandataire->id) }}" method="post">
                  {{ csrf_field() }}

                <div class="row">
                    <hr>
                    <hr>
                    <hr>
                    <div class="col-lg-6 col-md-6 col-sm-6">

                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="statut">Statut <span class="text-danger">*</span></label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <select class="js-select2 form-control {{$errors->has('statut') ? 'is-invalid' : ''}}" id="statut" name="statut" style="width: 100%;" data-placeholder="Choose one.." required>
                               <option value="{{$mandataire->statut}}" >{{$mandataire->statut}}</option>
                                  <option value="independant">Indépendant</option>
                                  <option value="auto-entrepreneur">Auto Entrepreneur</option>
                                  <option value="portage-salarial">Portage Salarial</option>
                               </select>
                               @if ($errors->has('statut'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('statut')}}</strong> 
                               </div>
                               @endif
                            </div>
                         </div>
       
                         <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="civilite">@lang('Civilité') <span class="text-danger">*</span></label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                            <select class="js-select2 form-control {{$errors->has('civilite') ? 'is-invalid' : ''}}"  id="civilite" name="civilite" style="width: 100%;" data-placeholder="Choose one.." required>
                                  <option value="{{$mandataire->civilite}}" > {{$mandataire->civilite}}</option>
                                  <option value="M.">M.</option>
                                  <option value="Mme.">Mme.</option>
                               </select>
                               @if ($errors->has('civilite'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('civilite')}}</strong> 
                               </div>
                               @endif
                            </div>
                         </div>
       
                         <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="nom">Nom <span class="text-danger">*</span></label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="text" class="form-control {{$errors->has('nom') ? 'is-invalid' : ''}}" value="{{old('nom') ? old('nom') : $mandataire->nom}}" id="nom" name="nom" placeholder="Nom.." required>
                               @if ($errors->has('val-lastname'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('nom')}}</strong> 
                               </div>
                               @endif
                            </div>
                         </div>
       
                         <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="prenom">Prénom <span class="text-danger">*</span></label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="text"  class="form-control {{ $errors->has('prenom') ? ' is-invalid' : '' }}" value="{{old('prenom')? old('prenom') : $mandataire->prenom}}" id="prenom" name="prenom" placeholder="Prénom.." required>
                               @if ($errors->has('val-firstname'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('prenom')}}</strong> 
                               </div>
                               @endif
                            </div>
                         </div>
       
                         <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="val-email">Email pro <span class="text-danger">*</span></label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" id="val-email" value="{{old('email')? old('email') : $mandataire->email}}" name="email" placeholder="Email.." required>
                               @if ($errors->has('email'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('email')}}</strong> 
                               </div>
                               @endif
                            </div>
                         </div>
                         <div class="form-group row">
                              <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="val-email_perso">Email perso<span class="text-danger">*</span></label>
                              <div class="col-lg-8 col-md-8 col-sm-8">
                                 <input type="email" class="form-control {{ $errors->has('email_perso') ? ' is-invalid' : '' }}" id="val-email_perso" value="{{old('email_perso')? old('email_perso') : $mandataire->email_perso}}" name="email_perso" placeholder="Email.." required>
                                 @if ($errors->has('email_perso'))
                                 <br>
                                 <div class="alert alert-warning ">
                                    <strong>{{$errors->first('email_perso')}}</strong> 
                                 </div>
                                 @endif
                              </div>
                           </div>
                         <div class="form-group row">
                              <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="siret">Numero siret </label>
                              <div class="col-lg-8 col-md-8 col-sm-8">
                                 <input type="text" class="form-control {{ $errors->has('siret') ? ' is-invalid' : '' }}" value="{{old('siret')? old('siret') : $mandataire->siret}}" id="siret" name="siret" placeholder="Ex: 2561452136582" >
                                 @if ($errors->has('siret'))
                                    <br>
                                    <div class="alert alert-warning ">
                                       <strong>{{$errors->first('siret')}}</strong> 
                                    </div>
                                 @endif     
                              </div>
                        </div>
                        <div class="form-group row">
                              <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="numero_tva">Numéro TVA intracommunautaire </label>
                              <div class="col-lg-8 col-md-8 col-sm-8">
                                 <input type="text" class="form-control {{ $errors->has('numero_tva') ? ' is-invalid' : '' }}" value="{{old('numero_tva')? old('numero_tva') : $mandataire->numero_tva}}" id="numero_tva" name="numero_tva"  >
                                 @if ($errors->has('numero_tva'))
                                    <br>
                                    <div class="alert alert-warning ">
                                       <strong>{{$errors->first('numero_tva')}}</strong> 
                                    </div>
                                 @endif     
                              </div>
                        </div>

                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">

                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="adresse">Adresse </label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="text" class="form-control {{ $errors->has('adresse') ? ' is-invalid' : '' }}" value="{{old('adresse')? old('adresse') : $mandataire->adresse}}" id="adresse" name="adresse" placeholder="N° et Rue.." >
                               @if ($errors->has('adresse'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('adresse')}}</strong> 
                               </div>
                               @endif   
                            </div>
                         </div>
       
                         <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" value="" for="compl_adresse">Complément d'adresse</label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="text" id="compl_adresse" class="form-control {{ $errors->has('compl_adresse') ? ' is-invalid' : '' }}" value="{{old('compl_adresse')? old('compl_adresse') : $mandataire->complement_adresse}}" name="compl_adresse" placeholder="Complément d'adresse..">
                               @if ($errors->has('compl_adresse'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('compl_adresse')}}</strong> 
                               </div>
                               @endif 
                            </div>
                         </div>
       
                         <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="code_postal">Code postal</label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="text" class="form-control {{ $errors->has('code_postal') ? ' is-invalid' : '' }}" value="{{old('code_postal')? old('code_postal') : $mandataire->code_postal}}" id="code_postal" name="code_postal" placeholder="Ex: 75001.." >
                               @if ($errors->has('code_postal'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('code_postal')}}</strong> 
                               </div>
                               @endif 
                            </div>
                         </div>
       
                         <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="ville">Ville </label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="text" class="form-control {{ $errors->has('ville') ? ' is-invalid' : '' }}" value="{{old('ville')? old('ville') : $mandataire->ville}}" id="ville" name="ville" placeholder="EX: Paris.." >
                               @if ($errors->has('ville'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('ville')}}</strong> 
                               </div>
                               @endif 
                            </div>
                         </div>
       
                         <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="pays">Pays </label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="text" class="form-control {{ $errors->has('pays') ? ' is-invalid' : '' }}" value="{{old('pays')? old('pays') : $mandataire->pays}}" id="pays" name="pays" placeholder="Entez une lettre et choisissez.." >
                               @if ($errors->has('pays'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('pays')}}</strong> 
                               </div>
                               @endif 
                            </div>
                         </div>
       
                         <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="telephone1">Téléphone (FR) </label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="text" class="form-control {{ $errors->has('telephone1') ? ' is-invalid' : '' }}" value="{{old('telephone1')? old('telephone1') : $mandataire->telephone1}}" id="telephone1" name="telephone1" placeholder="Ex: 0600000000.." >
                               @if ($errors->has('telephone1'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('telephone1')}}</strong> 
                               </div>
                               @endif     
                            </div>
                         </div>
                         <div class="form-group row">
                           <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="telephone2">Téléphone (FR) </label>
                           <div class="col-lg-8 col-md-8 col-sm-8">
                              <input type="text" class="form-control {{ $errors->has('telephone2') ? ' is-invalid' : '' }}" value="{{old('telephone2')? old('telephone2') : $mandataire->telephone2}}" id="telephone2" name="telephone2" placeholder="Ex: 0600000000.." >
                              @if ($errors->has('telephone2'))
                              <br>
                              <div class="alert alert-warning ">
                                 <strong>{{$errors->first('telephone2')}}</strong> 
                              </div>
                              @endif     
                           </div>
                        </div>
                    </div>
                </div>
                  
                  <div class="form-group row" style="text-align: center; margin-top: 50px;">
                     <div class="col-lg-8 ml-auto">
                        <button class="btn btn-success btn-flat btn-addon btn-lg m-b-10 m-l-5 submit" id="ajouter" ><i class="ti-save"></i>Sauvegarder</button>
                     <a  href="{{route('mandataire.index')}}" class="btn btn-default btn-flat btn-addon btn-lg m-b-10 m-l-5 submit" id="ajouter"><i class="ti-close"></i>Annuler</a >
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>


@stop
@section('js-content') 
@endsection