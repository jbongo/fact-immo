@extends('layouts.app')
@section('content')
@section ('page_title')
Modifier {{$outil->nom}}
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
            <a href="{{route('outil_info.index')}}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5"><i class="ti-angle-double-left"></i>@lang('Liste des Outils')</a>
         </div>
         <div class="card-body">
            <div class="form-validation">
               <form class="form-valide form-horizontal" action="#" method="post">
                  {{ csrf_field() }}

                <div class="row">
                    <hr>
                    <hr>
                    <hr>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group row">
                            <label class="col-lg-2 col-md-2 col-sm-2 control-label" for="nom">Nom <span class="text-danger">*</span></label>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                               <input type="text" class="form-control {{$errors->has('nom') ? 'is-invalid' : ''}}" value="{{$outil->nom}}" id="nom" name="nom" placeholder="Nom.." required>
                               @if ($errors->has('nom'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('nom')}}</strong> 
                               </div>
                               @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="form-group row">
                           <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="identifiant">Identifiant </label>
                           <div class="col-lg-8 col-md-8 col-sm-8">
                              <input type="text" class="form-control {{$errors->has('identifiant') ? 'is-invalid' : ''}}" value="{{$outil->identifiant}}" id="identifiant" name="identifiant"  >
                              @if ($errors->has('identifiant'))
                              <br>
                              <div class="alert alert-warning ">
                                 <strong>{{$errors->first('identifiant')}}</strong> 
                              </div>
                              @endif
                           </div>
                        </div>
                   </div>
                   
                   <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="form-group row">
                           <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="password">Mot de passe </label>
                           <div class="col-lg-8 col-md-8 col-sm-8">
                              <input type="text" class="form-control {{$errors->has('password') ? 'is-invalid' : ''}}" value="{{$outil->password}}" id="password" name="password" >
                              @if ($errors->has('password'))
                              <br>
                              <div class="alert alert-warning ">
                                 <strong>{{$errors->first('password')}}</strong> 
                              </div>
                              @endif
                           </div>
                        </div>
                   </div>
                    
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="col-lg-12 col-md-12 col-sm-12" id="palier_expert">
                            <a class="btn btn-warning add_champ" style="margin-left: 53px;">Ajouter un champ</a> <br> <hr>
                            <div class="form-inline champs" id="champs">
                                @foreach ($champs as $champ)
                                    <div class = "form-inline field{{$outil->id}}"><div class="form-group"><label for="nom{{$outil->id}}"> Champ : </label> <input class="form-control" type="text" value="{{$champ[0]}}" id="nom{{$outil->id}}" name="nom{{$outil->id}}" required/> </div> <div class="form-group"><label for="valeur{{$outil->id}}">Valeur par défault: </label> <input class="form-control" type="text" value="{{$champ[1]}}" id="valeur{{$outil->id}}" name="valeur{{$outil->id}}" ></div> <button href="#" id="pal_expert{{$outil->id}}" class="btn btn-danger remove_field">Enlever</button></br> </div> </br>
                                    
                                @endforeach
                            </div>                               
                        </div>
                    </div>
                    
                    <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top:100px; float:left;">

                        <div class="form-group row">
                           <label class="col-lg-2 col-md-2 col-sm-2  control-label"  for="autre_champ">Autre champ</label>
                           <div class="col-lg-6 col-md-6 col-sm-6 ">

                           <textarea name="autre_champ" id="autre_champ" cols="30" rows="15" >{{$outil->autre_champ}}</textarea>
                              @if ($errors->has('autre_champ'))
                              <br>
                              <div class="alert alert-warning ">
                                 <strong>{{$errors->first('autre_champ')}}</strong> 
                              </div>
                              @endif 
                           </div>
                        </div>
                  </div>
                  
                  <hr>
                  <div class="form-group row" >
                     <div class="col-lg-8 ml-auto">
                        <button class="btn btn-success btn-flat btn-addon btn-lg m-b-10 m-l-5 submit" id="ajouter" style="text-align: center; margin-top: 50px; "><i class="ti-save"></i>Modifier</button>
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
    var y = 1;
    $(document).ready(function() {
        var max_fields = 15;
        var wrapper = $(".champs");
        var add_button = $(".add_champ");

        
        $(add_button).click(function(e) {
            e.preventDefault();
            if (y < max_fields) {
               
                    $(wrapper).append('<div class = "form-inline field' + y + '"><div class="form-group"><label for="nom' + y + '"> Champ  : </label> <input class="form-control" type="text" value="" id="nom' + y + '" name="nom' + y + '" required/> </div> <div class="form-group"><label for="valeur' + y + '">Valeur par défault: </label> <input class="form-control" type="text" value="" id="valeur' + y + '" name="valeur' + y + '" ></div> <button href="#" id="pal_expert' + y + '" class="btn btn-danger remove_field">Enlever</button></br> </div> </br>'); //add input box
         
                  y++;
             
            }else{
            
                swal(
                        'Ajout impossible!',
                        'Nombre de champs maximum atteint!',
                        'error'
                    );
            }
        });

        $(wrapper).on("click", ".remove_field", function(e) {
            e.preventDefault();
         
            $(this).parent('div').remove();
            y--;
        })
    });
</script>


{{-- Envoi des données en ajax pour le stockage --}}
<script>

    $('.form-valide').submit(function(e) {
        e.preventDefault();
        var form = $(".form-valide");

        data = {
            "nom" : $('#nom').val(),        
            "identifiant" : $('#identifiant').val(),        
            "password" : $('#password').val(),        
            "autre_champ" : $('#autre_champ').val(),        
            "champs" : $('#champs input').serialize(),

        }
          
        console.log(data);
        
        
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        })
            $.ajax({
                type: "POST",
                url: "{{route('outil_info.update', $outil->id)}}",
               
                data: data,
                success: function(data) {
                    console.log(data);
                    
                    swal(
                            'Modifié',
                            'L\'outil a été modifié avec succés!',
                            'success'
                        )
                        .then(function() {
                            // window.location.href = "{{route('outil_info.index')}}";
                        })
                        // setInterval(() => {
                        //     window.location.href = "{{route('mandataire.index')}}";
                            
                        // }, 5);
                },
                error: function(data) {
                    console.log(data);
                    
                    swal(
                        'Echec',
                        'L\'outil  n\'a pas été modifié!',
                        'error'
                    );
                }
            });
    });
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