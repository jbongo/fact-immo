@extends('layouts.app')
@section('content')
@section ('page_title')
Modifier la fiche informatique de {{$mandataire->nom}} {{$mandataire->prenom}}
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
            <a href="{{route('outil_info.index')}}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5"><i class="ti-angle-double-left"></i>@lang('Outils Informatque')</a>
            <a href="{{route('fiche_info.fiche_pdf', Crypt::encrypt($mandataire->id))}}" class="btn btn-danger btn-flat btn-addon m-b-10 m-l-5"><i class="ti-download"></i>@lang('Télécharger la Fiche')</a>
            <a href="{{route('fiche_info.reiniatiliser', Crypt::encrypt($mandataire->id))}}" class="btn btn-danger btn-flat btn-addon m-b-10 m-l-5"><i class="ti-reload"></i>@lang('réinitialiser la Fiche')</a>
            
         </div>
         <div class="card-body">
            <div class="form-validation">
               <form class="form-valide form-horizontal" action="{{route('fiche_info.update', $mandataire->id)}}" method="post">
                  {{ csrf_field() }}

           

                @foreach ($outils as $key => $outil  )
                    
                  @php 
                     $champ = $outil->useroutil($fiche->id) ;
                  @endphp
                  
                <hr style="border: 10px solid #3e3a92">
                
                @if($champ != null)
                      <p style="text-align: center; font-size:20px; color:#a21e4b; font-weight:bold">{{$champ->nom}}</p>
                      <div class="row">
                         <br>
                         <br>
                         <input type="hidden" value="{{$champ->id}}" id="id_{{$key}}" name="id_{{$key}}">
                         
                          <div class="col-lg-6 col-md-6 col-sm-6">                      
                               <div class="form-group row">
                                  <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="nom_{{$key}}">Nom <span class="text-danger">*</span></label>
                                  <div class="col-lg-8 col-md-8 col-sm-8">
                                     <input type="text" class="form-control " value="{{$champ->nom}}" id="nom_{{$key}}" name="nom_{{$key}}" placeholder="Nom.." required>
                                     
                                  </div>
                               </div>
                          </div>
                          
                          <div class="col-lg-6 col-md-6 col-sm-6">                      
                              <div class="form-group row">
                                 <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="site_web_{{$key}}">Site web </label>
                                 <div class="col-lg-8 col-md-8 col-sm-8">
                                    <input type="url" class="form-control {{$errors->has('site_web') ? 'is-invalid' : ''}}" value="{{$champ->site_web}}" id="site_web_{{$key}}" name="site_web_{{$key}}"  >
                                   
                                 </div>
                              </div>
                         </div>
                          
                          <div class="col-lg-6 col-md-6 col-sm-6">
                              <div class="form-group row">
                                 <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="identifiant_{{$key}}">Identifiant </label>
                                 <div class="col-lg-8 col-md-8 col-sm-8">
                                    <input type="text" class="form-control {{$errors->has('identifiant') ? 'is-invalid' : ''}}" value="{{$champ->identifiant}}" id="identifiant_{{$key}}" name="identifiant_{{$key}}"  >
                                   
                                 </div>
                              </div>
                         </div>
                         
                         <div class="col-lg-6 col-md-6 col-sm-6">
                              <div class="form-group row">
                                 <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="password_{{$key}}">Mot de passe </label>
                                 <div class="col-lg-8 col-md-8 col-sm-8">
                                    <input type="text" class="form-control {{$errors->has('password') ? 'is-invalid' : ''}}" value="{{$champ->password}}" id="nom_{{$key}}" name="password_{{$key}}" >
                                    
                                 </div>
                              </div>
                         </div>
                         
                        
                         {{-- @foreach ($champ->champs() as $key => $champ)
                         
                         <div class="col-lg-6 col-md-6 col-sm-6">
                              <div class="form-group row">
                                 <label class="col-lg-4 col-md-4 col-sm-4 control-label text-danger" for="nom{{$key}}_{{$key}}">{{$champ[0]}} </label>
                                 <div class="col-lg-8 col-md-8 col-sm-8">
                                      <input type="text" class="form-control" value="{{$champ[1]}}" id="nom{{$key}}_{{$key}}" name="{{$champ[0]}}{{$key}}_{{$key}}" >
                                  
                                 </div>
                              </div>
                         </div>
                         
                        
                        
                          @endforeach --}}
                          
                          
                  
      
                              
             
                          <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top:100px; float:left;">
      
                                <div class="form-group row">
                                   <label class="col-lg-2 col-md-2 col-sm-2  control-label" value="" for="autre_champ_{{$key}}">Autre champ</label>
                                   <div class="col-lg-6 col-md-6 col-sm-6 ">
      
                                   <textarea name="autre_champ_{{$key}}" id="autre_champ_{{$key}}" cols="30" rows="15" >{{$champ->autre_champ}}</textarea>
                                      
                                   </div>
                                </div>
                          </div>
                        
                        
                      </div> 
                      
                  @else 
                  
                  
                  <p style="text-align: center; font-size:20px; color:#a21e4b; font-weight:bold">{{$outil->nom}}</p>
