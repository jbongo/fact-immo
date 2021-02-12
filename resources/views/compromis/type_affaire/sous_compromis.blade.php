<div class="row"> 
       
    <div class="col-lg-12">
           
        <div class="card alert">
            <!-- table -->
          
            
            <div class="card-body">
                    <div class="panel panel-info ">
                            <div class="panel-body">

                    <div class="table-responsive" >
                        <table  id="example3" class=" table student-data-table  table-striped table-hover dt-responsive display    "  style="width:100%">
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
                                @foreach ($compromisSousCompromis as $compromi_sous_compro)
                                <tr>
                                    @if (Auth()->user()->role == "admin")
                                    <td  >
                                    <strong> <a href="{{route('switch_user',Crypt::encrypt($compromi_sous_compro->user->id) )}}" data-toggle="tooltip" title="@lang('Se connecter en tant que ') {{$compromi_sous_compro->user->nom}}">{{$compromi_sous_compro->user->nom}} {{$compromi_sous_compro->user->prenom}}<i style="font-size: 17px" class="material-icons color-success">person_pin</i></a> </strong> 
                                    </td> 
                                    @endif
                                    @if(Auth()->user()->role == "mandataire")
                                    <td >
                
                                        @if($compromi_sous_compro->je_porte_affaire == 0  || $compromi_sous_compro->agent_id == Auth()->user()->id)
                                            <span class="badge badge-danger">Non</span>
                                            {{-- @php  $grise = "background-color:#EDECE7"; @endphp --}}
                                        @else
                                            @php  $grise = ""; @endphp
                                            <span class="badge badge-success">Oui</span>
                                        @endif

                                    </td>  
                                    @endif 
                                    <td width="" >
                                        @if($compromi_sous_compro->getFactureStylimmo()!=null)
                                        <a class="color-info" title="Télécharger la facture stylimmo"  href="{{route('facture.telecharger_pdf_facture_stylimmo', Crypt::encrypt($compromi_sous_compro->getFactureStylimmo()->id))}}"  class="  m-b-10 m-l-5 " id="ajouter">{{$compromi_sous_compro->getFactureStylimmo()->numero}} <i class="ti-download"></i> </a>
                                        @else 
                                            <span class="color-warning">En attente ..</span>                                            
                                        @endif
                                    </td>
                                    <td  style="color: #e05555;{{$grise}}">
                                        <strong> {{$compromi_sous_compro->numero_mandat}}</strong> 
                                    </td> 
                                    <td >
                                        @php
                                            $mois = ['','Jan','Fév','Mar','Avr','Mai','Juin','Juil','Août','Sep','Oct','Nov','Déc'];
                                        @endphp 
                                        @if($compromi_sous_compro->date_vente != null)
                                            @if(strtotime($compromi_sous_compro->date_vente->format('d-m-Y')) > strtotime(date("d-m-Y")) || $compromi_sous_compro->demande_facture > 0)

                                            <strong> @if($compromi_sous_compro->date_vente != null) {{$mois[ (int)$compromi_sous_compro->date_vente->format("m")]}}-{{$compromi_sous_compro->date_vente->format("Y")}} @endif</strong> 
                                            @else 
                                            <strong>  <label  title="La date de vente prévue est dépassée. Vous pouvez la modifier dans votre affaire" style="background-color:#FF0633;color:white;visibility:visible;">@if($compromi_sous_compro->date_vente != null) {{$mois[ (int)$compromi_sous_compro->date_vente->format("m")]}}-{{$compromi_sous_compro->date_vente->format("Y")}} @endif !!! &nbsp;&nbsp;</label>  </strong> 
                                            @endif 
                                        @endif
                                    </td>    
                                    <td width="10%" style="{{$grise}}" >
                                        @if($compromi_sous_compro->charge == "Vendeur")
                                            <strong>{{ substr($compromi_sous_compro->nom_vendeur,0,20)}}</strong> 
                                        @else
                                            <strong>{{ substr($compromi_sous_compro->nom_acquereur,0,20)}}</strong> 
                                        @endif 
                                    </td>
                                    
                                    <td  style="{{$grise}}">
                                        @php
                                            $com = number_format($compromi_sous_compro->frais_agence / 1000, '2','.',',') . ' K';
                                        @endphp
                                        {{$com}} €
                                        {{-- {{number_format($compromi_sous_compro->frais_agence,'2','.',' ')}} €    --}}
                                    </td>
                                    {{-- <td  style="{{$grise}}">
                                   @if($compromi_sous_compro->date_mandat != null) {{$compromi_sous_compro->date_mandat->format('d/m/Y')}} @endif  
                                    </td> --}}
                                    <td width="10%">

                                        @if($compromi_sous_compro->est_partage_agent == 0)
                                            <span class="badge badge-danger">Non</span>
                                        @else
                                            @if(Auth()->user()->role == "admin")
                                            {{-- <span class="badge badge-success">Oui</span> --}}
                                            
                                            @if($compromi_sous_compro->getPartage()!= null)
                                                <strong> <a href="{{route('switch_user',Crypt::encrypt($compromi_sous_compro->getPartage()->id) )}}" data-toggle="tooltip" title="@lang('Se connecter en tant que ') {{$compromi_sous_compro->getPartage()->nom}}">{{$compromi_sous_compro->getPartage()->nom}} {{$compromi_sous_compro->getPartage()->prenom}}<i style="font-size: 17px" class="material-icons color-success">person_pin</i></a> </strong> 
                                            @else 
                                                <strong> <a  data-toggle="tooltip" title="@lang('Agence / Agent externe au réseau STYL\'IMMO') ">{{$compromi_sous_compro->nom_agent}} </a> </strong> 
                                            @endif
                                            @else 
                                                @if($compromi_sous_compro->getPartage() != null)
                                                    @if ($compromi_sous_compro->getPartage()->id == Auth()->user()->id)
                                                        <strong> <a >{{$compromi_sous_compro->user->nom}} {{$compromi_sous_compro->user->prenom}}</a> </strong>
                                                    @else 
                                                        <strong> <a >{{$compromi_sous_compro->getPartage()->nom}} {{$compromi_sous_compro->getPartage()->prenom}}</a> </strong>
                                                    @endif
                                                @else 
                                                    {{$compromi_sous_compro->nom_agent}}

                                                @endif

                                            @endif

                                        @endif

                                    </td>        
                                    <td  style="{{$grise}}">
                                        @if($compromi_sous_compro->je_porte_affaire == 1 && $compromi_sous_compro->agent_id != Auth()->user()->id)
                                            @if($compromi_sous_compro->demande_facture == 0 )
                                                @if($page_filleul == null)
                                                    {{-- <span><a class="btn btn-default" href="{{route('facture.demander_facture',Crypt::encrypt($compromi_sous_compro->id))}}" data-toggle="tooltip" title="@lang('')">demander facture styl</a> </span> --}}
                                    <span><a class="btn btn-default demander_facture" href="{{route('facture.demander_facture',Crypt::encrypt($compromi_sous_compro->id))}}" data-toggle="tooltip" date_vente="{{$compromi_sous_compro->date_vente->format('d/m/Y')}}" date-vente="{{$compromi_sous_compro->date_vente->format('m/d/Y')}}" title="@lang('')">demander facture styl</a> </span>

                                                @else
                                                    <span class="color-default">En attente de demande..</span>                                            
                                                @endif
                                            @elseif($compromi_sous_compro->demande_facture == 1)
                                                <span class="color-warning">En attente de validation..</span>                                            
                                            @else 
                                            {{-- <a href="{{route('facture.telecharger_pdf_facture_stylimmo', Crypt::encrypt($compromi_sous_compro->getFactureStylimmo()->id))}}"  class="btn btn-warning btn-flat btn-addon  m-b-10 m-l-5 " id="ajouter"><i class="ti-download"></i>Télécharger</a> --}}
                                            @endif
                                        @endif
                                    </td>                                
                                  
                                    <td width="15%">
                                            <a href="{{route('compromis.show',Crypt::encrypt($compromi_sous_compro->id))}}" data-toggle="tooltip" title="@lang('Détails  ')"><i class="large material-icons color-info">visibility</i></a> 
                                            @if ($compromi_sous_compro->agent_id != Auth()->user()->id && ($compromi_sous_compro->facture_stylimmo_valide == false || Auth()->user()->role =="admin") )
                                                @if($page_filleul == null)    
                                                    <span><a href="{{route('compromis.show',Crypt::encrypt($compromi_sous_compro->id))}}" data-toggle="tooltip" title="@lang('Modifier ') "><i class="large material-icons color-warning">edit</i></a></span>
                                                    {{-- <span><a  href="{{route('compromis.archive',[$compromi_sous_compro->id,1])}}" class="delete" data-toggle="tooltip" title="@lang('Archiver ') {{ $compromi_sous_compro->nom }}"><i class="large material-icons color-danger">thumb_down_alt</i> </a></span> --}}
                                                @endif
                                            @endif
                                            @if($page_filleul == null)
                                                @if ($compromi_sous_compro->cloture_affaire == 0 && $compromi_sous_compro->demande_facture == 2 && $compromi_sous_compro->agent_id != Auth()->user()->id)
                                                    <a class="cloturer" href="{{route('compromis.cloturer',Crypt::encrypt($compromi_sous_compro->id))}}" data-toggle="tooltip" data-mandat="{{$compromi_sous_compro->numero_mandat}}" title="@lang('Réitérer l\'affaire  ')"><i class="large material-icons color-success">thumb_up_alt</i></a> 
                                                @elseif($compromi_sous_compro->cloture_affaire == 1  )
                                                    @if(Auth()->user()->role != "admin"  )
                                                        @if ($compromi_sous_compro->je_porte_affaire == 0  || $compromi_sous_compro->agent_id == Auth()->user()->id || ($compromi_sous_compro->je_porte_affaire == 1 && $compromi_sous_compro->est_partage_agent == 1) )
                                                        <a target="blank" href="{{route('facture.preparer_facture_honoraire_partage',Crypt::encrypt($compromi_sous_compro->id))}}" data-toggle="tooltip" title="@lang('Note honoraire  ')"><i class="large material-icons color-danger">insert_drive_file</i></a> 

                                                        @else 
                                                        <a target="blank" href="{{route('facture.preparer_facture_honoraire',Crypt::encrypt($compromi_sous_compro->id))}}" data-toggle="tooltip" title="@lang('Note honoraire  ')"><i class="large material-icons color-danger">insert_drive_file</i></a> 
                                                            
                                                        @endif
                                                    @endif
                                                @endif
                                            @endif
                                            
                                        @if ($compromi_sous_compro->agent_id != Auth()->user()->id && ($compromi_sous_compro->facture_stylimmo_valide == false || Auth()->user()->role =="admin") )
                                            @if($page_filleul == null)    
                                            {{-- <span><a href="{{route('compromis.show',Crypt::encrypt($compromi_sous_compro->id))}}" data-toggle="tooltip" title="@lang('Modifier ') "><i class="large material-icons color-warning">edit</i></a></span> --}}
                                                <span><a data-target="#myModal2"  data-toggle="modal" id="{{$compromi_sous_compro->id}}"  class="archiver" href="" data-toggle="tooltip" title="@lang('Archiver ') {{ $compromi_sous_compro->nom }}"><i class="large material-icons color-danger">thumb_down_alt</i> </a></span>
                                            @endif
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