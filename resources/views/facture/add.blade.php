@extends('layouts.app')
@section('content')
@section ('page_title')
Création de facture
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
            <a href="{{route('facture.index')}}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5"><i class="ti-angle-double-left"></i>@lang('Liste des Factures')</a>
         </div>
         <div class="card-body">
            <div class="form-validation">
               <form class="form-valide form-horizontal" action="{{ route('facture.store_libre') }}" method="post">
                  {{ csrf_field() }}

                <div class="row">
                    <hr>
                    <hr>
                    <hr>
                    <div class="col-lg-6 col-md-6 col-sm-6">

                        <div class="form-group row">
                           <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="numero">Numéro facture <span class="text-danger">*</span></label>
                           <div class="col-lg-8 col-md-8 col-sm-8">
                              <input type="number" class="form-control {{$errors->has('numero') ? 'is-invalid' : ''}}" value="{{old('numero') ? old('numero') : $numero }}" id="numero" name="numero" placeholder="" required>
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
                              <input type="date" class="form-control {{ $errors->has('date_facture') ? ' is-invalid' : '' }}" value="{{old('date_facture')}}" id="date_facture" name="date_facture" max="{{date('Y-m-d')}}" required >
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

                     <div class="row">

                       <div>
                           <div class="form-group row" >
                              <label class="col-lg-3 col-md-3 col-sm-4  control-label" for="type">Type de la facture <span class="text-danger">*</span></label>
                              <div class="col-lg-3 col-md-3 col-sm-4">
                                 <select class=" col-lg-6 form-control" id="type" name="type" data-live-search="true" data-style="btn-default btn-rounded" required>
                                   
                                    <option value="" data-tokens=""></option>
                                    <option value="pack_pub" data-tokens="pub">Pub</option>
                                    <option value="communication" data-tokens="communication">Communication</option>
                                    <option value="forfait_entree" data-tokens="forfait_entree">Forfait d'entrée</option>
                                    <option value="cci" data-tokens="cci">Cci</option>
                                    <option value="autre" data-tokens="autre">Autre</option>
                                    
                                 </select>
                              </div>
                           </div>

                       </div>
                     </div>

                     <hr>
                    <div class="row">

                        <div class="form-group row">
                           <div class="col-lg-4 col-md-4 col-sm-4 col-lg-offset-4 col-md-offset-4 col-sm-offset-4">
                              <label class=" control-label" for="destinataire_est_mandataire">Le Destinataire est un mandataire <span class="text-danger">*</span></label>
                              <input type="checkbox" checked data-toggle="toggle" id="destinataire_est_mandataire" name="destinataire_est_mandataire" data-off="Non" data-on="Oui" data-onstyle="success" data-offstyle="danger">
{{-- 
                              <select class="js-select2 form-control {{$errors->has('statut') ? 'is-invalid' : ''}}" id="statut" name="statut" style="width: 100%;" data-placeholder="Choose one.." required>
                                 <option value="true">OUI</option>
                                 <option value="false">NON</option>
                  
                              </select> --}}
                              @if ($errors->has('destinataire_est_mandataire'))
                              <br>
                              <div class="alert alert-warning ">
                                 <strong>{{$errors->first('destinataire_est_mandataire')}}</strong> 
                              </div>
                              @endif
                           </div>
                        </div>


                    </div>

<hr>

                     <div class="row">


                        <div id="div_mandataire">
                           <div class="form-group row" >
                               <label class="col-lg-3 col-md-3 col-sm-4  control-label" for="mandataire_id">Choisir le mandataire</label>
                               <div class="col-lg-8 col-md-8 col-sm-8">
                                   <select class="selectpicker col-lg-6" id="mandataire_id" name="mandataire_id" data-live-search="true" data-style="btn-default btn-rounded">
                                       @foreach ($mandataires as $mandataire )
                                       <option value="{{ $mandataire->id }}" data-tokens="{{ $mandataire->nom }} {{ $mandataire->prenom }}">{{ $mandataire->nom }} {{ $mandataire->prenom }}</option>
                                       @endforeach
                                   </select>
                               </div>
                           </div>
                           
                       </div>

                       <div id="div_destinataire">
                           <div class="form-group row">
                              <label class="col-lg-3 col-md-3 col-sm-4  control-label" value="" for="destinataire">Destinataire(s) et adresse(s) </label><br>
                              <div class="col-lg-8 col-md-8 col-sm-8 ">
  
                                <textarea name="destinataire" id="destinataire" cols="30" rows="10"  >{{old('destinataire')}}</textarea>
                                 @if ($errors->has('destinataire'))
                                 <br>
                                 <div class="alert alert-warning ">
                                    <strong>{{$errors->first('destinataire')}}</strong> 
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
                    
                     <div class="row">

                        <div class="form-group row">
                           <label class="col-lg-3 col-md-3 col-sm-4  control-label" value="" for="montant_ht">Montant HT produit(s) <span class="text-danger">*</span></label>
                           <div class="col-lg-3 col-md-3 col-sm-3 ">

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
   $('#div_destinataire').hide();



   $('#destinataire_est_mandataire').change(function(){

      if($('#destinataire_est_mandataire').prop('checked')){
         $('#div_destinataire').hide();
         $('#div_mandataire').show();

      }else{
         $('#div_destinataire').show();
         $('#div_mandataire').hide();
      }
   })


   //  Ajout de la facture

   // $('#ajouter').click(function(e){

   //    e.preventDefault();

   //    $('#ajouter').submit()
   //    console.log("ee");
   // })
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