<div class="row">
   <br>
   <br>
   <input type="hidden" value="{{$outil->id}}" id="id_{{$key}}" name="id_{{$key}}">
   
    <div class="col-lg-6 col-md-6 col-sm-6">                      
         <div class="form-group row">
            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="nom_{{$key}}">Nom <span class="text-danger">*</span></label>
            <div class="col-lg-8 col-md-8 col-sm-8">
               <input type="text" class="form-control " value="{{$outil->nom}}" id="nom_{{$key}}" name="nom_{{$key}}" placeholder="Nom.." required>
               
            </div>
         </div>
    </div>
    
    <div class="col-lg-6 col-md-6 col-sm-6">                      
        <div class="form-group row">
           <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="site_web_{{$key}}">Site web </label>
           <div class="col-lg-8 col-md-8 col-sm-8">
              <input type="url" class="form-control {{$errors->has('site_web') ? 'is-invalid' : ''}}" value="{{$outil->site_web}}" id="site_web_{{$key}}" name="site_web_{{$key}}"  >
             
           </div>
        </div>
   </div>
    
    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="form-group row">
           <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="identifiant_{{$key}}">Identifiant </label>
           <div class="col-lg-8 col-md-8 col-sm-8">
              <input type="text" class="form-control {{$errors->has('identifiant') ? 'is-invalid' : ''}}" value="{{$outil->identifiant}}" id="identifiant_{{$key}}" name="identifiant_{{$key}}"  >
             
           </div>
        </div>
   </div>
   
   <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="form-group row">
           <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="password_{{$key}}">Mot de passe </label>
           <div class="col-lg-8 col-md-8 col-sm-8">
              <input type="text" class="form-control {{$errors->has('password') ? 'is-invalid' : ''}}" value="{{$outil->password}}" id="nom_{{$key}}" name="password_{{$key}}" >
              
           </div>
        </div>
   </div>
   

    <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top:100px; float:left;">

          <div class="form-group row">
             <label class="col-lg-2 col-md-2 col-sm-2  control-label" value="" for="autre_champ_{{$key}}">Autre champ</label>
             <div class="col-lg-6 col-md-6 col-sm-6 ">

             <textarea name="autre_champ_{{$key}}" id="autre_champ_{{$key}}" cols="30" rows="15" >{{$outil->autre_champ}}</textarea>
                
             </div>
          </div>
    </div>
  
  
</div> 

                  @endif
                
                <hr style="border: 10px solid #3e3a92">
                @endforeach
                
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

    $('.form-validexxx').submit(function(e) {
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
                url: "{{route('fiche_info.update', $mandataire->id)}}",
               
                data: data,
                success: function(data) {
                    console.log(data);
                    
                    swal(
                            'Modifié',
                            'La fiche a été modifiée avec succés!',
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
                        'La fiche  n\'a pas été modifiée!',
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