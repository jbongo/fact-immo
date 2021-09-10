@extends('layouts.app') 
@section('content') 
@section ('page_title') 
    Profil du prospect 
@endsection

<div class="row">

   <div class="col-lg-12">
   
      <div class="card">
    <a href="{{route('prospect.index')}}" class="btn btn-default btn-flat btn-addon m-b-10 m-l-5"><i class="ti-angle-double-left"></i>@lang('liste des prospects ')</a>
      
         <div class="card-body">
            <div class="col-lg-6">
            
            
               <div class="panel panel-default lobipanel-basic">
                  <div class="panel-heading">Fiche utilisateur.</div>
                  <div class="panel-body">
                     <div class="card alert">
                        <div class="card-body">
                           <div class="user-profile">
                              <div class="row">
                                 <div class="col-lg-4">
                                    <div class="col-lg-12">
                                       <div class="user-photo m-b-30">
                                          <img class="img-responsive" style="object-fit: cover; width: 225px; height: 225px; border: 5px solid #8ba2ad; border-style: solid; border-radius: 20px; padding: 3px;" src="{{asset('/images/avatar/'.(($prospect->civilite == "Mme." || $prospect->civilite == "Mme") ? "user_female.jpg ": "user_male.jpg"))}}" alt="">
                                       </div>
                                    </div>
    
                                    <div class="user-skill">
                                       <h4 style="color: #32ade1;text-decoration: underline;">Options</h4>
                                        @if (auth()->user()->role == "admin")
                                            <a href="{{route('prospect.edit',Crypt::encrypt($prospect->id) )}}"  class="btn btn-warning btn-rounded btn-addon btn-xs m-b-10"><i class="ti-pencil"></i>Modifier</a>
                                        @endif
                                        
                                        @if (auth()->user()->role == "admin" && $prospect->contrat != null)
                                       <a href="{{route('prospect.send_access',[ Crypt::encrypt($prospect->id) ,Crypt::encrypt($prospect->contrat->id) ])}}" title="Envoyer les accès au prospect" class="btn btn-default btn-rounded btn-addon btn-xs m-b-10 send-access"><i class="ti-pencil"></i>Envoyer les accès </a>
                                        @endif
                                    </div>
                                 </div>
                                 <div class="col-lg-8">
                                    <div class="user-profile-name" style="color: #d68300;">{{$prospect->civilite}} {{$prospect->nom}} {{$prospect->prenom}}</div>
                                    <div class="user-Location"><i class="ti-location-pin"></i> {{$prospect->ville}}</div>
                                    
                                    <div class="custom-tab user-profile-tab">
                                       <ul class="nav nav-tabs" role="tablist">
                                          <li role="presentation" class="active"><a href="#1" aria-controls="1" role="tab" data-toggle="tab">Détails</a></li>
                                       </ul>
                                       <div class="tab-content">
                                          <div role="tabpanel" class="tab-pane active" id="1">
                                             <div class="contact-information">
                                               
                                                <div class="phone-content">
                                                   <span class="contact-title"><strong>Téléphone Personnel:</strong></span>
                                                   <span class="phone-number" style="color: #ff435c; text-decoration: underline;">{{$prospect->telephone_portable}}</span>
                                                </div>
                                                <div class="phone-content">
                                                    <span class="contact-title"><strong>Téléphone Fixe:</strong></span>
                                                    <span class="phone-number" style="color: #ff435c; text-decoration: underline;">{{$prospect->telephone_fixe}}</span>
                                                 </div>
                                                <div class="address-content">
                                                   <span class="contact-title"><strong>Adresse:</strong></span>
                                                   <span class="mail-address">{{$prospect->adresse}}</span>
                                                </div>
                                                
                                                <div class="website-content">
                                                   <span class="contact-title"><strong>Code postal:</strong></span>
                                                   <span class="contact-website">{{$prospect->code_postal}}</span>
                                                </div>
                                                
                                                <div class="website-content">
                                                   <span class="contact-title"><strong>Ville:</strong></span>
                                                   <span class="contact-website">{{$prospect->ville}}</span>
                                                </div>
                                              
                                                <div class="email-content">
                                                   <span class="contact-title"><strong>Email:</strong></span>
                                                   <span class="contact-email" style="color: #ff435c; text-decoration: underline;">{{$prospect->email}}</span>
                                                </div>
                                               
                                             </div>
                                             <div class="basic-information">
                                                {{-- <h4 style="color: #32ade1;text-decoration: underline;">Role utilisateur</h4> --}}
                                                
                                                <div class="gender-content">
                                                   <span class="contact-title"><strong>Date d'ajout:</strong></span>
                                                   <span class="gender">{{date('d-m-Y',strtotime($prospect->created_at ))}}</span>
                                                </div>
                                             </div>
                                             
                                             <div class="basic-information">
                                                {{-- <h4 style="color: #32ade1;text-decoration: underline;">Role utilisateur</h4> --}}
                                                
                                                <div class="gender-content">
                                                   <span class="contact-title"><strong>Commentaire pro:</strong></span>
                                                   <span class="gender">{{$prospect->commentaire_pro}}</span>
                                                </div>
                                             </div>
                                             
                                             <div class="basic-information">
                                                {{-- <h4 style="color: #32ade1;text-decoration: underline;">Role utilisateur</h4> --}}
                                                
                                                <div class="gender-content">
                                                   <span class="contact-title"><strong>Commentaire perso:</strong></span>
                                                   <span class="gender">{{$prospect->commentaire_perso}}</span>
                                                </div>
                                             </div>
                                             
                                             
                                             <hr>
                                             <br>
                                             
                                             @if($prospect->renseigne == true )
                                             
                                             <div class="basic-information">                                                
                                                <div class="gender-content">
                                                   <span class="contact-title"><strong>Date de naissance :</strong></span>
                                                   <span class="gender">{{$prospect->date_naissance->format('d/m/Y')}}</span>
                                                </div>
                                             </div>
                                             
                                             <div class="basic-information">                                                
                                                <div class="gender-content">
                                                   <span class="contact-title"><strong>Lieu de naissance :</strong></span>
                                                   <span class="gender">{{$prospect->lieu_naissance}}</span>
                                                </div>
                                             </div>
                                             
                                             
{{--                                              
                                             <div class="basic-information">                                                
                                                <div class="gender-content">
                                                   <span class="contact-title"><strong>Département de naissance :</strong></span>
                                                   <span class="gender">{{$prospect->departement_naissance}}</span>
                                                </div>
                                             </div> --}}
                                             
                                             <div class="basic-information">                                                
                                                <div class="gender-content">
                                                   <span class="contact-title"><strong>Situation familliale :</strong></span>
                                                   <span class="gender">{{$prospect->situation_familliale}}</span>
                                                </div>
                                             </div>
                                             
                                             <div class="basic-information">                                                
                                                <div class="gender-content">
                                                   <span class="contact-title"><strong>Nationalité :</strong></span>
                                                   <span class="gender">{{$prospect->nationalite}}</span>
                                                </div>
                                             </div>
                                             
                                             <div class="basic-information">                                                
                                                <div class="gender-content">
                                                   <span class="contact-title"><strong>	Nom du père :</strong></span>
                                                   <span class="gender">{{$prospect->nom_pere}}</span>
                                                </div>
                                             </div>
                                             <div class="basic-information">                                                
                                                <div class="gender-content">
                                                   <span class="contact-title"><strong>Nom de la mère :</strong></span>
                                                   <span class="gender">{{$prospect->nom_mere}}</span>
                                                </div>
                                             </div>
                                             
                                             <div class="basic-information">                                                
                                                <div class="gender-content">
                                                   <span class="contact-title"><strong>Statut souhaité :</strong></span>
                                                   <span class="gender">{{$prospect->statut_souhaite}}</span>
                                                </div>
                                             </div>
                                             
                                             
                                             
                                             <div class="basic-information">                                                
                                                <div class="gender-content">
                                                   <span class="contact-title"><strong>Codes postaux souhaités:</strong></span>
                                                   <span class="gender">{{$prospect->code_postaux}}</span>
                                                </div>
                                             </div>
                                             <div class="basic-information">                                                
                                                <div class="gender-content">
                                                   <span class="contact-title"><strong>Numéro RSAC:</strong></span>
                                                   <span class="gender">{{$prospect->numero_rsac}}</span>
                                                </div>
                                             </div>
                                             <div class="basic-information">                                                
                                                <div class="gender-content">
                                                   <span class="contact-title"><strong>Numéro SIRET:</strong></span>
                                                   <span class="gender">{{$prospect->numero_siret}}</span>
                                                </div>
                                             </div>
                                             
                                             <div class="basic-information">                                                
                                                <div class="gender-content">
                                                   <span class="contact-title"><strong>Carte d'identité :</strong></span>
                                                   
                                                   @if($prospect->piece_identite != null)
                                                        <a class="btn btn-warning color-info" title="Télécharger la pièce d'identité" style="color: #fff"   href="{{route('prospect.telecharger',[ Crypt::encrypt($prospect->id),"piece_identite"])}}"  class="  m-b-10 m-l-5 ">Télécharger <i class="ti-download"></i> </a>
                                                   
                                                   @else 
                                                        <span class="contact-title text-danger"><strong> Non Ajoutée </strong></span>                                                  
                                                   @endif                                                
                                                </div>
                                             </div>
                                             
                                             <div class="basic-information">                                                
                                                <div class="gender-content">
                                                   <span class="contact-title"><strong>Attestion responsabilité  :</strong></span>
                                                   
                                                   @if($prospect->attestation_responsabilite != null)
                                                        <a class="btn btn-warning color-info" title="Télécharger la pièce d'identité" style="color: #fff"   href="{{route('prospect.telecharger',[ Crypt::encrypt($prospect->id),"attestation_responsabilite"])}}"  class="  m-b-10 m-l-5 ">Télécharger <i class="ti-download"></i> </a>
                                                   
                                                   @else 
                                                        <span class="contact-title text-danger"><strong> Non Ajoutée </strong></span>                                                  
                                                   @endif                                                
                                                </div>
                                             </div>
                                             
                                             <div class="basic-information">                                                
                                                <div class="gender-content">
                                                   <span class="contact-title"><strong>Rib :</strong></span>
                                                   
                                                   @if($prospect->rib != null)
                                                        <a class="btn btn-warning color-info" title="Télécharger la pièce d'identité" style="color: #fff"   href="{{route('prospect.telecharger',[ Crypt::encrypt($prospect->id),"rib"])}}"  class="  m-b-10 m-l-5 ">Télécharger <i class="ti-download"></i> </a>
                                                   
                                                   @else 
                                                        <span class="contact-title text-danger"><strong> Non Ajoutée </strong></span>                                                  
                                                   @endif                                                
                                                </div>
                                             </div>
                                             
                                             
                                             <div class="basic-information">                                                
                                                <div class="gender-content">
                                                   <span class="contact-title"><strong>Photo :</strong></span>
                                                   
                                                   @if($prospect->photo != null)
                                                        <a class="btn btn-warning color-info" title="Télécharger la pièce d'identité" style="color: #fff"   href="{{route('prospect.telecharger',[ Crypt::encrypt($prospect->id),"photo"])}}"  class="  m-b-10 m-l-5 ">Télécharger <i class="ti-download"></i> </a>
                                                   
                                                   @else 
                                                        <span class="contact-title text-danger"><strong> Non Ajoutée </strong></span>                                                  
                                                   @endif                                                
                                                </div>
                                             </div>
                                             
                                             @else 
                                             
                                             
                                             
                                             
                                             @endif
                                            
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         
                
          
            <div class="col-lg-6">



