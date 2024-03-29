@extends('layouts.app')
@section('content')
@section ('page_title')
Modification de l'article {{$article->libelle}}
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
            <a href="{{route('article.index', Crypt::encrypt($article->fournisseur->id))}}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5"><i class="ti-angle-double-left"></i>@lang('Liste des articles')</a>
         </div>
         <div class="card-body">
            <div class="form-validation">
               <form class="form-valide form-horizontal" action="{{ route('article.update', Crypt::encrypt($article->id)) }}" method="post">
                  {{ csrf_field() }}

                <div class="row">
                    <hr>
                    <hr>
                    <hr>
                    <div class="col-lg-6 col-md-6 col-sm-6">

                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="libelle">Libellé <span class="text-danger">*</span></label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="text" class="form-control  {{$errors->has('libelle') ? 'is-invalid' : ''}}"   value="{{$article->libelle}}" id="libelle" name="libelle" required>
                               @if ($errors->has('libelle'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('libelle')}}</strong> 
                               </div>
                               @endif
                            </div>
                         </div>

                
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="nom">Description </label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                            <textarea  class="form-control" name="description" id="description" cols="30" rows="4">{{$article->description}}</textarea>
                               @if ($errors->has('description'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('description')}}</strong> 
                               </div>
                               @endif
                            </div>
                         </div>
                       
                         <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="quantite">Quantité <span class="text-danger">*</span></label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="number" step="0.01" class="form-control {{$errors->has('quantite') ? 'is-invalid' : ''}}" value="{{$article->quantite}}" id="quantite" name="quantite" required>
                               @if ($errors->has('quantite'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('quantite')}}</strong> 
                               </div>
                               @endif
                            </div>
                         </div>
       
                         <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="prix_achat">Prix d'achat <span class="text-danger">*</span></label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="number" step="0.01" class="form-control {{$errors->has('prix_achat') ? 'is-invalid' : ''}}" value="{{$article->prix_achat}}" id="prix_achat" name="prix_achat" required>
                               @if ($errors->has('prix_achat'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('prix_achat')}}</strong> 
                               </div>
                               @endif
                            </div>
                         </div>
       
                     

                       

                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">

                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="coefficient">Coéfficient <span class="text-danger">*</span></label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="number" step="0.01" class="form-control  {{$errors->has('coefficient') ? 'is-invalid' : ''}}" min="1" max="10"  value="{{$article->coefficient}}" id="coefficient" name="coefficient" required>
                               @if ($errors->has('coefficient'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('coefficient')}}</strong> 
                               </div>
                               @endif
                            </div>
                         </div>

                          <div class="form-group row">
                               <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="login">Date d'achat <span class="text-danger">*</span></label>
                               <div class="col-lg-8 col-md-8 col-sm-8">
                                  <input type="date" class="form-control {{ $errors->has('date_achat') ? ' is-invalid' : '' }}" value="{{$article->date_achat->format('Y-m-d')}}" id="date_achat" name="date_achat" required placeholder=""  >
                                  @if ($errors->has('date_achat'))
                                     <br>
                                     <div class="alert alert-warning ">
                                        <strong>{{$errors->first('date_achat')}}</strong> 
                                     </div>
                                  @endif     
                               </div>
                         </div>
                         
                         <div class="form-group row">
                           <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="login">Date d'expiration </label>
                           <div class="col-lg-8 col-md-8 col-sm-8">
                              <input type="date" class="form-control {{ $errors->has('date_expiration') ? ' is-invalid' : '' }}" @if($article->date_expiration != null) value="{{$article->date_expiration->format('Y-m-d')}}" @endif id="date_expiration" name="date_expiration"  placeholder=""  >
                              @if ($errors->has('date_expiration'))
                                 <br>
                                 <div class="alert alert-warning ">
                                    <strong>{{$errors->first('date_expiration')}}</strong> 
                                 </div>
                              @endif     
                           </div>
                        </div>
                        
                        
                    </div>
                </div>
                <input type="hidden"  name="fournisseur_id" value="{{$article->fournisseur_id}}">
     

                  <div class="form-group row" style="text-align: center; margin-top: 50px;">
                     <div class="col-lg-8 ml-auto">
                        <button class="btn btn-success btn-flat btn-addon btn-lg m-b-10 m-l-5 submit" id="modifier"><i class="ti-plus"></i>Modifier</button>
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