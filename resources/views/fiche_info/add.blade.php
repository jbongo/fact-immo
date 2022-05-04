@extends('layouts.app')
@section('content')
@section ('page_title')
Créer la fiche informatique de {{$mandataire->nom}} {{$mandataire->prenom}}
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
            <a href="{{route('outil_info.index')}}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5"><i class="ti-angle-double-left"></i>@lang('Outils Informatique')</a>
         </div>
         <div class="card-body">
            <div class="form-validation">
               <form class="form-valide form-horizontal" action="{{route('fiche_info.store')}}" method="post">
                  {{ csrf_field() }}

                @foreach ($outils as $outil )
                    
                
                <hr style="border: 10px solid #3e3a92">
                
                <p style="text-align: center; font-size:20px; color:#a21e4b">{{$outil->nom}}</p>
                <div class="row">
                   <br>
                   <br>
                   <input type="hidden" value="{{$outil->id}}" id="id_{{$outil->id}}" name="id_{{$outil->id}}">
                   
                    <div class="col-lg-6 col-md-6 col-sm-6">                      
                         <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="nom_{{$outil->id}}">Nom <span class="text-danger">*</span></label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="text" class="form-control " value="{{$outil->nom}}" id="nom_{{$outil->id}}" name="nom_{{$outil->id}}" placeholder="Nom.." required>
                               
                            </div>
                         </div>
                    </div>
                    
                    <div class="col-lg-6 col-md-6 col-sm-6">                      
                        <div class="form-group row">
                           <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="site_web_{{$outil->id}}">Site web <span class="text-danger">*</span></label>
                           <div class="col-lg-8 col-md-8 col-sm-8">
                              <input type="url" class="form-control {{$errors->has('site_web') ? 'is-invalid' : ''}}" value="{{$outil->site_web}}" id="site_web_{{$outil->id}}" name="site_web_{{$outil->id}}"  >
                             
                           </div>
                        </div>
                   </div>
                    
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="form-group row">
                           <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="identifiant_{{$outil->id}}">Identifiant </label>
                           <div class="col-lg-8 col-md-8 col-sm-8">
                              <input type="text" class="form-control {{$errors->has('identifiant') ? 'is-invalid' : ''}}" value="{{$outil->identifiant ? $outil->identifiant : $mandataire->email }}" id="identifiant_{{$outil->id}}" name="identifiant_{{$outil->id}}"  >
                             
                           </div>
                        </div>
                   </div>
                   
                   <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="form-group row">
                           <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="password_{{$outil->id}}">Mot de passe </label>
                           <div class="col-lg-8 col-md-8 col-sm-8">
                              <input type="text" class="form-control {{$errors->has('password') ? 'is-invalid' : ''}}" value="{{$outil->password ? $outil->password : $mandataire->getPassword() }}" id="nom_{{$outil->id}}" name="password_{{$outil->id}}" >
                              
                           </div>
                        </div>
                   </div>
                   
                  
                   {{-- @foreach ($outil->champs() as $key => $champ)
                   
                   <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="form-group row">
                           <label class="col-lg-4 col-md-4 col-sm-4 control-label text-danger" for="nom{{$outil->id}}_{{$key}}">{{$champ[0]}} </label>
                           <div class="col-lg-8 col-md-8 col-sm-8">
                                <input type="text" class="form-control" value="{{$champ[1]}}" id="nom{{$outil->id}}_{{$key}}" name="{{$champ[0]}}{{$outil->id}}_{{$key}}" >
                            
                           </div>
                        </div>
                   </div>
                   
                  
                  
                    @endforeach --}}
                    
                    
            

                        
       
                    <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top:100px; float:left;">

                          <div class="form-group row">
                             <label class="col-lg-2 col-md-2 col-sm-2  control-label" value="" for="autre_champ_{{$outil->id}}">Autre champ</label>
                             <div class="col-lg-6 col-md-6 col-sm-6 ">

                             <textarea name="autre_champ_{{$outil->id}}" id="autre_champ_{{$outil->id}}" cols="30" rows="15" >{{$outil->autre_champ}}</textarea>
                                
                             </div>
                          </div>
                    </div>
                  
                  
                </div> 
                
                <hr style="border: 10px solid #3e3a92">
                @endforeach
                
                <input type="hidden" name="user_id" value="{{$mandataire->id}}">
                  <div class="form-group row" >
                     <div class="col-lg-8 ml-auto">
                        <button class="btn btn-success btn-flat btn-addon btn-lg m-b-10 m-l-5 submit" id="ajouter" style="text-align: center; margin-top: 50px; "><i class="ti-plus"></i>Enregistrer</button>
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
     

        $(wrapper).on("click", ".remove_field", function(e) {
            e.preventDefault();
         
            $(this).parent('div').remove();
            y--;
        })
    });
</script>


{{-- Envoi des données en ajax pour le stockage --}}
<script>

    $('.form-validexxxxx').submit(function(e) {
        e.preventDefault();
        var form = $(".form-valide");




        data = {
            "user_id" :" {{$mandataire->id}}",               
            "champs" : decodeURIComponent( $('.form-valide').serialize() ),

        }
          
  
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        })
            $.ajax({
                type: "POST",
                url: "{{route('fiche_info.store')}}",
               
                data: data,
                success: function(data) {
                    console.log(data);
                    
                    swal(
                            'Ajouté',
                            'La fiche a été ajouté avec succés!',
                            'success'
                        )
                        .then(function() {
                            window.location.href = "{{route('fiche_info.index')}}";
                        })
                        // setInterval(() => {
                        //     window.location.href = "{{route('mandataire.index')}}";
                            
                        // }, 5);
                },
                error: function(data) {
                    console.log(data);
                    
                    swal(
                        'Echec',
                        'La fiche  n\'a pas été ajouté!',
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