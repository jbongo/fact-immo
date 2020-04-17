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
                                @foreach ($compromisPrevisionnel as $compromi_previ)
                                <tr>
                                    @if (Auth()->user()->role == "admin")
                                    <td  >
                                    <strong> <a href="{{route('switch_user',Crypt::encrypt($compromi_previ->user->id) )}}" data-toggle="tooltip" title="@lang('Se connecter en tant que ') {{$compromi_previ->user->nom}}">{{$compromi_previ->user->nom}} {{$compromi_previ->user->prenom}}<i style="font-size: 17px" class="material-icons color-success">person_pin</i></a> </strong> 
                                    </td> 
                                    @endif
                                    @if(Auth()->user()->role == "mandataire")
                                    <td >
                
                                        @if($compromi_previ->je_porte_affaire == 0  || $compromi_previ->agent_id == Auth()->user()->id)
                                            <span class="badge badge-danger">Non</span>
                                            {{-- @php  $grise = "background-color:#EDECE7"; @endphp --}}
                                        @else
                                            @php  $grise = ""; @endphp
                                            <span class="badge badge-success">Oui</span>
                                        @endif

                                    </td>  
                                    @endif 
                                    <td width="" >
                                        @if($compromi_previ->getFactureStylimmo()!=null)
                                        <a class="color-info" title="Télécharger la facture stylimmo"  href="{{route('facture.telecharger_pdf_facture_stylimmo', Crypt::encrypt($compromi_previ->id))}}"  class="  m-b-10 m-l-5 " id="ajouter">{{$compromi_previ->getFactureStylimmo()->numero}} <i class="ti-download"></i> </a>
                                        @else 
                                            <span class="color-warning">En attente ..</span>                                            
                                        @endif
                                    </td>
                                    <td  style="color: #e05555;{{$grise}}">
                                        <strong> {{$compromi_previ->numero_mandat}}</strong> 
                                    </td> 
                                    <td >
                                        @php
                                            $mois = ['','Jan','Fév','Mar','Avr','Mai','Juin','Juil','Août','Sep','Oct','Nov','Déc'];
                                        @endphp 
                                        @if($compromi_previ->date_vente != null)
                                            @if(strtotime($compromi_previ->date_vente->format('d-m-Y')) > strtotime(date("d-m-Y")) || $compromi_previ->demande_facture > 0)

                                            <strong> @if($compromi_previ->date_vente != null) {{$mois[ (int)$compromi_previ->date_vente->format("m")]}}-{{$compromi_previ->date_vente->format("Y")}} @endif</strong> 
                                            @else 
                                            <strong>  <label  title="La date de vente prévue est dépassée. Vous pouvez la modifier dans votre affaire" style="background-color:#FF0633;color:white;visibility:visible;">@if($compromi_previ->date_vente != null) {{$mois[ (int)$compromi_previ->date_vente->format("m")]}}-{{$compromi_previ->date_vente->format("Y")}} @endif !!! &nbsp;&nbsp;</label>  </strong> 
                                            @endif 
                                        @endif
                                    </td>    
                                    <td width="15%" style="{{$grise}}" >
                                        @if($compromi_previ->charge == "Vendeur")
                                            <strong>{{ substr($compromi_previ->nom_vendeur,0,50)}}</strong> 
                                        @else
                                            <strong>{{ substr($compromi_previ->nom_acquereur,0,50)}}</strong> 
                                        @endif 
                                    </td>
                                    
                                    <td  style="{{$grise}}">
                                        @php
                                            $com = ($compromi_previ->frais_agence / 1000) . ' K';
                                        
                                        @endphp
                                        {{$com}} €
                                        {{-- {{number_format($compromi_previ->frais_agence,'2','.',' ')}} €    --}}
                                    </td>
                                    {{-- <td  style="{{$grise}}">
                                   @if($compromi_previ->date_mandat != null) {{$compromi_previ->date_mandat->format('d/m/Y')}} @endif  
                                    </td> --}}
                                    <td width="10%">

                                        @if($compromi_previ->est_partage_agent == 0)
                                            <span class="badge badge-danger">Non</span>
                                        @else
                                            @if(Auth()->user()->role == "admin")
                                            {{-- <span class="badge badge-success">Oui</span> --}}
                                            
                                            @if($compromi_previ->getPartage()!= null)
                                                <strong> <a href="{{route('switch_user',Crypt::encrypt($compromi_previ->getPartage()->id) )}}" data-toggle="tooltip" title="@lang('Se connecter en tant que ') {{$compromi_previ->getPartage()->nom}}">{{$compromi_previ->getPartage()->nom}} {{$compromi_previ->getPartage()->prenom}}<i style="font-size: 17px" class="material-icons color-success">person_pin</i></a> </strong> 
                                            @else 
                                                <strong> <a  data-toggle="tooltip" title="@lang('Agence / Agent externe au réseau STYL\'IMMO') ">{{$compromi_previ->nom_agent}} </a> </strong> 
                                            @endif
                                            @else 
                                                @if($compromi_previ->getPartage() != null)
                                                    @if ($compromi_previ->getPartage()->id == Auth()->user()->id)
                                                        <strong> <a >{{$compromi_previ->user->nom}} {{$compromi_previ->user->prenom}}</a> </strong>
                                                    @else 
                                                        <strong> <a >{{$compromi_previ->getPartage()->nom}} {{$compromi_previ->getPartage()->prenom}}</a> </strong>
                                                    @endif
                                                @else 
                                                    {{$compromi_previ->nom_agent}}

                                                @endif

                                            @endif

                                        @endif

                                    </td>        
                                    <td  style="{{$grise}}">
                                        @if($compromi_previ->je_porte_affaire == 1 && $compromi_previ->agent_id != Auth()->user()->id)
                                            @if($compromi_previ->demande_facture == 0 )
                                                <span><a class="btn btn-default" href="{{route('facture.demander_facture',Crypt::encrypt($compromi_previ->id))}}" data-toggle="tooltip" title="@lang(' ddddd')">demander facture styl</a> </span>
                                            @elseif($compromi_previ->demande_facture == 1)
                                                <span class="color-warning">En attente de validation..</span>                                            
                                            @else 
                                            <a href="{{route('facture.telecharger_pdf_facture_stylimmo', Crypt::encrypt($compromi_previ->id))}}"  class="btn btn-warning btn-flat btn-addon  m-b-10 m-l-5 " id="ajouter"><i class="ti-download"></i>Télécharger</a>
                                            @endif
                                        @endif
                                    </td>                                
                                  
                                    <td width="15%">
                                            <a href="{{route('compromis.show',Crypt::encrypt($compromi_previ->id))}}" data-toggle="tooltip" title="@lang('Détails  ')"><i class="large material-icons color-info">visibility</i></a> 
                                            @if ($compromi_previ->cloture_affaire == 0 && $compromi_previ->demande_facture == 2 && $compromi_previ->agent_id != Auth()->user()->id)
                                    <a class="cloturer" href="{{route('compromis.cloturer',Crypt::encrypt($compromi_previ->id))}}" data-toggle="tooltip" data-mandat="{{$compromi_previ->numero_mandat}}" title="@lang('Clôturer l\'affaire  ')"><i class="large material-icons color-danger">clear</i></a> 
                                            @elseif($compromi_previ->cloture_affaire == 1  )
                                                @if(Auth()->user()->role != "admin"  )
                                                    @if ($compromi_previ->je_porte_affaire == 0  || $compromi_previ->agent_id == Auth()->user()->id || ($compromi_previ->je_porte_affaire == 1 && $compromi_previ->est_partage_agent == 1) )
                                                    <a target="blank" href="{{route('facture.preparer_facture_honoraire_partage',Crypt::encrypt($compromi_previ->id))}}" data-toggle="tooltip" title="@lang('Note honoraire  ')"><i class="large material-icons color-danger">insert_drive_file</i></a> 

                                                    @else 
                                                    <a target="blank" href="{{route('facture.preparer_facture_honoraire',Crypt::encrypt($compromi_previ->id))}}" data-toggle="tooltip" title="@lang('Note honoraire  ')"><i class="large material-icons color-danger">insert_drive_file</i></a> 
                                                        
                                                    @endif
                                                @endif
                                            @endif
                                            
                                        @if ($compromi_previ->agent_id != Auth()->user()->id && ($compromi_previ->facture_stylimmo_valide == false || Auth()->user()->role =="admin") )
                                            <span><a href="{{route('compromis.show',Crypt::encrypt($compromi_previ->id))}}" data-toggle="tooltip" title="@lang('Modifier ') "><i class="large material-icons color-warning">edit</i></a></span>
                                            <span><a  href="{{route('compromis.archive',[$compromi_previ->id,1])}}" class="delete" data-toggle="tooltip" title="@lang('Archiver ') {{ $compromi_previ->nom }}"><i class="large material-icons color-danger">delete</i> </a></span>
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