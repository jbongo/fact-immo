@extends('layouts.app')
@section('content')
@section ('page_title')
Ajout d'un document à fournir
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
            <a href="{{route('document.liste')}}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5"><i class="ti-angle-double-left"></i>@lang('Liste des documents à fournir')</a>
         </div>
         <div class="card-body">
            <div class="form-validation">
               <form class="form-valide form-horizontal" action="{{ route('document.store') }}" method="post">
                  {{ csrf_field() }}

                <div class="row">
                    <hr>
                    <hr>
                    <hr>
                    <div class="col-lg-6 col-md-6 col-sm-6">

                  
       
                         <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="a_date_expiration">Le document à t'il une date d'expiration ? <span class="text-danger">*</span></label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <select class="js-select2 form-control {{$errors->has('a_date_expiration') ? 'is-invalid' : ''}}" id="a_date_expiration" name="a_date_expiration" style="width: 100%;" data-placeholder="Choose one.." required>
                                  <option value="{{old('a_date_expiration')}}">{{old('a_date_expiration')}}</option>
                                  <option value="Oui">Oui</option>
                                  <option value="Non">Non</option>
                               </select>
                               @if ($errors->has('a_date_expiration'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('a_date_expiration')}}</strong> 
                               </div>
                               @endif
                            </div>
                         </div>
       
                         <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="nom">Nom du document<span class="text-danger">*</span></label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="text" class="form-control {{$errors->has('nom') ? 'is-invalid' : ''}}" value="{{old('nom')}}" id="nom" name="nom" placeholder="Nom.." required>
                               @if ($errors->has('nom'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('nom')}}</strong> 
                               </div>
                               @endif
                            </div>
                         </div>
       
                     
                       
                        <div class="form-group row">
                           <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="description">Description</label>
                           <div class="col-lg-8 col-md-8 col-sm-8">
                             <textarea name="description" id="description" class="form-control" cols="30" rows="5"> {{old('description')}}</textarea>
                              @if ($errors->has('description'))
                              <br>
                              <div class="alert alert-warning ">
                                 <strong>{{$errors->first('description')}}</strong> 
                              </div>
                              @endif
                           </div>
                        </div>
                        
                        <div class="form-group row">
                           <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="supprime_si_demissionne">Supprimer le document si le mandataire démissionne ? <span class="text-danger">*</span></label>
                           <div class="col-lg-8 col-md-8 col-sm-8">
                              <select class="js-select2 form-control {{$errors->has('supprime_si_demissionne') ? 'is-invalid' : ''}}" id="supprime_si_demissionne" name="supprime_si_demissionne" style="width: 100%;" data-placeholder="Choose one.." required>
                                 <option value="{{old('supprime_si_demissionne')}}">{{old('supprime_si_demissionne')}}</option>
                                 <option value="Oui">Oui</option>
                                 <option value="Non">Non</option>
                              </select>
                              @if ($errors->has('supprime_si_demissionne'))
                              <br>
                              <div class="alert alert-warning ">
                                 <strong>{{$errors->first('supprime_si_demissionne')}}</strong> 
                              </div>
                              @endif
                           </div>
                        </div>
                        
                        <div class="form-group row">
                           <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="a_historique">Garder l'historique ? <span class="text-danger">*</span></label>
                           <div class="col-lg-8 col-md-8 col-sm-8">
                              <select class="js-select2 form-control {{$errors->has('a_historique') ? 'is-invalid' : ''}}" id="a_historique" name="a_historique" style="width: 100%;" data-placeholder="Choose one.." required>
                                 <option value="{{old('a_historique')}}">{{old('a_historique')}}</option>
                                 <option value="Oui">Oui</option>
                                 <option value="Non">Non</option>
                              </select>
                              @if ($errors->has('a_historique'))
                              <br>
                              <div class="alert alert-warning ">
                                 <strong>{{$errors->first('supprime_si_demissionne')}}</strong> 
                              </div>
                              @endif
                           </div>
                        </div>

                    </div>
                    
                    
                   
                    
                    <div class="col-lg-6 col-md-6 col-sm-6">

                        
                        
                    </div>
                </div>
                  
                  <div class="form-group row" style="text-align: center; margin-top: 50px;">
                     <div class="col-lg-8 ml-auto">
                        <button class="btn btn-success btn-flat btn-addon btn-lg m-b-10 m-l-5 submit" id="ajouter"><i class="ti-plus"></i>Enregistrer</button>
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