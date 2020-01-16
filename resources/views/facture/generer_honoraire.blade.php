@extends('layouts.app') 
@section('content') 
@section ('page_title') 
    Générer la facture <span class="color-warning"> {{$facture->compromis_id}} </span> 
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

                <div class="panel-body">
                
<br> <hr>
                    <fieldset class="col-md-12">
                        <legend>Infos factures</legend>
                        <div class="panel panel-warning">
                            <div class="panel-body">
                                <form class="form-valide3" action="{{ route('facture.generer_pdf_honoraire',Crypt::encrypt($facture->id)) }}" method="get">
                                    {{ csrf_field() }}

                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6">

                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="numero">Numéro de la facture<span class="text-danger">*</span></label>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control"  id="numero" name="numero" required>
                                                </div>
                                            </div>
                                           
                                            

                                           
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="date">Date de la facture<span class="text-danger">*</span></label>
                                                <div class="col-lg-4">
                                                    <input type="date" class="form-control" id="date" name="date" required>
                                                </div>
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
                        <legend>Modèles de facture</legend>
                        <div class="panel panel-warning">
                            <div class="panel-body">

                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <p>
                                            <img class="zoomable" style='width:40%;' src="{{asset('images/test1.png')}}" />
                                        </p>
                                     
                                        <hr>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="modele_1">Choisir ce modèle</label>
                                            <div class="col-lg-1">
                                                <input type="radio" style="height:20px; width:50px" id="modele_1"  name="modele" value="1"  required>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <p>
                                            <img class="zoomable" style='width:40%;' src="{{asset('images/test2.png')}}" />
                                        </p>
                                        <hr>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="modele_2">Choisir ce modèle</label>
                                            <div class="col-lg-1">
                                                <input type="radio" style="height:20px; width:50px" id="modele_2"  name="modele" value="2"  required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <p>
                                            <img class="zoomable" style='width:40%;' src="{{asset('images/test3.jpg')}}" />
                                        </p>
                                        <hr>
                                        <hr>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="modele_3">Choisir ce modèle</label>
                                            <div class="col-lg-1">
                                                <input type="radio" style="height:20px; width:50px" id="modele_3"  name="modele" value="3"  required>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>

                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>

            <div class="form-group row" style="text-align: center; margin-top: 50px;">
                <div class="col-lg-8 ml-auto">
                    <button class="btn btn-danger btn-flat btn-addon btn-lg m-b-10 m-l-5  " id="terminer"><i class="ti-save"></i>Générer</button>
                </div>
            </div>

            </form>
        </div>
    </div>
</div>
@stop @section('js-content') 
<script src="http://static.tumblr.com/xz44nnc/o5lkyivqw/jquery-1.3.2.min.js"></script>
<script>
$('img.zoomable').css({cursor: 'pointer'}).live('click', function () {
  var img = $(this);
  var bigImg = $('<img />').css({
    'max-width': '100%',
    'max-height': '100%',
    'display': 'inline'
  });
  bigImg.attr({
    src: img.attr('src'),
    alt: img.attr('alt'),
    title: img.attr('title')
  });
  var over = $('<div />').text(' ').css({
    'height': '100%',
    'width': '100%',
    'background': 'rgba(0,0,0,.82)',
    'position': 'fixed',
    'top': 0,
    'left': 0,
    'opacity': 0.0,
    'cursor': 'pointer',
    'z-index': 9999,
    'text-align': 'center'
  }).append(bigImg).bind('click', function () {
    $(this).fadeOut(300, function () {
      $(this).remove();
    });
  }).insertAfter(this).animate({
    'opacity': 1
  }, 300);
});
</script>








{{-- Envoi des données en ajax pour le stockage --}}
<script>

    $('.form-valide3').submit(function(e) {
        e.preventDefault();
        var form = $(".form-valide3");

           
            var palierdata = $('#palier_starter input').serialize();

        data = {
            "numero" : $('#numero').val(),
            "date" : $('#date').val(),
            "modele" : $('#modele').val(),


        }
        var facture_id = "{{Crypt::encrypt($facture->id)}}";
        // console.log(data);
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        })
            $.ajax({
                type: "GET",
                url: "facture/honoraire/generer-pdf/"+facture_id
                data: data,
                success: function(data) {
                    console.log(data);
                    
                    swal(
                            'Ajouté',
                            'La facture a été ajouté avec succés!',
                            'success'
                        )
                        .then(function() {
                            // window.location.href = "{{route('mandataire.index')}}";
                        })
                        setInterval(() => {
                            window.location.href = "{{route('mandataire.index')}}";
                            
                        }, 5);
                },
                error: function(data) {
                    console.log(data);
                    
                    swal(
                        'Echec',
                        'La facture  n\'a pas été ajouté!',
                        'error'
                    );
                }
            });
    });
</script>
@endsection