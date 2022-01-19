@extends('layouts.app')
@section('content')
@section ('page_title')
Ajout d'un contrat pour {{$fournisseur->nom}}
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
            <a href="{{route('fournisseur.show', Crypt::encrypt($fournisseur->id))}}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5"><i class="ti-angle-double-left"></i>@lang('Retour')</a>
         </div>
         <div class="card-body">
            <div class="form-validation">
               <form class="form-valide form-horizontal" action="{{ route('fournisseur.contrat.store') }}" method="post">
                  {{ csrf_field() }}

                <div class="row">
                    <hr>
                    <hr>
                    <hr>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                     
                      
                     
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="libelle">Libellé (nom) du contrat <span class="text-danger">*</span></label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="text" class="form-control  {{$errors->has('libelle') ? 'is-invalid' : ''}}"   value="{{old('libelle')}}" id="libelle" name="libelle" required>
                               @if ($errors->has('libelle'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('libelle')}}</strong> 
                               </div>
                               @endif
                            </div>
                         </div>
                         
                         <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="numero_contrat">Numéro contrat <span class="text-danger">*</span></label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="text" class="form-control  {{$errors->has('numero_contrat') ? 'is-invalid' : ''}}"   value="{{old('numero_contrat')}}" id="numero_contrat" name="numero_contrat" required>
                               @if ($errors->has('numero_contrat'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('numero_contrat')}}</strong> 
                               </div>
                               @endif
                            </div>
                         </div>
                         
                         <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="numero_client">Numéro client </label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="text" class="form-control  {{$errors->has('numero_client') ? 'is-invalid' : ''}}"   value="{{old('numero_client')}}" id="numero_client" name="numero_client" >
                               @if ($errors->has('numero_client'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('numero_client')}}</strong> 
                               </div>
                               @endif
                            </div>
                         </div>

                       

                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                     
                          <div class="form-group row">
                               <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="date_deb">Date début contrat <span class="text-danger">*</span></label>
                               <div class="col-lg-8 col-md-8 col-sm-8">
                                  <input type="date" class="form-control {{ $errors->has('date_deb') ? ' is-invalid' : '' }}" value="{{old('date_deb')}}" id="date_deb" name="date_deb" required placeholder=""  >
                                  @if ($errors->has('date_deb'))
                                     <br>
                                     <div class="alert alert-warning ">
                                        <strong>{{$errors->first('date_deb')}}</strong> 
                                     </div>
                                  @endif     
                               </div>
                         </div>
                        
                         <div class="form-group row">
                           <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="date_fin">Date fin contrat </label>
                           <div class="col-lg-8 col-md-8 col-sm-8">
                              <input type="date" class="form-control {{ $errors->has('date_fin') ? ' is-invalid' : '' }}" value="{{old('date_fin')}}" id="date_fin" name="date_fin"  placeholder=""  >
                              @if ($errors->has('date_fin'))
                                 <br>
                                 <div class="alert alert-warning ">
                                    <strong>{{$errors->first('date_fin')}}</strong> 
                                 </div>
                              @endif     
                           </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="description">Description (commentaires)</label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                            <textarea  class="form-control" name="description" id="description" cols="30" rows="4"></textarea>
                               @if ($errors->has('description'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('description')}}</strong> 
                               </div>
                               @endif
                            </div>
                         </div>
                        
                    </div>
                </div>
                  
            <input type="hidden"  name="fournisseur_id" value="{{$fournisseur->id}}">

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