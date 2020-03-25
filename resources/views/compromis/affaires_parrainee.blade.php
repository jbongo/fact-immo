<div class="row"> 
       
    <div class="col-lg-12">
             
        <div class="card alert">
            <!-- table -->
    @php $grise =""@endphp
            
            <div class="card-body">
                    <div class="panel panel-info m-t-15" id="cont">
                            <div class="panel-body">

                    <div class="table-responsive" >
                        <table  id="example1" class=" table table-striped table-hover dt-responsive display  "  >
                            <thead>
                                <tr>
                                       

                                    <th>@lang('Filleul')</th>
                                    <th>@lang('Numéro Mandat')</th>
                                    <th>@lang('Vendeur')</th>
                                    <th>@lang('Commission')</th>
                                    {{-- <th>@lang('Date mandat')</th> --}}
                                    <th>@lang('Partage')</th>
                                    <th>@lang('Facture Styl')</th>
                                    <th>@lang('Note honoraire')</th>

                                    <th>@lang('Action') </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($compromisParrain as $compromi)
                                <tr>
                                    
                                    <td >
                                        @if(in_array($compromi->user_id,$fill_ids) )
                                        <span>{{$compromi->user->nom}} {{$compromi->user->prenom}}</span>
                                        @else 
                                        <span>{{$compromi->getPartage()->nom}} {{$compromi->getPartage()->prenom}}</span>
                                        @endif
                                    </td>   
                                    <td  style="color: #e05555;{{$grise}}">
                                        <strong> {{$compromi->numero_mandat}}</strong> 
                                    </td>     
                                   
                                    
                                    <td  style="">
                                        <span class="color-warning">{{$compromi->nom_vendeur}}</span>   
                                    </td>
                                    <td  style="{{$grise}}">
                                        <span class="color-success">{{number_format($compromi->frais_agence,'2','.',' ')}} €</span>   
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
                                    <td  style="{{$grise}}">
                                        @if($compromi->je_porte_affaire == 1)
                                            @if($compromi->demande_facture < 2)
                                                <span class="color-warning">En attente..</span>                                            
                                            @else 
                                            <a href="{{route('facture.telecharger_pdf_facture_stylimmo', Crypt::encrypt($compromi->id))}}"  class="btn btn-warning btn-flat btn-addon  m-b-10 m-l-5 " id="ajouter"><i class="ti-download"></i>Télécharger</a>
                                            @endif
                                        @endif
                                    </td>                                
                                    <td> 
                                            @if ($compromi->cloture_affaire == 0 && $compromi->demande_facture == 2)
                                                <span class="color-success">En attente... Votre filleul doit cloturer l'affaire</span>   
                                            {{-- @elseif($compromi->cloture_affaire == 1 && ($compromi->facture_honoraire_cree == true || $compromi->facture_honoraire_partage_cree == true)) --}}
                                            @elseif($compromi->cloture_affaire == 0 && $compromi->demande_facture < 2)
                                                <span class="color-primary">En attente de la facture stylimmo</span>   

                                            @elseif($compromi->cloture_affaire == 1 /* && ($compromi->facture_honoraire_cree == true || $compromi->facture_honoraire_partage_cree == true)*/)
                                                <a target="blank" href="{{route('facture.preparer_facture_honoraire_parrainage',Crypt::encrypt($compromi->id))}}" data-toggle="tooltip" title="@lang('Note honoraire  ')"><i class="large material-icons color-danger">insert_drive_file</i></a> 
                                            {{-- @elseif($compromi->cloture_affaire == 1 && ($compromi->facture_honoraire_cree == false && $compromi->facture_honoraire_partage_cree ==  false) )
                                                <span class="color-success">En attente de la création de note honoraire (commission agence)</span>       --}}
                                                @if(in_array($compromi->numero_mandat, $valide_compro_id) == false)                                                
                                                    <span class="color-danger">Vous ne remplissez pas les conditions</span>  
                                                @endif
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