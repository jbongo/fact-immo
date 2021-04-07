@extends('layouts.app') 
@section('content') 
@section ('page_title') 
    Ajouter votre facture -- <span class="color-warning">   <span class="color-primary">type :</span> {{$facture->type}} | <span class="color-primary"> montant ht : </span> {{$facture->montant_ht}} |  <span class="color-primary">mandat :</span> {{$facture->compromis->numero_mandat}} </span> 
@endsection
<div class="row">
    <div class="col-lg-12">
        @if (session('ok'))
        <div class="alert alert-danger alert-dismissible fade in">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong> {{ session('ok') }}</strong>
        </div>
        @endif
        <div class="card">
            <div class="col-lg-10">
            </div>
            <div class="card-body">

                <div class="panel-body">
                
<br> <hr>
                    <fieldset class="col-md-12">
                        <legend>Infos factures</legend>
                        <div class="panel panel-warning">
                            <div class="panel-body">
                                <form class="form-valide3" enctype="multipart/form-data"  action="{{ route('facture.store_upload_pdf_honoraire',Crypt::encrypt($facture->id)) }}" method="post">
                                    {{ csrf_field() }}

                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4">

                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="numero_facture">Numéro de la facture<span class="text-danger">*</span></label>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control" value="{{old('numero_facture')}}"  id="numero_facture" name="numero_facture" required>
                                                </div>
                                                 @if ($errors->has('numero_facture'))
                                                    <br>
                                                    <div class="alert alert-warning ">
                                                        <strong>{{$errors->first('numero_facture')}}</strong> 
                                                    </div>
                                                @endif
                                            </div>
                                           
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="date_facture">Date de la facture<span class="text-danger">*</span></label>
                                                <div class="col-lg-6">
                                                    <input type="date" class="form-control" value="{{old('date_facture')}}" id="date_facture" name="date_facture" required>
                                                </div>
                                                 @if ($errors->has('date_facture'))
                                                    <br>
                                                    <div class="alert alert-warning ">
                                                        <strong>{{$errors->first('date_facture')}}</strong> 
                                                    </div>
                                                @endif
                                            </div>
                                            
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">

                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="montant_ht">Montant HT <span class="text-danger">*</span></label>
                                                <div class="col-lg-6">
                                                <input type="number" class="form-control" min="0" step="0.01" value="{{old('montant_ht')}}"  id="montant_ht" name="montant_ht" required>
                                                </div>
                                                 @if ($errors->has('montant_ht'))
                                                    <br>
                                                    <div class="alert alert-warning ">
                                                        <strong>{{$errors->first('montant_ht')}}</strong> 
                                                    </div>
                                                @endif
                                            </div>
                                           
                                        </div>
                                       
                                    
                                    </div>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <br>

               
                <br>

                <div class="panel-body">
                    <fieldset class="col-md-12">
                        <legend>Ajout de la facture</legend>
                        <div class="panel panel-warning">
                            <div class="panel-body">

                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                
                                        <div class="form-group row">
                                            <label class="col-lg-6 col-md-6 col-sm-6col-form-label" for="file">Ajouter la facture</label>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <input type="file" accept=".pdf" class="form-control"  id="file"  name="file"  required>
                                            </div>
                                             @if ($errors->has('file'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{$errors->first('file')}}</strong> 
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                              
                                  
                                    
                                </div>

                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>




                
            @if($facture->compromis->partage_reseau == false && $facture->compromis->qui_porte_externe == 3 && $facture->type =="honoraire")
                <br><br>
              <h4>  ************************************************************************** AGENCE EXTERNE **************************************************************************  </h4>
                <div class="card-body">
                
                    <div class="panel-body">
                    
                <br> <hr>
                        <fieldset class="col-md-12">
                            <legend style="color: brown">Ajoutez la facture de l'agence externe avec laquelle vous avez partagé l'affaire</legend>
                            <div class="panel panel-danger">
                                <div class="panel-body">
                                   
                                
                
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="numero_facture_externe">Numéro de la facture<span class="text-danger">*</span></label>
                                                    <div class="col-lg-6">
                                                        <input type="text" class="form-control" value="{{old('numero_facture_externe')}}"  id="numero_facture_externe" name="numero_facture_externe" required>
                                                    </div>
                                                     @if ($errors->has('numero_facture_externe'))
                                                        <br>
                                                        <div class="alert alert-warning ">
                                                            <strong>{{$errors->first('numero_facture_externe')}}</strong> 
                                                        </div>
                                                    @endif
                                                </div>
                                               
                                            </div>
                
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="date_facture_externe">Date de la facture de l'agence<span class="text-danger">*</span></label>
                                                    <div class="col-lg-6">
                                                        <input type="date" class="form-control" value="{{old('date_facture_externe')}}" id="date_facture_externe" name="date_facture_externe" required>
                                                    </div>
                                                     @if ($errors->has('date_facture_externe'))
                                                        <br>
                                                        <div class="alert alert-warning ">
                                                            <strong>{{$errors->first('date_facture_externe')}}</strong> 
                                                        </div>
                                                    @endif
                                                </div>
                                                
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="montant_ht_externe">Montant HT de l'agence <span class="text-danger">*</span></label>
                                                    <div class="col-lg-6">
                                                    <input type="number" class="form-control" min="0" step="0.01" value="{{old('montant_ht_externe')}}"  id="montant_ht_externe" name="montant_ht_externe" required>
                                                    </div>
                                                     @if ($errors->has('montant_ht_externe'))
                                                        <br>
                                                        <div class="alert alert-warning ">
                                                            <strong>{{$errors->first('montant_ht_externe')}}</strong> 
                                                        </div>
                                                    @endif
                                                </div>
                                               
                                            </div>
                                           
                                        
                                        </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                
                    <br>
                
                   
                    <br>
                
                    <div class="panel-body">
                        <fieldset class="col-md-12">
                            {{-- <legend>Ajout de la facture</legend> --}}
                            <div class="panel panel-danger">
                                <div class="panel-body">
                
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                    
                                            <div class="form-group row">
                                                <label class="col-lg-6 col-md-6 col-sm-6col-form-label" for="file_externe">Ajouter la facture de l'agence</label>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <input type="file" accept=".pdf" class="form-control"  id="file_externe"  name="file_externe"  required>
                                                </div>
                                                 @if ($errors->has('file_externe'))
                                                    <br>
                                                    <div class="alert alert-warning ">
                                                        <strong>{{$errors->first('file_externe')}}</strong> 
                                                    </div>
                                                @endif
                                            </div>
                
                                        </div>
                                  
                                      
                                        
                                    </div>
                
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>



        @endif


            <div class="form-group row" style="text-align: center; margin-top: 50px;">
                <div class="col-lg-8 ml-auto">
                    <button class="btn btn-danger btn-flat btn-addon btn-lg m-b-10 m-l-5  " id="terminer"><i class="ti-save"></i>Valider</button>
                </div>
            </div>

            </form>
        </div>
    </div>
</div>
@stop @section('js-content') 



{{-- Envoi des données en ajax pour le stockage --}}
<script>

    // $('.form-valide3').submit(function(e) {
    //     e.preventDefault();
    //     var form = $(".form-valide3");

           
    //         var palierdata = $('#palier_starter input').serialize();

    //     data = {
    //         "numero" : $('#numero').val(),
    //         "date" : $('#date').val(),
    //         "modele" : $('#modele').val(),


    //     }
    //     var facture_id = "{{Crypt::encrypt($facture->id)}}";
    //     // console.log(data);
    //     $.ajaxSetup({
    //         headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    //     })
    //         $.ajax({
    //             type: "GET",
    //             url: "facture/honoraire/generer-pdf/"+facture_id
    //             data: data,
    //             success: function(data) {
    //                 console.log(data);
                    
    //                 swal(
    //                         'Ajouté',
    //                         'La facture a été ajouté avec succés!',
    //                         'success'
    //                     )
    //                     .then(function() {
    //                         // window.location.href = "{{route('mandataire.index')}}";
    //                     })
    //                     setInterval(() => {
    //                         window.location.href = "{{route('mandataire.index')}}";
                            
    //                     }, 5);
    //             },
    //             error: function(data) {
    //                 console.log(data);
                    
    //                 swal(
    //                     'Echec',
    //                     'La facture  n\'a pas été ajouté!',
    //                     'error'
    //                 );
    //             }
    //         });
    // });
</script>
@endsection