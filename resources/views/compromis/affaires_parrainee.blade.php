<div class="row"> 
       
    <div class="col-lg-12">
             
        <div class="card alert">
            <!-- table -->
    @php $grise =""@endphp
            
            <div class="card-body">
                    <div class="panel panel-info m-t-15" id="cont">
                            <div class="panel-body">

                    <div class="table-responsive" >
                        <table  id="example" class=" table table-striped table-hover dt-responsive display  "  >
                            <thead>
                                <tr>
                                       

                                    <th>@lang('Filleul')</th>
                                    <th>@lang('Numéro Mandat')</th>
                                    <th>@lang('Facture Styl')</th>
                                    <th>@lang('Vendeur')</th>
                                    <th>@lang('Comm')</th>
                                    {{-- <th>@lang('Date mandat')</th> --}}
                                    <th>@lang('Partage')</th>
                                    <th>@lang('Note honoraire')</th>

                                    <th>@lang('Action') </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($compromisParrain as $compromi)
                                @php 
                                $type_user = "";
                                    if(in_array($compromi->id, $compro_ids1) && in_array($compromi->id, $compro_ids2)){
                                        $type_user = "porteur";
                                        $key = array_search($compromi->id, $compro_ids1);
                                        unset($compro_ids1[$key]);                                        

                                    }elseif(!in_array($compromi->id, $compro_ids1) && in_array($compromi->id, $compro_ids2)){
                                        $type_user = "partage";
                                    }
                                @endphp
                                <tr>
                                    
                                @if($type_user == "")
                                    <td >
                                        @if(in_array($compromi->user_id,$fill_ids) )
                                        <span>{{$compromi->user->nom}} {{$compromi->user->prenom}}</span>
                                        @else 
                                        <span>{{$compromi->getPartage()->nom}} {{$compromi->getPartage()->prenom}}</span>
                                        @endif
                                    </td> 
                                @elseif($type_user == "porteur") 
                               
                                    <td >
                                        <span>{{$compromi->user->nom}} {{$compromi->user->prenom}}</span>
                                    </td> 
                                @elseif($type_user == "partage")
                                <td >
                                    <span>{{$compromi->getPartage()->nom}} {{$compromi->getPartage()->prenom}}</span>
                                </td> 
                                @endif
                                    
                                    
                                    <td  style="color: #e05555;{{$grise}}">
                                        <strong> {{$compromi->numero_mandat}}</strong> 
                                    </td>    
                                    <td  style="{{$grise}}">
                                        @if($compromi->je_porte_affaire == 1)
                                            @if($compromi->demande_facture < 2)
                                                <span class="color-warning">En attente..</span>                                            
                                            @else 
                                          
                                            <a class="color-info" title="Télécharger la facture stylimmo"  href="{{route('facture.telecharger_pdf_facture_stylimmo', Crypt::encrypt($compromi->id))}}"  class="  m-b-10 m-l-5 " id="ajouter">{{$compromi->getFactureStylimmo()->numero}}  <i class="ti-download"></i> </a>
                                                
                                            @endif
                                        @endif
                                    </td>        
                                   
                                    
                                    <td  style="">
                                        <span class="color-warning">{{$compromi->nom_vendeur}}</span>   
                                    </td>
                                    <td  style="{{$grise}}">

                                        @php
                                            $com = number_format($compromi->frais_agence / 1000, '2','.',',') . ' K';
                                            
                                        @endphp
                                        <span class="color-success">{{$com}} €</span>   
                                    </td>
                                 
                                    {{-- <td  style="{{$grise}}">
                                    {{$compromi->date_mandat->format('d/m/Y')}}   
                                    </td> --}}
                                    <td width="10%">

                                        @if($compromi->est_partage_agent == 0)
                                            <span class="badge badge-danger">Non</span>
                                        @else
                                            <span class="badge badge-success">Oui</span>
                                        @endif

                                    </td>        
                                                             
                                    <td> 


                                        @if ($compromi->demande_facture == 2)
                                            @if($compromi->getFactureStylimmo()->encaissee == 0)
                                            <span style="color: #0f0636">En attente... Facture STYL'IMMO non encaissée</span>   

                                            @else
                                                @if($type_user == "") 
                                                <a target="blank" href="{{route('facture.preparer_facture_honoraire_parrainage',Crypt::encrypt($compromi->id))}}" data-toggle="tooltip" title="@lang('Note honoraire  ')"><i class="large material-icons color-danger">insert_drive_file</i>
                                                @elseif($type_user == "porteur") 
                                                    <a target="blank" href="{{route('facture.preparer_facture_honoraire_parrainage',[Crypt::encrypt($compromi->id), $compromi->user_id])}}" data-toggle="tooltip" title="@lang('Note honoraire  ')"><i class="large material-icons color-danger">insert_drive_file</i>
                                                @elseif($type_user == "partage") 
                                                    <a target="blank" href="{{route('facture.preparer_facture_honoraire_parrainage',[Crypt::encrypt($compromi->id),$compromi->agent_id])}}" data-toggle="tooltip" title="@lang('Note honoraire  ')"><i class="large material-icons color-danger">insert_drive_file</i>
                                               
                                                @endif
                                                </a>
                                                @if(in_array($compromi->numero_mandat, $valide_compro_id) == false)                                                
                                                    <span class="color-danger">Vous ne remplissez pas les conditions</span>  
                                                @endif

                                            @endif
                                        
                                        @else
                                            <span class="color-primary">Facture STYL'IMMO non disponible</span>   
                                            
                                        @endif
                                        
                                    </td>
                                    <td width="15%">
                                            <a href="{{route('compromis.show',Crypt::encrypt($compromi->id))}}" data-toggle="tooltip" title="@lang('Détails  ')"><i class="large material-icons color-info">visibility</i></a>                                          
                                        
                                        {{-- @if (Auth()->user()->role == "mandataire")
                                            <span><a href="{{route('compromis.show',Crypt::encrypt($compromi->id))}}" data-toggle="tooltip" title="@lang('Modifier ') "><i class="large material-icons color-warning">edit</i></a></span>
                                            <span><a  href="{{route('compromis.archive',[$compromi->id,1])}}" class="delete" data-toggle="tooltip" title="@lang('Archiver ') {{ $compromi->nom }}"><i class="large material-icons color-danger">delete</i> </a></span>
                                        @endif --}}


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
