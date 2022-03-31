<div class="row"> 
       
    <div class="col-lg-12">
           
        <div class="card alert">
            <!-- table -->
          
            
            <div class="card-body">
                    <div class="panel panel-info ">
                            <div class="panel-body">

                    <div class="table-responsive" >
                        <table  id="example0" class="display nowrap"  style="width:100%" >

                            <thead>
                                {{-- table table-striped table-hover dt-responsive display nowrap --}}
                                <tr>
                                    @if (Auth()->user()->role == "admin")
                                    <th>@lang('Mandataire')</th>
                                    @endif
                                    @if(Auth()->user()->role == "mandataire")
                                    <th>@lang('porte l\'affaire')</th>
                                    @endif
                                    <th>@lang('Numero Styl')</th>
                                    <th>@lang('Mandat')</th>
                                    <th>@lang('Date vente')</th>
                                    <th>@lang('Charge')</th>
                                    <th>@lang('Comm')</th>
                                    {{-- <th>@lang('Date Mandat')</th> --}}
                                    <th>@lang('Partage')</th>
                                    <th>@lang('Facture Styl')</th>

                                    <th>@lang('Action') </th>
                                </tr>
                            </thead>
                            @php  $grise = ""; @endphp
                            <tbody>
                                @foreach ($compromis as $compromi)
                                <tr>
                                    @if (Auth()->user()->role == "admin")
                                    <td  >
                                    <strong> <a href="{{route('switch_user',Crypt::encrypt($compromi->user->id) )}}" data-toggle="tooltip" title="@lang('Se connecter en tant que ') {{$compromi->user->nom}}">{{$compromi->user->nom}} {{$compromi->user->prenom}}<i style="font-size: 17px" class="material-icons color-success">person_pin</i></a> </strong> 
                                    </td> 
                                    @endif
                                    @if(Auth()->user()->role == "mandataire")
                                    <td >
                
                                        @if($compromi->je_porte_affaire == 0  || $compromi->agent_id == Auth()->user()->id)
                                            <span class="badge badge-danger">Non</span>
                                            {{-- @php  $grise = "background-color:#EDECE7"; @endphp --}}
                                        @else
                                            @php  $grise = ""; @endphp
                                            <span class="badge badge-success">Oui</span>
                                        @endif

                                    </td>  
                                    @endif 
                                    <td width="" >
                                        @if($compromi->getFactureStylimmo()!=null)
                                        <a class="color-info" title="Télécharger la facture stylimmo"  href="{{route('facture.telecharger_pdf_facture_stylimmo', Crypt::encrypt($compromi->getFactureStylimmo()->id))}}"  class="  m-b-10 m-l-5 " id="ajouter">{{$compromi->getFactureStylimmo()->numero}} <i class="ti-download"></i> </a>
                                        @else 
                                            <span class="color-warning">En attente ..</span>                                            
                                        @endif
                                    </td>
                                    <td  style="color: #e05555;{{$grise}}">
                                        <strong> {{$compromi->numero_mandat}}</strong> 
                                    </td> 
                                    <td >
                                        @php
                                            $mois = ['','Jan','Fév','Mar','Avr','Mai','Juin','Juil','Août','Sep','Oct','Nov','Déc'];
                                        @endphp 
                                        @if($compromi->date_vente != null)
                                            @if(strtotime($compromi->date_vente->format('d-m-Y')) > strtotime(date("d-m-Y")) || $compromi->demande_facture > 0)

                                            <strong> @if($compromi->date_vente != null) {{$mois[ (int)$compromi->date_vente->format("m")]}} - {{$compromi->date_vente->format("Y")}} @endif</strong> 
                                            @else 
                                            <strong>  <label title="La date de vente prévue est dépassée. Vous pouvez la modifier dans votre affaire" style="background-color:#FF0633;color:white;visibility:visible;">@if($compromi->date_vente != null) {{$mois[ (int)$compromi->date_vente->format("m")]}} - {{$compromi->date_vente->format("Y")}} @endif !!! &nbsp;&nbsp;</label>  </strong> 
                                            @endif 
                                        @endif
                                    </td>    
                                    <td width="10%" style="{{$grise}}" >
                                        @if($compromi->charge == "Vendeur")
                                            <strong>{{ substr($compromi->nom_vendeur,0,20)}}</strong> 
                                        @else
                                            <strong>{{ substr($compromi->nom_acquereur,0,20)}}</strong> 
                                        @endif 
                                    </td>
                                    
                                    <td  style="{{$grise}}">
                                        @php
                                            $com = number_format($compromi->frais_agence() / 1000, '2','.',',') . ' K';
                                        @endphp
                                        {{$com}} €
                                        {{-- {{number_format($compromi->frais_agence,'2','.',' ')}} €    --}}
                                    </td>
                                    {{-- <td  style="{{$grise}}">
                                   @if($compromi->date_mandat != null) {{$compromi->date_mandat->format('d/m/Y')}} @endif  
                                    </td> --}}
                                    <td width="10%">

                                        @if($compromi->est_partage_agent == 0)
                                            <span class="badge badge-danger">Non</span>
                                        @else
                                            @if(Auth()->user()->role == "admin")
                                            {{-- <span class="badge badge-success">Oui</span> --}}
                                            
                                            @if($compromi->getPartage()!= null && $compromi->partage_reseau == 1) 
                                                <strong> <a href="{{route('switch_user',Crypt::encrypt($compromi->getPartage()->id) )}}" data-toggle="tooltip" title="@lang('Se connecter en tant que ') {{$compromi->getPartage()->nom}}">{{$compromi->getPartage()->nom}} {{$compromi->getPartage()->prenom}}<i style="font-size: 17px" class="material-icons color-success">person_pin</i></a> </strong> 
                                            @else 
                                                <strong> <a  data-toggle="tooltip" title="@lang('Agence / Agent externe au réseau STYL\'IMMO') ">{{$compromi->nom_agent}} </a> </strong> 
                                            @endif
                                            @else 
                                                @if($compromi->getPartage() != null)
                                                    @if ($compromi->getPartage()->id == Auth()->user()->id)
                                                        <strong> <a >{{$compromi->user->nom}} {{$compromi->user->prenom}}</a> </strong>
                                                    @else 
                                                        <strong> <a >{{$compromi->getPartage()->nom}} {{$compromi->getPartage()->prenom}}</a> </strong>
                                                    @endif
                                                @else 
                                                    {{$compromi->nom_agent}}

                                                @endif

                                            @endif

                                        @endif

                                    </td>        
                                    <td  style="{{$grise}}">
                                        @if($compromi->je_porte_affaire == 1 && $compromi->agent_id != Auth()->user()->id)
                                            @if($compromi->demande_facture == 0 )
                                                <span><a class="btn btn-default" href="{{route('facture.demander_facture',Crypt::encrypt($compromi->id))}}" data-toggle="tooltip" title="@lang(' ')">demander facture styl</a> </span>
                                            @elseif($compromi->demande_facture == 1)
                                                <span class="color-warning">En attente de validation..</span>                                            
                                            @else 
                                            <a href="{{route('facture.telecharger_pdf_facture_stylimmo', Crypt::encrypt($compromi->getFactureStylimmo()->id))}}"  class="btn btn-warning btn-flat btn-addon  m-b-10 m-l-5 " id="ajouter"><i class="ti-download"></i>Télécharger</a>
                                            @endif
                                        @endif
                                    </td>                                
                                  
                                    <td width="15%">
                                            <a href="{{route('compromis.show',Crypt::encrypt($compromi->id))}}" data-toggle="tooltip" title="@lang('Détails  ')"><i class="large material-icons color-info">visibility</i></a> 
                                            @if ($compromi->agent_id != Auth()->user()->id && ($compromi->facture_stylimmo_valide == false || Auth()->user()->role =="admin") )
                                                <span><a href="{{route('compromis.show',Crypt::encrypt($compromi->id))}}" data-toggle="tooltip" title="@lang('Modifier ') "><i class="large material-icons color-warning">edit</i></a></span>
                                                {{-- <span><a data-toggle="modal" id="{{$compromi->id}}" data-target="#myModal2" href=""  class="archiver" data-toggle="tooltip" title="@lang('Archiver ') {{ $compromi->nom }}"><i class="large material-icons color-danger">thumb_down_alt</i> </a></span> --}}
                                            @endif
                                            
                                            @if ($compromi->cloture_affaire == 0 && $compromi->demande_facture == 2 && $compromi->agent_id != Auth()->user()->id)
                                    <a class="cloturer" href="{{route('compromis.cloturer',Crypt::encrypt($compromi->id))}}" data-toggle="tooltip" data-mandat="{{$compromi->numero_mandat}}" title="@lang('Réitérer l\'affaire  ')"> <img src="{{asset('images/logo-notaire.png')}}" width="25px" height="30px" alt=""> <!-- <i class="large material-icons color-success ">thumb_up_alt</i> --> </a> 
                                            @elseif($compromi->cloture_affaire == 1  )
                                                @if(Auth()->user()->role != "admin"  )
                                                    
                                                    
                                                    @if ($compromi->facture_honoraire_partage_cree == 1  || $compromi->facture_honoraire_partage_porteur_cree == 1  )
                                                        <a target="blank" href="{{route('facture.preparer_facture_honoraire_partage',Crypt::encrypt($compromi->id))}}" data-toggle="tooltip" title="@lang('Note honoraire  ')"><i class="large material-icons color-danger ">insert_drive_file</i></a> 
        
                                                    @elseif($compromi->facture_honoraire_cree == 1  || $compromi->facture_honoraire_partage_externe_cree == 1  ) 
                                                        <a target="blank" href="{{route('facture.preparer_facture_honoraire',Crypt::encrypt($compromi->id))}}" data-toggle="tooltip" title="@lang('Note honoraire  ')"><i class="large material-icons color-danger">insert_drive_file</i></a> 
                                                    @else 
                                                         @if ($compromi->je_porte_affaire == 0  || $compromi->agent_id == Auth()->user()->id || ($compromi->je_porte_affaire == 1 && $compromi->est_partage_agent == 1) )
                                                            <a target="blank" href="{{route('facture.preparer_facture_honoraire_partage',Crypt::encrypt($compromi->id))}}" data-toggle="tooltip" title="@lang('Note honoraire  ')"><i class="large material-icons color-danger ">insert_drive_file</i></a> 

                                                        @else 
                                                            <a target="blank" href="{{route('facture.preparer_facture_honoraire',Crypt::encrypt($compromi->id))}}" data-toggle="tooltip" title="@lang('Note honoraire  ')"><i class="large material-icons color-danger">insert_drive_file</i></a> 
                                                            
                                                        @endif
                                                    @endif
                                                    
                                                    
                                                    {{-- @if ($compromi->je_porte_affaire == 0  || $compromi->agent_id == Auth()->user()->id || ($compromi->je_porte_affaire == 1 && $compromi->est_partage_agent == 1) )
                                                        <a target="blank" href="{{route('facture.preparer_facture_honoraire_partage',Crypt::encrypt($compromi->id))}}" data-toggle="tooltip" title="@lang('Note honoraire  ')"><i class="large material-icons color-danger ">insert_drive_file</i></a> 

                                                    @else 
                                                        <a target="blank" href="{{route('facture.preparer_facture_honoraire',Crypt::encrypt($compromi->id))}}" data-toggle="tooltip" title="@lang('Note honoraire  ')"><i class="large material-icons color-danger">insert_drive_file</i></a> 
                                                        
                                                    @endif
                                                     --}}
                                                    
                                                    
                                                    
                                                    
                                                @endif
                                            @endif
                                            @if ($compromi->agent_id != Auth()->user()->id && ($compromi->facture_stylimmo_valide == false || Auth()->user()->role =="admin") )
                                                {{-- <span><a href="{{route('compromis.show',Crypt::encrypt($compromi->id))}}" data-toggle="tooltip" title="@lang('Modifier ') "><i class="large material-icons color-warning">edit</i></a></span> --}}
                                                <span><a data-toggle="modal" id="{{$compromi->id}}" data-target="#myModal2" href=""  class="archiver" data-toggle="tooltip" title="@lang('Archiver ') {{ $compromi->nom }}"><i class="large material-icons color-danger">thumb_down_alt</i> </a></span>
                                            @endif
                                            
                                        
                                    </td>
                                </tr>
                        @endforeach
                          </tbody>
                        </table>
                    </div>
                </div>
            </div>

                </div>
            <!-- end table -->
        </div>
    </div>
</div>


