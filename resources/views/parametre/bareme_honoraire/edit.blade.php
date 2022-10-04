@extends('layouts.app')
@section('content')
@section ('page_title')
Modifier le barème d'honoraire
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
            <a href="{{route('bareme_honoraire.index')}}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5"><i class="ti-angle-double-left"></i>@lang('Liste des barèmes')</a>
         </div>
         <div class="card-body">
            <div class="form-validation">
               <form class="form-valide form-horizontal" action="{{ route('bareme_honoraire.update', $bareme->id) }}" method="post">
                      {{ csrf_field() }}
    
    
                    <div class="row">
                        
                        <div class="col-lg-6 col-md-6 col-sm-6">
    
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="est_forfait">Mode de calcul <span class="text-danger">*</span></label>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                   <select class="js-select2 form-control {{$errors->has('est_forfait') ? 'is-invalid' : ''}}" id="est_forfait" name="est_forfait" style="width: 100%;" data-placeholder="Choose one.." required>
                            
                                      <option value="{{$bareme->est_forfait}}">@if($bareme->est_forfait == true) Forfait @else Pourcentage @endif</option>
                                      <option value="false">Pourcentage</option>
                                      <option value="true">Forfait</option>
                                      
                                   </select>
                                   @if ($errors->has('est_forfait'))
                                   <br>
                                   <div class="alert alert-warning ">
                                      <strong>{{$errors->first('est_forfait')}}</strong> 
                                   </div>
                                   @endif
                                </div>
                             </div>
                        </div>
                      <div class="col-lg-6 col-md-6 col-sm-6"></div>
                    </div>
                    
                    <div class="row">
                        
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="prix_min">Prix minimum <span class="text-danger">*</span></label>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                   <input type="number" min="0" step="0.01" class="form-control {{$errors->has('prix_min') ? 'is-invalid' : ''}}" value="{{old('prix_min') ? old('prix_min') : $bareme->prix_min }}" id="prix_min" name="prix_min" required>
                                   @if ($errors->has('prix_min'))
                                   <br>
                                   <div class="alert alert-warning ">
                                      <strong>{{$errors->first('prix_min')}}</strong> 
                                   </div>
                                   @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="prix_max">Prix maximum <span class="text-danger">*</span></label>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                   <input type="number" min="0" step="0.01" class="form-control {{$errors->has('prix_max') ? 'is-invalid' : ''}}" value="{{old('prix_max') ? old('prix_max') : $bareme->prix_max}}" id="prix_max" name="prix_max" required>
                                   @if ($errors->has('prix_max'))
                                   <br>
                                   <div class="alert alert-warning ">
                                      <strong>{{$errors->first('prix_max')}}</strong> 
                                   </div>
                                   @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row" id="div_forfait">
                        
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="forfait_min">Forfait minimum <span class="text-danger">*</span></label>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                   <input type="number" min="0" step="0.01" class="form-control {{$errors->has('forfait_min') ? 'is-invalid' : ''}}" value="{{old('forfait_min') ? old('forfait_min') : $bareme->forfait_min}}" id="forfait_min" name="forfait_min" >
                                   @if ($errors->has('forfait_min'))
                                   <br>
                                   <div class="alert alert-warning ">
                                      <strong>{{$errors->first('forfait_min')}}</strong> 
                                   </div>
                                   @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="forfait_max">Forfait maximum <span class="text-danger">*</span></label>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                   <input type="number" min="0" step="0.01" class="form-control {{$errors->has('forfait_max') ? 'is-invalid' : ''}}" value="{{old('forfait_max') ? old('forfait_max') : $bareme->forfait_max}}" id="forfait_max" name="forfait_max" >
                                   @if ($errors->has('forfait_max'))
                                   <br>
                                   <div class="alert alert-warning ">
                                      <strong>{{$errors->first('forfait_max')}}</strong> 
                                   </div>
                                   @endif
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <div class="row" id="div_pourcentage">
                        
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="pourcentage">Pourcentage <span class="text-danger">*</span></label>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                   <input type="number" min="0" step="0.01" class="form-control {{$errors->has('pourcentage') ? 'is-invalid' : ''}}" value="{{old('pourcentage') ? old('pourcentage') : $bareme->pourcentage}}" id="pourcentage" name="pourcentage" >
                                   @if ($errors->has('pourcentage'))
                                   <br>
                                   <div class="alert alert-warning ">
                                      <strong>{{$errors->first('pourcentage')}}</strong> 
                                   </div>
                                   @endif
                                </div>
                            </div>
                        </div>
                        
                    </div>
                

                  
                  <div class="form-group row" style="text-align: center; margin-top: 50px;">
                     <div class="col-lg-8 ml-auto">
                        <button class="btn btn-success btn-flat btn-addon btn-lg m-b-10 m-l-5 submit" id="ajouter"><i class="ti-pencil"></i>Modifier</button>
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
    
    let est_forfait = "{{$bareme->est_forfait}}";
    console.log(est_forfait);
    if(est_forfait == false){
        $('#div_forfait').hide();
        $('#div_pourcentage').show();
    }else{
        $('#div_forfait').show();
        $('#div_pourcentage').hide();
    }

    $('#est_forfait').change(function(){
        
        if($('#est_forfait').val() == "false"){
            $('#div_forfait').hide();
            $('#div_pourcentage').show();
           
        }else{
            
            $('#div_forfait').show();
            $('#div_pourcentage').hide();
        }

    });
</script>

@endsection