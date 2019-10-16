<div class="row"> 
       
    <div class="col-lg-12">
             
        <div class="card alert">
            <!-- table -->
    @php $grise =""@endphp
            
            <div class="card-body">
                    <div class="panel panel-info m-t-15" id="cont">
                            <div class="panel-body">

                    <div class="table-responsive" style="overflow-x: inherit !important;">
                        <table  id="example1" class=" table student-data-table  m-t-20 "  style="width:100%">
                            <thead>
                                <tr>
                                       

                                    <th>@lang('Filleul')</th>
                                    <th>@lang('Numéro Mandat')</th>
                                    <th>@lang('Description bien')</th>
                                    <th>@lang('Net Vendeur')</th>
                                    <th>@lang('Frais agence')</th>
                                    <th>@lang('Date vente')</th>
                                    <th>@lang('Partage avec Agent/Agence')</th>
                                    <th>@lang('Facture Styl')</th>
                                    <th>@lang('Note honoraire')</th>

                                    <th>@lang('Action') </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($compromisParrain as $compromi)
                                <tr>
                                       
                                    <td >
                                        <span>{{$compromi->user->nom}} {{$compromi->user->prenom}}</span>
                                    </td>   
                                    <td  style="color: #e05555;{{$grise}}">
                                        <strong> {{$compromi->numero_mandat}}</strong> 
                                    </td>     
                                    <td width="15%" style="{{$grise}}" >
                                        <strong>{{$compromi->description_bien}}</strong> 
                                    </td>
                                    
                                    <td  style="{{$grise}}">
                                        <span class="color-warning">{{$compromi->net_vendeur}}</span>   
                                    </td>
                                    <td  style="{{$grise}}">
                                        <span class="color-success">{{$compromi->frais_agence}}</span>   
                                    </td>
                                 
                                    <td  style="{{$grise}}">
                                    {{$compromi->date_mandat}}   
                                    </td>
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
                                    <td >
                                        @if ($compromi->cloture_affaire == 0 && $compromi->demande_facture == 2)
                                            <span class="color-success">En attente de cloture de l'affaire</span>   
                                        @elseif($compromi->cloture_affaire == 1 && $compromi->facture_honoraire_cree == 0 )
                                            <a target="blank" href="{{route('facture.preparer_facture_honoraire',Crypt::encrypt($compromi->id))}}" data-toggle="tooltip" title="@lang('Note honoraire  ')"><i class="large material-icons color-danger">insert_drive_file</i></a> 
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