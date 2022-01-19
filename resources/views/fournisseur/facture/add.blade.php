@extends('layouts.app')
@section('content')
@section ('page_title')
Création de facture fournisseur  @if($fournisseur != null): {{$fournisseur->nom}} @endif
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
            @if($fournisseur != null)
                <a href="{{route('fournisseur.show', Crypt::encrypt($fournisseur->id))}}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5"><i class="ti-angle-double-left"></i>Retour</a>
            @else 
                <a href="{{route('fournisseur.index')}}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5"><i class="ti-angle-double-left"></i>Retour</a>
            @endif
         </div>
         <div class="card-body">
            <div class="form-validation">
               <form class="form-valide form-horizontal" enctype="multipart/form-data" action="{{ route('fournisseur.facture.store') }}" method="post">
                  {{ csrf_field() }}

                <div class="row">
                    <hr>
                    <hr>
                    <hr>
                    <div class="col-lg-6 col-md-6 col-sm-6">

                        <div class="form-group row">
                           <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="numero">Numéro facture <span class="text-danger">*</span></label>
                           <div class="col-lg-8 col-md-8 col-sm-8">
                              <input type="text" class="form-control {{$errors->has('numero') ? 'is-invalid' : ''}}" value="{{old('numero')}}" id="numero" name="numero" placeholder="" required>
                              @if ($errors->has('numero'))
                              <br>
                              <div class="alert alert-warning ">
                                 <strong>{{$errors->first('numero')}}</strong> 
                              </div>
                              @endif
                           </div>
                        </div>                       

                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="form-group row">
                           <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="date_facture">Date de la facture <span class="text-danger">*</span> </label>
                           <div class="col-lg-8 col-md-8 col-sm-8">
                              <input type="date" class="form-control {{ $errors->has('date_facture') ? ' is-invalid' : '' }}" value="{{old('date_facture')}}" max="{{date('Y-m-d')}}" id="date_facture" name="date_facture"  required >
                              @if ($errors->has('date_facture'))
                              <br>
                              <div class="alert alert-warning ">
                                 <strong>{{$errors->first('date_facture')}}</strong> 
                              </div>
                              @endif   
                           </div>
                        </div>
                    </div>

                </div>
                  
       

                     <hr>
                     <br>

                     <div class="row">

                        <div class="col-lg-6 col-md-6 col-sm-6">                        
                            <div id="div_fournisseur">
                                <div class="form-group row" >
                                    <label class="col-lg-4 col-md-4 col-sm-4  control-label" for="fournisseur_id">Choisir le fournisseur</label>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <select class="selectpicker col-lg-6" id="fournisseur_id" name="fournisseur_id" data-live-search="true" data-style="btn-default btn-rounded">
                                            @if($fournisseur != null) <option value="{{ $fournisseur->id }}" data-tokens="{{ $fournisseur->nom }}">{{ $fournisseur->nom }} </option> @endif
                                        
                                            @foreach ($fournisseurs as $fourn )
                                            <option value="{{ $fourn->id }}" data-tokens="{{ $fourn->nom }}">{{ $fourn->nom }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                             </div>
                        </div>
                        
                        <div class="col-lg-6 col-md-6 col-sm-6">                            
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-sm-4  control-label" value="" for="facture_pdf">Ajouter la facture (pdf)<span class="text-danger">*</span></label>
                                <div class="col-lg-8 col-md-8 col-sm-8 ">
     
                                   <input type="file"  accept=".pdf" class="form-control"  id="facture_pdf" name="facture_pdf" value="{{old('facture_pdf')}} " required/>
     
                                   @if ($errors->has('facture_pdf'))
                                   <br>
                                   <div class="alert alert-warning ">
                                      <strong>{{$errors->first('facture_pdf')}}</strong> 
                                   </div>
                                   @endif 
                                </div>
                             </div>
                        </div>
                        
                        
                        

                      
                     </div>

   <br><br>
                     <div class="row">
                        
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-sm-4  control-label" value="" for="montant_ht">Montant HT produit(s) <span class="text-danger">*</span></label>
                                <div class="col-lg-8 col-md-8 col-sm-8 ">
     
                                   <input type="number" class="form-control" step="any"  id="montant_ht" name="montant_ht" value="{{old('montant_ht')}} " required/>
     
                                   @if ($errors->has('montant_ht'))
                                   <br>
                                   <div class="alert alert-warning ">
                                      <strong>{{$errors->first('montant_ht')}}</strong> 
                                   </div>
                                   @endif 
                                </div>
                             </div>
                        </div>
                        
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-sm-4  control-label" value="" for="montant_ttc">Montant TTC produit(s) <span class="text-danger">*</span></label>
                                <div class="col-lg-8 col-md-8 col-sm-8 ">
     
                                   <input type="number" class="form-control" step="any"  id="montant_ttc" name="montant_ttc" value="{{old('montant_ttc')}} " required/>
     
                                   @if ($errors->has('montant_ttc'))
                                   <br>
                                   <div class="alert alert-warning ">
                                      <strong>{{$errors->first('montant_ttc')}}</strong> 
                                   </div>
                                   @endif 
                                </div>
                             </div>
                        </div>
                        
                  </div>


                     <hr>

                        
       
                     <div class="row">

                           <div class="form-group row">
                              <label class="col-lg-3 col-md-3 col-sm-4  control-label" value="" for="description_produit">Description produit(s)</label>
                              <div class="col-lg-8 col-md-8 col-sm-8 ">

                              <textarea name="description_produit" id="description_produit" cols="30" rows="10" >{{old('description_produit')}}</textarea>
                                 @if ($errors->has('description_produit'))
                                 <br>
                                 <div class="alert alert-warning ">
                                    <strong>{{$errors->first('description_produit')}}</strong> 
                                 </div>
                                 @endif 
                              </div>
                           </div>
                     </div>
                     
       <hr>
                 
    
                     
       
                  
                  <div class="form-group row" style="text-align: center; margin-top: 50px;">
                     <div class="col-lg-8 ml-auto">
                        <button class="btn btn-success btn-flat btn-addon btn-lg m-b-10 m-l-5 submit" id="ajouter"><i class="ti-plus"></i>Créer la facture</button>
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

<script>
  
</script>







<script src="https://cdn.tiny.cloud/1/t0hcdz1jd4wxffu3295e02d08y41e807gaxas0gefdz7kcb4/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<script src='https://cdn.tiny.cloud/1/t0hcdz1jd4wxffu3295e02d08y41e807gaxas0gefdz7kcb4/tinymce/5/tinymce.min.js' referrerpolicy="origin"></script>
<script>
  tinymce.init({
    selector: 'textarea',
    plugins: [
    'advlist autolink lists link image charmap print preview anchor',
    'searchreplace visualblocks fullscreen',
    'insertdatetime media table paste help wordcount'
  ],
  toolbar: 'undo redo | formatselect | ' +
  'bold italic backcolor | alignleft aligncenter ' +
  'alignright alignjustify | bullist numlist outdent indent | ' +
  'removeformat | help',
  });
</script>

@endsection