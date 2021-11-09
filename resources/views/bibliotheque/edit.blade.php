@extends('layouts.app')
@section('content')
@section ('page_title')
Modification d'un document dans la Bibliothèque STYL'IMMO
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
            <a href="{{route('bibliotheque.index')}}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5"><i class="ti-angle-double-left"></i>@lang('Bibliothèque')</a>
         </div>
         <div class="card-body">
            <div class="form-validation">
               <form class="form-valide form-horizontal" action="{{ route('bibliotheque.update', $document->id) }}" enctype="multipart/form-data" method="post">
                  {{ csrf_field() }}

                <div class="row">
                    <hr>
                    <hr>
                    <hr>
                    <div class="col-lg-6 col-md-6 col-sm-6">

                         <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="nom">Nom du document<span class="text-danger">*</span></label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="text" class="form-control {{$errors->has('nom') ? 'is-invalid' : ''}}" value="{{old('nom') ? old('nom') : $document->nom}}" id="nom" name="nom" placeholder="Nom.." required>
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
                             <textarea name="description" id="description" class="form-control" cols="30" rows="5"> {{old('description') ? old('description') : $document->description}}</textarea>
                              @if ($errors->has('description'))
                              <br>
                              <div class="alert alert-warning ">
                                 <strong>{{$errors->first('description')}}</strong> 
                              </div>
                              @endif
                           </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6">                
                        <div class="row form-group ">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="fichier">Modifier le fichier <span class="text-danger">*</span></label> 
                            
                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <input type="file" class="form-control" value="" id="fichier" name="fichier" accept=".jpeg,.jpg,.png,.pdf,.doc,.docx,.xls"  > @if($document->reference != null)
                                <a href="{{route('bibliotheque.telecharger', $document->id)}}" data-toggle="tooltip" title="Télécharger {{$document->nom}}"  class="btn btn-danger btn-flat btn-addon "><i class="ti-download"></i>Télécharger </a>    
                               @endif
                                @if ($errors->has('fichier'))
                                  <br>
                                  <div class="alert alert-warning ">
                                     <strong>{{$errors->first('fichier')}}</strong> 
                                  </div>
                               @endif  
                            </div>
                      </div>
                    

                        <div class="row form-group ">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="date_expiration">Date d'expiration</label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <input type="date" class="form-control" id="date_expiration" value="{{old('date_expiration') ? old('date_expiration') : ($document->date_expiration ? $document->date_expiration->format('Y-m-d') : $document->date_expiration ) }}"  name="date_expiration" >
                                @if ($errors->has("date_expiration"))
                                  <br>
                                  <div class="alert alert-warning ">
                                     <strong>{{$errors->first("date_expiration")}}</strong> 
                                  </div>
                               @endif  
                            </div>
                      </div>
                      
                </div>
                  
                  <div class="form-group row" style="text-align: center; margin-top: 50px;">
                     <div class="col-lg-8 ml-auto">
                        <button class="btn btn-success btn-flat btn-addon btn-lg m-b-10 m-l-5 submit" id="ajouter"><i class="ti-save"></i>Modifier</button>
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