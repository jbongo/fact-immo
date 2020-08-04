@extends('layouts.app')
@section('content')
@section ('page_title')
Création de facture d'avoir sur la facture STYL'IMMO  <span class="color-warning">({{ $facture->numero }})</span> 
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
            <a href="{{route('facture.index')}}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5"><i class="ti-angle-double-left"></i>@lang('Liste des factures')</a>
         </div>
         <div class="card-body">
            <div class="form-validation">
               <form class="form-valide form-horizontal" action="{{ route('facture.avoir.store') }}" method="post">
                  {{ csrf_field() }}

                <div class="row">
                    <hr>
                    <hr>
                    <hr>
                    <input type="hidden"  class="form-control " value="{{ $facture->id }}" id="facture_id" name="facture_id" required >

                    <div class="col-lg-offset-2  col-md-offset-2 col-sm-offset-2 col-lg-4 col-md-4 col-sm-4">
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="numero">Numéro de l'avoir<span class="text-danger">*</span> </label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="number"  class="form-control {{ $errors->has('numero') ? ' is-invalid' : '' }}" value="{{$numero}}" id="numero" name="numero" required >
                               @if ($errors->has('numero'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('numero')}}</strong> 
                               </div>
                               @endif   
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-lg-4 col-md-4 col-sm-4">
                         <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="date">date <span class="text-danger">*</span></label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="date" class="form-control {{ $errors->has('date') ? ' is-invalid' : '' }}" value="{{old('date')}}" id="date" name="date" required>
                               @if ($errors->has('date'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('date')}}</strong> 
                               </div>
                               @endif 
                            </div>
                         </div>
                    </div> --}}
                    
                    </div>
                    <div class="row">

                        <div class=" col-lg-8 col-md-8 col-sm-8">
                            <div class="form-group row">
                                <label class="col-lg-5 col-md-5 col-sm-5 control-label" for="motif">Motifs de l'avoir </label>
                                <div class="col-lg-7 col-md-7 col-sm-7">
                                    <textarea  class="form-control {{ $errors->has('motif') ? ' is-invalid' : '' }}" name="motif" id="motif" cols="30" rows="10">
                                       {{old('motif') ? old('motif') : ''}}
                                    </textarea>
                                    @if ($errors->has('motif'))
                                    <br>
                                    <div class="alert alert-warning ">
                                        <strong>{{$errors->first('motif')}}</strong> 
                                    </div>
                                    @endif 
                                </div>
                            </div>
                        </div>
                    </div>
               
                  
                  <div class="form-group row" style="text-align: center; margin-top: 50px;">
                     <div class="col-lg-8 ml-auto">
                        <button class="btn btn-success btn-flat btn-addon btn-lg m-b-10 m-l-5 submit" id="ajouter"><i class="ti-plus"></i>Créer</button>
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