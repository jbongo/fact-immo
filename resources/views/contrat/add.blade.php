@extends('layouts.app')
@section('content')
@section ('page_title')
Ajout du contrat
@endsection
<div class="row">
   <div class="col-lg-12">
        @if (session('ok'))
        <div class="alert alert-success alert-dismissible fade in">
           <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
           <strong> {{ session('ok') }}</strong>
        </div>
        @endif
      <div class="card">
         <div class="col-lg-10">
            
         </div>
         <div class="card-body">
            <div class="form-validation">
               <form class="form-valide3" action="" method="post">
                  {{ csrf_field() }}
                  
                  <div class="form-group row">
                    <label class="col-lg-4 col-form-label" for="forfait">Forfait d'entrée (€)<span class="text-danger">*</span></label>
                    <div class="col-lg-4">
                    <input type="number" class="form-control" min="1" value="225" id="forfait" name="forfait" required>
                    </div>
            </div>

            <div class="form-group row">
                    <label class="col-lg-6 col-form-label" for="bool-starter">Démarrage en tant que Starter ?</label>
                    <input type="checkbox" unchecked data-toggle="toggle" id="bool-starter" name="bool-starter" data-off="Non" data-on="Oui" data-onstyle="success" data-offstyle="danger">
              </div>

              <div class="form-group row">
                    <label class="col-lg-6 col-form-label" for="parrain">Le mandataire a t'il un parrain ?</label>
                    <input type="checkbox" unchecked data-toggle="toggle" id="parrain" name="parrain" data-off="Non" data-on="Oui" data-onstyle="success" data-offstyle="danger">
              </div>

              <div class="form-group row">
                    <label class="col-lg-6 col-form-label" for="refund">Forfait d'entrée remboursable après la premiere vente ?</label>
                    <input type="checkbox" unchecked data-toggle="toggle" id="refund" name="refund" data-off="Non" data-on="Oui" data-onstyle="success" data-offstyle="danger">
              </div>

              <div id ="glob">

                <div class="form-group row">
                    <label class="col-lg-4 col-form-label" for="starter">Choisir un pack Starter</label>
                    <div class="col-lg-8">
                        <select class="selectpicker col-lg-6" id="starter" name="starter" data-live-search="true" data-style="btn-primary btn-rounded" >                               
                            <option  value="xxx" data-tokens="xxx">xxx</option>                             
                        </select>    
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-4 col-form-label" for="starter-price">Choisir un abonnement Starter</label>
                    <div class="col-lg-8">
                        <select class="selectpicker col-lg-6" id="starter-price" name="starter-price" data-live-search="true" data-style="btn-primary btn-rounded" >                               
                            <option  value="ssss" data-tokens="sss">ssss</option>                          
                        </select>    
                    </div>
                </div>
            </div>

                <div class="form-group row">
                    <label class="col-lg-4 col-form-label" for="expert">Choisir un pack Expert</label>
                    <div class="col-lg-8">
                        <select class="selectpicker col-lg-6" id="expert" name="expert" data-live-search="true" data-style="btn-pink btn-rounded" >                               
                                <option  value="aaaa" data-tokens="aaaa">eerrr</option>                              
                        </select>    
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-4 col-form-label" for="expert-price">Choisir un abonnement Expert</label>
                    <div class="col-lg-8">
                        <select class="selectpicker col-lg-6" id="expert-price" name="expert-price" data-live-search="true" data-style="btn-pink btn-rounded" >                               
                            <option  value="ddd" data-tokens="dddd">dedede</option>                          
                        </select>    
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-4 col-form-label" for="parrainage-plan">Choisir un barème de parrainage</label>
                    <div class="col-lg-8">
                        <select class="selectpicker col-lg-6" id="parrainage-plan" name="parrainage-plan" data-live-search="true" data-style="btn-default btn-rounded" >                               
                            <option  value="szszsz" data-tokens="szszsz">szszsz</option>                             
                        </select>    
                    </div>
                </div>


                 <div class="form-group row" id="parrain-id">
                    <label class="col-lg-4 col-form-label" for="parr-id">Choisir le parrain</label>
                    <div class="col-lg-8">
                        <select class="selectpicker col-lg-6" id="parr-id" name="parr-id" data-live-search="true" data-style="btn-warning btn-rounded" >
                                <option  value="szszsz" data-tokens="szszsz">szszsz</option>                              
                        </select>    
                    </div>
                </div>

              <div class="form-group row" id="durex1">
                <label class="col-lg-4 col-form-label" for="refund-duration">Duréee maximum pour réaliser cette vente (mois)<span class="text-danger">*</span></label>
                <div class="col-lg-4">
                <input type="number" class="form-control" min="1" value="7" id="refund-duration" name="refund-duration" required>
                </div>
        </div>

        <div class="form-group row">
            <label class="col-lg-4 col-form-label" for="date-entree">Date d'entrée<span class="text-danger">*</span></label>
            <div class="col-lg-4">
            <input type="date" class="form-control" id="date-entree" name="date-entree" required>
            </div>
    </div>
    
    <div class="form-group row">
        <label class="col-lg-4 col-form-label" for="date-debut">Date de début d'activité<span class="text-danger">*</span></label>
        <div class="col-lg-4">
        <input type="date" class="form-control" id="date-debut" name="date-debut" required>
        </div>
</div>

                  <div class="form-group row" style="text-align: center; margin-top: 50px;">
                     <div class="col-lg-8 ml-auto">
                        <button class="btn btn-danger btn-flat btn-addon btn-lg m-b-10 m-l-5 submit"><i class="ti-file"></i>Générer le contrat</button>
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
$(document).ready(function() {
    $('#parrain').is(':unchecked') ? $('#parrain-id').hide() : $('#parrain-id').show();
    $('#parrain').change(function(e){
        e.preventDefault();
        $('#parrain').is(':unchecked') ? $('#parrain-id').hide() : $('#parrain-id').show();
    });

    $('#refund').is(':unchecked') ? $('#durex1').hide() : $('#durex1').show();
    $('#refund').change(function(e){
        e.preventDefault();
        $('#refund').is(':unchecked') ? $('#durex1').hide() : $('#durex1').show();
    });

    $('#bool-starter').is(':unchecked') ? $('#glob').hide() : $('#glob').show();
    $('#bool-starter').change(function(e){
        e.preventDefault();
        $('#bool-starter').is(':unchecked') ? $('#glob').hide() : $('#glob').show();
    });
});
</script>
@endsection