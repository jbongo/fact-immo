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
        <form class="form-valide3" action="{{route('facture.demander_facture', Crypt::encrypt($compromis->id) )}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
		<div class="card">
			

			<div class="card-body">
                


                <div class="row"> 
       
                    <div class="col-lg-12">
                            @if (session('ok'))
                   
                            <div class="alert alert-success alert-dismissible fade in">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <a href="#" class="alert-link"><strong> {{ session('ok') }}</strong></a> 
                            </div>
                         @endif       
                        <div class="card alert">
                       <div class="row">
                <h2>Prévisualisation de la facture </h2>

                          @if ($compromis->facture_stylimmo_valide == true)
                          <div class="col-lg-3 col-md-3  col-sm-5 col-xs-8">
                             <a  href="{{route('facture.envoyer_facture_stylimmo', Crypt::encrypt($facture->id))}}"  class="btn btn-danger btn-flat btn-addon  m-b-10 m-l-5 " id="ajouter"><i class="ti-email"></i>Renvoyer au mandataire</a>
                          </div>
                          <div class="col-lg-3 col-md-3 col-sm-6">
                             <a href="{{route('facture.telecharger_pdf_facture_stylimmo', Crypt::encrypt($compromis->id))}}"  class="btn btn-default btn-flat btn-addon  m-b-10 m-l-5 " id="ajouter"><i class="ti-download"></i>Télécharger</a>
                          </div>
                          @else 
                          @if(Auth()->user()->role == "admin" && $compromis->demande_facture == 1)
                          <div class="col-lg-4 col-md-4  col-sm-5 ml-auto">
                              <form action="{{route('facture.valider_facture_stylimmo', Crypt::encrypt($compromis->id))}}" method="get">
                                      <div class="row">
                                          <div class="  col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                              <label for="numero">Numéro facture :</label>
                                          </div>
                                          <div class=" col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                              <label for="numero">Date facture :</label>
                                          </div>
                                      </div>
                                  
                                  <div class="row">
                                      <div class="form-group  col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                          <div class="">  <input class="form-control " style="height:35px; border-color:royalblue" type="number" name="numero" id="numero" value="{{ old('numero') ? old('numero') : $numero}}" required> </div>
                                          @if ($errors->has('numero'))
                                          <br>
                                          <div class="alert alert-warning ">
                                          <strong>{{$errors->first('numero')}}</strong> 
                                          </div>
                                          @endif     
                                      </div>
                                      <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                      <div class="">  <input class="form-control " style="height:35px; border-color:royalblue" type="date"  name="date_facture" id="date_facture"  required> </div>
                                          @if ($errors->has('date_facture'))
                                          <br>
                                          <div class="alert alert-warning ">
                                              <strong>{{$errors->first('date_facture')}}</strong> 
                                          </div>
                                          @endif     
                                      </div>
                                  </div>
                                  <div class="form-group  ">
                                      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                          <button  class="btn btn-default btn-flat btn-addon "  id="ajouter"><i class="ti-check"></i>Valider la facture</button>
                                      </div>
                                  </div>
                              </form>
                              
                          </div>
                          @endif
                          @endif
              
                       </div>
                             <hr>
              
              <table style="width: 50%">
                  <tbody>
                      <tr>           
                          <td style="width: 382px;"><img src="https://www.stylimmo.com/images/logo.jpg" alt="" width="219" height="114" /></td>
                          <td style="width: 380px;">
                              @if ($compromis->charge == "Vendeur")
                                 
                                      <p>{{$compromis->civilite_vendeur}} {{$compromis->nom_vendeur}} </p>
                                 
                                      <p>{{$compromis->adresse1_vendeur}}</p>
                                      <p>{{$compromis->adresse2_vendeur}}</p> 
                                      <p>{{$compromis->code_postal_vendeur}}, {{$compromis->ville_vendeur}}</p>
                              @else 
              
                                 
                                  <p>{{$compromis->civilite_acquereur}} {{$compromis->nom_acquereur}} </p>                
                                 
                                      <p>{{$compromis->adresse1_acquereur}} </p>
                                      <p>{{$compromis->adresse2_acquereur}} </p>
                                      <p>{{$compromis->code_postal_acquereur}} {{$compromis->ville_acquereur}}</p>
                              @endif
                             
                          </td>
                      </tr>
                  </tbody>
              </table>
              <br>
              {{-- <table style="height: 91px; width: 20%">
                  <tbody>
                      <tr>
                          <td style="width: 216px;">Bagnols sur C&egrave;ze, le</td>
                          <td style="width: 194px;">{{Carbon\Carbon::now()->format('d/m/Y')}}</td> 
                      </tr>
                  </tbody>
              </table> --}}
              <table style="height: 53px;" width="50%">
                  <tbody>
                      <tr>
                          <td style="width: 343px;"><span style="color: #ff0000;">Merci d'indiquer le num&eacute;ro de facture en r&eacute;f&eacute;rence du virement.</span></td>
                          <td style="width: 344px;"><span style="text-decoration: underline; font-size:20px"><strong>FACTURE N&deg; @if(Auth()->user()->role == "admin") @if ($compromis->facture_stylimmo_valide == true)  {{$facture->numero}} @else {{$numero}}</strong></span>@endif @else xxxx @endif</td>
                      </tr>
                  </tbody>
              </table>
              <table style="height: 59px; width: 311px;">
                  <tbody>
                      <tr>
                          <td style="width: 158px;"><span style="text-decoration: underline;"><strong>TRANSACTION</strong></span></td>
                      <td style="width: 143px;"><span style="text-decoration: underline;"><strong> {{strtoupper($compromis->type_affaire)}}</strong></span></td>
                      </tr>
                  </tbody>
              </table>
              @if($compromis->type_affaire == "Vente")
              <table style="height: 26px; width: 50%;">
                  <tbody>
                      <tr>
                          <td style="width: 423px;">En l'&eacute;tude de Scp&nbsp; {{$compromis->scp_notaire}}</td>
                          <td style="width: 260px;">  Pr&eacute;vue pour le : {{ Carbon\Carbon::parse($compromis->date_vente)->format('d/m/Y')}} </td>
                      </tr>
                  </tbody>
              </table>
              @endif
              @if($compromis->type_affaire == "Location")
              <table style="height: 26px; width: 50%;">
                  <tbody>
                      <tr>
                          <td style="width: 423px;">&nbsp; </td>
                          <td style="width: 260px;"> date entrée : {{ Carbon\Carbon::parse($compromis->user->date_entree)->format('d/m/Y')}}   </td>
                      </tr>
                  </tbody>
              </table>
              @endif
              <table style="height: 37px; width: 50%;">
                  <tbody>
                      <tr>
                          <td style="width: 423px;"><span style="text-decoration: underline;"><strong>R&eacute;f.</strong></span><strong>:&nbsp;</strong>&nbsp; Mandat N&deg;&nbsp; {{$compromis->numero_mandat}}&nbsp; du : {{ Carbon\Carbon::parse($compromis->date_mandat)->format('d/m/Y')}}</td>
                          <td style="width: 260px;">Affaire suivie par : {{$mandataire->nom}} {{$mandataire->prenom}}</td>
                      </tr>
                  </tbody>
              </table>
              <br>
              <table style="height: 66px; width: 50%">
                  <tbody>
                      <tr>
                          <td style="width: 48px;">&nbsp;</td>
                          <td style="width: 428px;"><span style="text-decoration: underline;">@if($compromis->type_affaire == "Vente") Vendeur(s) @else Propriétaire(s)@endif: </span>&nbsp; {{$compromis->civilite_vendeur}} {{$compromis->nom_vendeur}} </td>
                          <td style="width: 191px;">&nbsp;</td>
                      </tr>
                      <tr>
                          <td style="width: 48px;">&nbsp;</td>
                          <td style="width: 228px;"><span style="text-decoration: underline;">@if($compromis->type_affaire == "Vente") Acquéreur(s) @else Locataire(s)@endif:</span>&nbsp; {{$compromis->civilite_acquereur}} {{$compromis->nom_acquereur}} {{$compromis->prenom_acquereur}} </td>
                          <td style="width: 191px;">&nbsp;</td>
                      </tr>
                  </tbody>
              </table>
              
              <table style="height: 63px; ">
                  <tbody>
                      <tr >
                          <td style="width: 48px;">&nbsp;</td>
                          <td style="width: 700px; "><span style="text-decoration: underline;"><strong>Description et adresse du bien :</strong></span></td>
                          <td style="width: 391px;"></td>
              
                      </tr>
                      <tr style="">
                          <td style="width: 48px;">&nbsp;</td>
                          <td style="width: 700px; ">{{ substr($compromis->description_bien, 0,150) }}</td>
                          <td style="width: 391px;"></td>
                      </tr>
                  </tbody>
              </table>
              <br>
              <table style="height: 47px; width: 672px;">
                  <tbody>
                      <tr>
                          <td style="width: 400px;">&nbsp;</td>
                          <td style="width: 153px;">TOTAL H.T :</td>
                          <td style="width: 231px;">{{number_format($compromis->frais_agence/App\Tva::coefficient_tva() ,2,',',' ')}} &euro;</td>
                      </tr>
                      <tr>
                          <td style="width: 400px;">&nbsp;</td>
                          <td style="width: 153px;">T.V.A 20% :</td>
                          <td style="width: 231px;">{{number_format(($compromis->frais_agence/App\Tva::coefficient_tva()) *App\Tva::tva(),2,',',' ')}} &euro;</td>
                      </tr>
                      <tr>
                          <td style="width: 400px;">&nbsp;</td>
                          <td style="width: 153px;">TOTAL T.T.C :</td>
                          <td style="width: 231px;">{{number_format($compromis->frais_agence,2,',',' ')}} &euro;</td>
                      </tr>
                  </tbody>
              </table>
              <br>
              <br>
              <table style="height: 42px; width: 50%;">
                  <tbody>
                      <tr style="height: 25px;">
                          <td style="width: 349px; height: 25px;">Valeur en votre aimable r&egrave;glement de :</td>
                          <td style="width: 117px; height: 25px;">{{number_format($compromis->frais_agence,2,',',' ')}} &euro; TTC</td>
                          <td style="width: 177px; height: 25px;">@if ($compromis->facture_stylimmo_valide == true)<span style="color: #ff0000;font-size:17px">&nbsp;R&eacute;f &agrave; rappeler: {{$facture->numero}}</span>@endif</td>
                      </tr>
                  </tbody>
              
              </table>
              <br>
              @if($compromis->type_affaire == "Vente")
              <table style="height: 40px; width: 50%;">
                  <tbody>
                      <tr>
                          <td style="width: 196px;">
                              <div>
                                  <div><span style="text-decoration: underline;"><strong>Conditions de paiement:</strong></span></div>
                              </div>
                          </td>
                          <td style="width: 488px;">
                              <div>
                                  <div>Au plus tard le jour de la signature de l'acte authentique, par virement &agrave; la SARL&nbsp;{{App\Parametre::params()->raison_sociale}}, en rappelant au moins sur l'objet du virement les r&eacute;f&eacute;rences de la facture.</div>
                              </div>
                          </td>
                      </tr>
                  </tbody>
              </table>
              @endif
              
              
              
                        </div>
                    </div>
              </div>



