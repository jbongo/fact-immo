@extends('layouts.app')
@section('content')
    @section ('page_title')
   Outil de calcul
    @endsection

    <div class="row"> 
        <div class="col-lg-12">
                @if (session('ok'))
       
                <div class="alert alert-success alert-dismissible fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <a href="#" class="alert-link"><strong> {{ session('ok') }}</strong></a> 
                </div>
             @endif       
            <div class="card alert">
            @if (Auth()->user()->role == "mandataire")
              <strong> Votre date d'anniversaire : <span class="color-danger">{{Auth()->user()->date_anniv("fr")}}</span></strong>
            <br><hr>
            @endif
                <!-- table -->
                

            <div class="row">

                <div class="col-lg-6">
                    <div class="card alert">
                        <div class="card-header">
                            <h4 class="m-l-5">Votre chiffre d'affaires HT réalisé  (encaissé)</h4>
                            <div class="card-header-right-icon">
                                <ul>
                                    <li><i class="ti-reload"></i></li>
                                </ul>
                            </div>
                        </div>
                        <br><br>




                        <div class="row">
                            @if(Auth::user()->role == "admin")
                        
                            <div class="col-lg-5 col-md-5 col-sm-5" id="div_user_reseau">
                                <div class="form-group row" >
                                    <label class="col-lg-8 col-md-8 col-sm-8 col-form-label" for="user_id">Choisir un mandataire <span class="text-danger">*</span> </label>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <select class="selectpicker " id="user_id" name="user_id" data-live-search="true" data-style="btn-warning btn-rounded" >
                                            @foreach ($users as $user )
                                                <option value="{{ $user->id }}" data-tokens="{{ $user->nom }} {{ $user->prenom }}">{{ $user->nom }} {{ $user->prenom }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
    
    
                            @else 
                            
                            <input type="hidden"  name="user_id" id="user_id" value="{{Auth::user()->id}}" class="form-control">
    
                            @endif
                        </div>
                        <div class="row">

                       
                        


                            <div class="col-md-4">
                                <label>Date de début</label>
                                    <input type="date" required name="date_deb" id="date_deb" value="" class="form-control">
                            </div>
                        
                            <div class="col-md-4">
                                <label>Date de fin</label>
                                    <input type="date" required name="date_fin" id="date_fin" value="" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label>.</label>
                        
                                <button id="calculer_ca" class="btn btn-danger form-control">Calculer</button>
                            </div>
                        </div>
                     <br><hr>
                        <div class="row">
                            <div class="col-lg-6 col-md-6" style="font-size: 20px">
                                <span>Résultat : </span> <span style="color:#9f0000; font-weigth:bold " id="result" >  </span>
                               
                            </div>
                        </div>
                        
                        <br><hr>
                        <div class="row">
                            <div class="col-lg-6 col-md-6" style="font-size: 20px">
                                <span>CA STYL'IMMO associé: </span> <span style="color:#261898; font-weigth:bold " id="result_assoc" >  </span>
                               
                            </div>
                        </div>
                    </div>


                </div>

                <div class="col-lg-6">
                    <div class="card alert">
                        <div class="card-header">
                            <h4 class="m-l-5">Chiffre d'affaires HT STYL'IMMO (encaissé)</h4>
                            <div class="card-header-right-icon">
                                <ul>
                                    <li><i class="ti-reload"></i></li>
                                </ul>
                            </div>
                        </div>
<br><br>

                        <div class="row">

                            @if(Auth::user()->role == "admin")
                        
                            <div class="col-lg-5 col-md-5 col-sm-5" id="div_user_reseau_styl">
                                <div class="form-group row" >
                                    <label class="col-lg-8 col-md-8 col-sm-8 col-form-label" for="user_id_styl">Choisir un mandataire <span class="text-danger">*</span> </label>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <select class="selectpicker " id="user_id_styl" name="user_id_styl" data-live-search="true" data-style="btn-warning btn-rounded" >
                                            @foreach ($users as $user )
                                                <option value="{{ $user->id }}" data-tokens="{{ $user->nom }} {{ $user->prenom }}">{{ $user->nom }} {{ $user->prenom }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
    
    
                            @else 
                            
                        <input type="hidden"  name="user_id_styl" id="user_id_styl" value="{{Auth::user()->id}}" class="form-control">
    
                            @endif
                        </div>

                        <div class="row">

                            <div class="col-md-3">
                                <label>Date de début</label>
                                    <input type="date" required name="date_deb_styl" id="date_deb_styl" value="" class="form-control">
                            </div>
                        
                            <div class="col-md-3">
                                <label>Date de fin</label>
                                    <input type="date" required name="date_fin_styl" id="date_fin_styl" value="" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label>.</label>
                        
                                <button id="calculer_ca_styl" class="btn btn-danger form-control" style="background: #261898">Calculer</button>
                            </div>
                        </div>

                        <br><hr>
                        <div class="row">
                            <div class="col-lg-6 col-md-6" style="font-size: 20px">
                                <span>Résultat : </span> <span style="color:#48035d; font-weigth:bold " id="result_styl" >  </span>
                               
                            </div>
                        </div>
                    </div>
                    </div>


                </div>


            </div>
<br>
            <hr>
          






<br>
<br>
<hr><br>

        </div>
    </div>
</div>
@endsection
@section('js-content')



<script>
    // ######### Ca


    $(function() {

        $('#calculer_ca').click(function(){

            $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                })

                const user_id = $('#user_id').val();
                const date_deb = $('#date_deb').val();
                const date_fin = $('#date_fin').val();
             
                

                $.ajax({                        
                    url: 'outil-calcul/ca',
                    type: 'POST',
                    data: {user_id, date_deb, date_fin},
                    success: function(data){
                    
                    console.log(data);
                    $('#result').text(data[0]+" € HT");
                    $('#result_assoc').text(data[1]+" € HT");
                    },
                    error : function(data){
                    console.log(data);
                    }
                })
               

                
        
            })
        })
       


// calculer ca_styl


$(function() {

$('#calculer_ca_styl').click(function(){

    $.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        })

        const user_id = $('#user_id_styl').val();
        const date_deb = $('#date_deb_styl').val();
        const date_fin = $('#date_fin_styl').val();
     
        

        $.ajax({                        
            url: 'outil-calcul/ca-styl',
            type: 'POST',
            data: {user_id, date_deb, date_fin},
            success: function(data){
            
            $('#result_styl').text(data+ " € HT");
         

            },
            error : function(data){
            console.log(data);
            }
        })
       

        

    })
})

</script>


@endsection