@extends('layouts.app')
@section('content')
@section ('page_title')
Demande de facture  | {{ substr($compromis->description_bien,0,150) }}... 
@endsection
<style>

.form-control{
    color: slategray;
}
</style>
<div class="row">
	<div class="col-lg-12">
		@if (session('ok'))
		<div class="alert alert-success alert-dismissible fade in">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong> {{ session('ok') }}</strong>
		</div>
        @endif
        <form class="form-valide3" action="{{route('facture.demander_facture', Crypt::encrypt($compromis->id) )}}" method="post">
                {{ csrf_field() }}
		<div class="card">
			

			<div class="card-body">
                
               
                    <div class="row">
                    
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="form-group">
                                <label for="date_vente">Confirmez la date exacte de vente <span class="text-danger">*</span></label>
                                <input class="form-control" type="date"  id="date_vente" name="date_vente" @if($compromis->date_vente != null) value="{{$compromis->date_vente->format('Y-m-d')}}" @endif required >
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-10"> 
                        <button id="demander_facture" class="btn btn-danger btn-flat btn-addon btn-sm m-b-10 m-l-5 submit" href="" ><i class="ti-file"></i>Demander Facture stylimmo</button>
                    <a class="btn btn-primary btn-flat btn-addon btn-sm m-b-10 m-l-5 submit" target="_blank" href="{{route('facture.generer_facture_stylimmo',Crypt::encrypt($compromis->id) )}}" ><i class="ti-file"></i>Prévisualiser Facture stylimmo</a>
                    </div>
                    <hr>
    <br><br>
                <div class="panel-body">
                    <fieldset class="col-md-12">
                        <legend>Vérifiez les informations ci-dessous</legend>
                        <div class="panel panel-warning">
                            <div class="panel-body">                      

                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <div class="form-group row" id="parrain-id">
                                        <label class="col-lg-8 col-form-label" for="parr-id">Net Vendeur<span class="text-danger">*</span></label>
                                        <div class="col-lg-8">
                                            <input type="number" class="form-control verif" id="net_vendeur" name="net_vendeur" value="{{ $compromis->net_vendeur}}" required>                                                    
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <div class="form-group">
                                        <label for="frais_agence">Frais d'agence<span class="text-danger">*</span></label>
                                        <input class="form-control verif" min="0" type="number" value="{{ $compromis->frais_agence}}" id="frais_agence" name="frais_agence" required >
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <div class="form-group row" id="parrain-id">
                                        <label class="col-lg-8 col-form-label" for="charge">Charge <span class="text-danger">*</span></label>
                                        <div class="col-lg-8">
                                            <select class="col-lg-6 form-control verif" id="charge" name="charge"  required  >
                                                <option value="{{ $compromis->charge}}">{{ $compromis->charge}}</option>
                                                <option  value="Vendeur" >Vendeur</option>
                                                <option  value="Acquereur" >Acquereur</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="form-validation">
                                    <div class="form-group row" style="text-align: center; margin-top: 50px;">
                                        <div class="col-lg-8 ml-auto">
                                            <button class="btn btn-success btn-flat btn-addon btn-lg m-b-10 m-l-5 sauvegarder"><i class="ti-save"></i>Sauvegarder</button>
                                        </div>
                                    </div>
                                </div> --}}

                                    </div>
                                    <a href="{{route('compromis.show', Crypt::encrypt($compromis->id))}}"  target="_blank" class="btn btn-default btn-flat btn-addon btn-sm m-b-10 m-l-5   " id="modifier_compromis"><i class="ti-pencil-alt"></i>Modifier</a>

                            </div>
                        </div>
                    </fieldset>
                </div>

                <br>

                    
                </form>
		</div>
	</div>
</div>
</div>
@stop
@section('js-content')

<script>
$(' .verif').attr('readonly',true);
$('textarea').attr('readonly',true);
$('select').attr('readonly',true);
$('.sauvegarder').hide();

/* $('#modifier_compromis').click(function(){
    $('input').attr('readonly',false);
    $('textarea').attr('readonly',false);
    $('select').attr('readonly',false);
    $('#modifier_compromis').slideUp(0);
    $('.sauvegarder').show();

});
$('.sauvegarder').click(function(e){
    e.preventDefault();
    if($('#charge').val() != "" &&  $('#net_vendeur').val() != "" && $('#frais_agence').val() != "" ){
        $('.verif').attr('readonly',true);

        $('.sauvegarder').hide();
        $('#modifier_compromis').slideDown(0);
    }


});
 */

// Demande de la facture stylimmo

$('#demander_facture').click(function(e){

    //e.preventDefault();
    
});

</script>





@endsection