<hr><br>




               
                    <div class="row">
                    
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="form-group">
                                <label for="date_vente">Confirmez la date exacte de vente / Date entrée logement<span class="text-danger">*</span></label>
                                <input class="form-control" type="date"  id="date_vente" name="date_vente" @if($compromis->date_vente != null) value="" @endif required >
                            </div>
                        </div>
                    </div>
                    @if($compromis->pdf_compromis == null)
                        <label class="text-warning" >Compromis signé obligatoire</label>
                        <div class="row">
                                    
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="date_signature">Date de signature du compromis / Bail <span class="text-danger">*</span></label>
                                    <input class="form-control" type="date" value="{{old('date_signature')}}" id="date_signature" name="date_signature" required >
                                    {{-- <div id="label_pdf_compromis" class="alert alert-warning" style="color: #1e003c;" role="alert">Le champs Date de signature du compromis devient obligatoire quand vous renseignez le fichier (compromis signé) </div> --}}
                                    @if ($errors->has('date_signature'))
                                        <br>
                                        <div class="alert alert-warning ">
                                            <strong>{{$errors->first('date_signature')}}</strong> 
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="pdf_compromis">Fichier pdf du compromis / contrat de bail <span class="text-danger">*</span></label>
                                    <input class="form-control"  type="file" accept=".pdf" id="pdf_compromis" name="pdf_compromis" required >
                                    
                                    @if ($errors->has('pdf_compromis'))
                                        <br>
                                        <div class="alert alert-warning ">
                                            <strong>{{$errors->first('pdf_compromis')}}</strong> 
                                        </div>
                                    @endif

                                </div>
                            </div>

                        </div>

                    @endif
                    <div class="col-lg-10"> 
                        <button id="demander_facture" class="btn btn-danger btn-flat btn-addon btn-sm m-b-10 m-l-5 submit" href="" ><i class="ti-file"></i>Demander Facture stylimmo</button>
                    {{-- <a class="btn btn-primary btn-flat btn-addon btn-sm m-b-10 m-l-5 submit" target="_blank" href="{{route('facture.generer_facture_stylimmo',Crypt::encrypt($compromis->id) )}}" ><i class="ti-file"></i>Prévisualiser Facture stylimmo</a> --}}
                    </div>
                    <hr>
    <br><br><br>
                <div class="panel-body">
                    <fieldset class="col-md-12">
                        <legend>Modifier l'affaire</legend>
                        <div class="panel panel-warning">
                            <div class="panel-body">                      

                                {{-- <div class="col-lg-3 col-md-3 col-sm-3">
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
                                </div> --}}
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