<hr style="border:2px solid red">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="media">
                                <div class="media-left media-middle">
                                    <i class="ti-id-badge f-s-48 color-danger m-r-1"></i>
                                </div>
                                
                                
                                <div class="media-body">
                                    <h4>Fiche (formulaire) envoyée par mail au prospect</h4>
                                    <p><label class="color-primary">La fiche a t'elle été consultée par le prospect ? :</label>  @if($prospect->a_ouvert_fiche == true)<span  style="color:white" class="badge badge-success">Oui</span>@else <span class="badge badge-danger">Non</span> @endif </p>
                                    <p><label class="color-primary">La fiche a t'elle été renseignée par le prospect ? :</label>  @if($prospect->renseigne == true)<span  style="color:white" class="badge badge-success">Oui</span>@else <span class="badge badge-danger">Non</span> @endif </p>
                                </div>
                                
                                
                                
                                <hr>
                                
                                <span><a href="{{route('prospect.envoyer_modele_contrat',Crypt::encrypt($prospect->id) )}}" style="background: #3b4842" class="btn btn-default btn-flat btn-addon m-b-10 m-l-5" data-toggle="tooltip" title="@lang('Envoyer le modèle de contrat à  ') {{ $prospect->nom }}"><i class="ti-email"></i>@if($prospect->modele_contrat_envoye == true) Renvoyer @else Envoyer @endif le modèle </a> </span>
                                
                              <hr>
                                <span><a href="{{route('prospect.envoi_mail_fiche',Crypt::encrypt($prospect->id) )}}"class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5"  data-toggle="tooltip" title="@lang('Envoyer la fiche à remplir à ') {{ $prospect->nom }}"><i class="ti-email"></i>@if($prospect->fiche_envoyee == true) Renvoyer @else Envoyer @endif  fiche prospect </a> </span>
                              <hr>
                                
                                <span><a href="{{route('prospect.prospect_a_mandataire',Crypt::encrypt($prospect->id) )}}"  class="btn btn-danger btn-flat btn-addon m-b-10 m-l-5" data-toggle="tooltip" title="@lang('Passer le prospect à mandataire ') {{ $prospect->nom }}"><i class="ti-email"></i>Passer à mandatataire </a> </span>
                                
                              
                            </div>
                        </div>
                    </div>
                </div>

     


             
            </div>
       
         </div>
      </div>
   </div>
</div>


  

</div>

@endsection
@section('js-content')
<script>

 $(function() {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        })
        $('[data-toggle="tooltip"]').tooltip()
        $('a.send-access').click(function(e) {
            let that = $(this)
            e.preventDefault()
            const swalWithBootstrapButtons = swal.mixin({
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
})

    swalWithBootstrapButtons({
        title: '@lang('Le prospect recevra ses accès. Continuer ?')',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: '@lang('Oui')',
        cancelButtonText: '@lang('Non')',
        
    }).then((result) => {
        if (result.value) {
            $('[data-toggle="tooltip"]').tooltip('hide')
                $.ajax({                        
                    url: that.attr('href'),
                    type: 'get'
                })
                .done(function () {
                        that.parents('tr').remove()
                })

            swalWithBootstrapButtons(
            'Envoyé!',
            'Un email a été envoyé au prospect.',
            'success'
            )
            
            
        } else if (
            // Read more about handling dismissals
            result.dismiss === swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons(
            'Annulé',
            'Envoi annulé',
            'error'
            )
        }
    })
        })
    })

</script>
@endsection