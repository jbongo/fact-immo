@extends('layouts.app')
@section('content')
@section ('page_title')
Modifier un pack pub
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
            <a href="{{route('pack_pub.index')}}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5"><i class="ti-angle-double-left"></i>@lang('Liste des packs pub')</a>
         </div>
         <div class="card-body">
            <div class="form-validation">
               <form class="form-valide form-horizontal" action="{{ route('pack_pub.update',Crypt::encrypt($pack->id)) }}" method="post">
                  {{ csrf_field() }}

                <div class="row">
                    <hr>
                    <hr>
                    <hr>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="nom">Nom pack_pub<span class="text-danger">*</span> </label>
                            <div class="col-lg-5 col-md-5 col-sm-5">
                               <input type="text" class="form-control {{ $errors->has('nom') ? ' is-invalid' : '' }}" value="{{old('nom') ? old('nom') : $pack->nom}}" id="nom" name="nom" required >
                               @if ($errors->has('nom'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('nom')}}</strong> 
                               </div>
                               @endif   
                            </div>
                         </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                     <div class="form-group row">
                         <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="qte_annonce">Quantité d'annonces<span class="text-danger">*</span> </label>
                         <div class="col-lg-5 col-md-5 col-sm-5">
                            <input type="number" class="form-control {{ $errors->has('qte_annonce') ? ' is-invalid' : '' }}" value="{{old('qte_annonce') ? old('qte_annonce') : $pack->qte_annonce}}" id="qte_annonce" name="qte_annonce" required >
                            @if ($errors->has('qte_annonce'))
                            <br>
                            <div class="alert alert-warning ">
                               <strong>{{$errors->first('qte_annonce')}}</strong> 
                            </div>
                            @endif   
                         </div>
                      </div>
                     </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                         <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="tarif_ht">Tarif HT <span class="text-danger">*</span></label>
                            <div class="col-lg-5 col-md-5 col-sm-5">
                               <input type="number" min="0" class="form-control {{ $errors->has('tarif_ht') ? ' is-invalid' : '' }}" value="{{old('tarif_ht') ? old('tarif_ht') : $pack->tarif_ht}}" id="tarif_ht" name="tarif_ht" required>
                               @if ($errors->has('tarif_ht'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('tarif_ht')}}</strong> 
                               </div>
                               @endif 
                            </div>
                         </div>
                    </div>
                    
                    <div class="col-lg-6 col-md-6 col-sm-6">
                     <div class="form-group row">
                        <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="type">Type du pack <span class="text-danger">*</span></label>
                        <div class="col-lg-5 col-md-5 col-sm-5">
                           
                           <select name="type" class="form-control" id="type">
                           
                              <option value="{{$pack->type}}">{{$pack->type}}</option>
                              
                              <option value="reseau">réseau</option>
                              <option value="mandataire">mandataire</option>
                              
                           </select>
                           @if ($errors->has('type'))
                           <br>
                           <div class="alert alert-warning ">
                              <strong>{{$errors->first('type')}}</strong> 
                           </div>
                           @endif 
                        </div>
                     </div>
                     
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