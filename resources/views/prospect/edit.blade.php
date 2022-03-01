@extends('layouts.app')
@section('content')
@section ('page_title')
Modifier prospect {{$prospect->nom}}
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
            <a href="{{route('prospect.index')}}" class="btn btn-default btn-flat btn-addon m-b-10 m-l-5"><i class="ti-angle-double-left"></i>@lang('Liste des prospects')</a>
            
           
         </div>
         <div class="card-body">
            <div class="form-validation">
               <form class="form-valide form-horizontal" action="{{ route('prospect.update', Crypt::encrypt($prospect->id)) }}" method="post">
                  {{ csrf_field() }}

                <div class="row">
                    <hr>
                    <hr>
                    <hr>
                    <div class="col-lg-6 col-md-6 col-sm-6">

                      
       
                         <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="civilite">@lang('Civilité') <span class="text-danger">*</span></label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                            <select class="js-select2 form-control {{$errors->has('civilite') ? 'is-invalid' : ''}}"  id="civilite" name="civilite" style="width: 100%;" data-placeholder="Choose one.." required>
                                  <option value="{{$prospect->civilite}}" > {{$prospect->civilite}}</option>
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
                               <input type="text" class="form-control {{$errors->has('nom') ? 'is-invalid' : ''}}" value="{{old('nom') ? old('nom') : $prospect->nom}}" id="nom" name="nom" placeholder="Nom.." required>
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
                               <input type="text"  class="form-control {{ $errors->has('prenom') ? ' is-invalid' : '' }}" value="{{old('prenom')? old('prenom') : $prospect->prenom}}" id="prenom" name="prenom" placeholder="Prénom.." required>
                               @if ($errors->has('val-firstname'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('prenom')}}</strong> 
                               </div>
                               @endif
                            </div>
                         </div>
       
                         <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="val-email">Email Perso <span class="text-danger">*</span></label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" id="val-email" value="{{old('email')? old('email') : $prospect->email}}" name="email" placeholder="Email.." required>
                               @if ($errors->has('email'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('email')}}</strong> 
                               </div>
                               @endif
                            </div>
                         </div>
                         
                         @php
                             $ischecked = $prospect->a_parrain == true ? "checked":"unchecked";
                         
                         @endphp
                         <div class="form-group row">
                           <label  class="col-lg-4 col-md-4 col-sm-4 control-label" for="a_parrain">Le prospect a t'il un parrain ?</label>
                           <div class="col-lg-6">
                               <input type="checkbox"  {{$ischecked}} data-toggle="toggle" id="a_parrain" name="a_parrain" data-off="Non" data-on="Oui" data-onstyle="success" data-offstyle="danger">
                           </div>
                          </div>
                          <div id="parrain_div">
                              <div class="form-group row" >
                                  <label  class="col-lg-4 col-md-4 col-sm-4 control-label" for="parrain_id">Choisir le parrain</label>
                                  <div class="col-lg-8">
                                      <select class="selectpicker col-lg-6" id="parrain_id" name="parrain_id" data-live-search="true" data-style="btn-warning btn-rounded">
                                       @if($parr != null)
                                       <option value="{{ $parr->id }}" data-tokens="{{ $parr->nom }} {{ $parr->prenom }}">{{ $parr->nom }} {{ $parr->prenom }}</option>
                                       
                                       @endif
                                          @foreach ($parrains as $parrain )
                                          <option value="{{ $parrain->id }}" data-tokens="{{ $parrain->nom }} {{ $parrain->prenom }}">{{ $parrain->nom }} {{ $parrain->prenom }}</option>
                                          @endforeach
                                      </select>
                                  </div>
                              </div>
                          </div>
                          
                          <div id="source_div">
                              <div class="form-group row" >
                               <label  class="col-lg-4 col-md-4 col-sm-4 control-label" for="source">Choisir la source du prospect</label>
                               <div class="col-lg-8">
                                   <select class="selectpicker col-lg-6" id="source" name="source" data-live-search="true" data-style="btn-warning btn-rounded">
                                      
                                    @if($prospect->source != null)
                                    <option value="{{$prospect->source}}">{{$prospect->source}}</option>
                                    @endif
                                    <option value="Réseaux sociaux">Réseaux sociaux</option>
                                    <option value="Bouche à oreille">Bouche à oreille</option>
                                    <option value="Internet">Internet</option>
                                    <option value="Autre">Autre</option>
                                      
                                   </select>
                               </div>
                              </div>
                          </div>
                          
                          
                         <div class="form-group row">
                           <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="commentaire_perso">Commentaire admin</label>
                           <div class="col-lg-8 col-md-8 col-sm-8">
                             <textarea name="commentaire_perso" id="commentaire_perso" class="form-control" cols="30" rows="5"> {{old('commentaire_perso') ? old('commentaire_perso'):  $prospect->commentaire_perso }}</textarea>
                              @if ($errors->has('commentaire_perso'))
                              <br>
                              <div class="alert alert-warning ">
                                 <strong>{{$errors->first('commentaire_perso')}}</strong> 
                              </div>
                              @endif
                           </div>
                        </div>
                      

                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">

                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="adresse">Adresse </label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="text" class="form-control {{ $errors->has('adresse') ? ' is-invalid' : '' }}" value="{{old('adresse')? old('adresse') : $prospect->adresse}}" id="adresse" name="adresse" placeholder="N° et Rue.." >
                               @if ($errors->has('adresse'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('adresse')}}</strong> 
                               </div>
                               @endif   
                            </div>
                         </div>
       
                        
                         <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="code_postal">Code postal</label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="text" class="form-control {{ $errors->has('code_postal') ? ' is-invalid' : '' }}" value="{{old('code_postal')? old('code_postal') : $prospect->code_postal}}" id="code_postal" name="code_postal" placeholder="Ex: 75001.." >
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
                               <input type="text" class="form-control {{ $errors->has('ville') ? ' is-invalid' : '' }}" value="{{old('ville')? old('ville') : $prospect->ville}}" id="ville" name="ville" placeholder="EX: Paris.." >
                               @if ($errors->has('ville'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('ville')}}</strong> 
                               </div>
                               @endif 
                            </div>
                         </div>
       
                        
       
                         <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="telephone_portable">Téléphone Portable  </label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="text" class="form-control {{ $errors->has('telephone_portable') ? ' is-invalid' : '' }}" value="{{old('telephone_portable')? old('telephone_portable') : $prospect->telephone_portable}}" id="telephone_portable" name="telephone_portable" placeholder="Ex: 0600000000.." >
                               @if ($errors->has('telephone_portable'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('telephone_portable')}}</strong> 
                               </div>
                               @endif     
                            </div>
                         </div>
                         <div class="form-group row">
                           <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="telephone_fixe">Téléphone Fixe </label>
                           <div class="col-lg-8 col-md-8 col-sm-8">
                              <input type="text" class="form-control {{ $errors->has('telephone_fixe') ? ' is-invalid' : '' }}" value="{{old('telephone_fixe')? old('telephone_fixe') : $prospect->telephone_fixe}}" id="telephone_fixe" name="telephone_fixe" placeholder="Ex: 0600000000.." >
                              @if ($errors->has('telephone_fixe'))
                              <br>
                              <div class="alert alert-warning ">
                                 <strong>{{$errors->first('telephone_fixe')}}</strong> 
                              </div>
                              @endif     
                           </div>
                        </div>
                        
                        <div class="form-group row">
                           <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="commentaire_pro">Commentaire pro</label>
                           <div class="col-lg-8 col-md-8 col-sm-8">
                             <textarea name="commentaire_pro" id="commentaire_pro" class="form-control" cols="30" rows="5"> {{old('commentaire_pro') ? old('commentaire_pro'):  $prospect->commentaire_pro }}</textarea>
                              @if ($errors->has('commentaire_pro'))
                              <br>
                              <div class="alert alert-warning ">
                                 <strong>{{$errors->first('commentaire_pro')}}</strong> 
                              </div>
                              @endif
                           </div>
                        </div>
                        
                    </div>
                </div>
                  
                  <div class="form-group row" style="text-align: center; margin-top: 50px;">
                     <div class="col-lg-8 ml-auto">
                        <button class="btn btn-success btn-flat btn-addon btn-lg m-b-10 m-l-5 submit" id="ajouter" ><i class="ti-save"></i>Sauvegarder</button>
                     <a  href="{{route('prospect.index')}}" class="btn btn-default btn-flat btn-addon btn-lg m-b-10 m-l-5 submit" id="ajouter"><i class="ti-close"></i>Annuler</a >
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

{{-- ###### Parrainage --}}
<script>
    
    var isparrain = "{{$prospect->a_parrain}}";
    console.log(isparrain);
   // $('#parrain-id').hide();
    if(isparrain == false ){    
       $('#parrain_div').hide();
       $('#source_div').show();
       
    }else{
       $('#source_div').hide();
       $('#parrain_div').show();
    }

   $('#a_parrain').change(function(e) {
       e.preventDefault();
       if($("#a_parrain").prop('checked')){
           $('#parrain_div').slideDown();
           $('#source_div').slideUp();
       }else{
           $('#parrain_div').slideUp();
           $('#source_div').slideDown();
           
       }
       

   });
</script>
@endsection