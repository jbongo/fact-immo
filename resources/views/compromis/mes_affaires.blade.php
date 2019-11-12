<div class="row"> 
       
    <div class="col-lg-12">
           
        <div class="card alert">
            <!-- table -->
          
            
            <div class="card-body">
                    <div class="panel panel-info ">
                            <div class="panel-body">

                    <div class="table-responsive" style="overflow-x: inherit !important;">
                        <table  id="example" class=" table student-data-table  m-t-20 "  style="width:100%">
                            <thead>
                                <tr>
                                        @if (Auth()->user()->role == "admin")
                                    <th>@lang('Mandataire')</th>
                                @endif

                                    <th>@lang('porte l\'affaire')</th>
                                    <th>@lang('Numéro Mandat')</th>
                                    <th>@lang('Description bien')</th>
                                    <th>@lang('Net Vendeur')</th>
                                    <th>@lang('Date Mandat')</th>
                                    <th>@lang('Partage avec Agent/Agence')</th>
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
                                    <strong>{{$compromi->user->nom}} {{$compromi->user->prenom}}</strong> 
                                    </td> 
                                    @endif
                                    <td >
                
                                        @if($compromi->je_porte_affaire == 0  || $compromi->agent_id == auth::user()->id)
                                            <span class="badge badge-danger">Non</span>
                                            {{-- @php  $grise = "background-color:#EDECE7"; @endphp --}}
                                        @else
                                            @php  $grise = ""; @endphp
                                            <span class="badge badge-success">Oui</span>
                                        @endif

                                    </td>   
                                    <td  style="color: #e05555;{{$grise}}">
                                        <strong> {{$compromi->numero_mandat}}</strong> 
                                    </td>     
                                    <td width="15%" style="{{$grise}}" >
                                        <strong>{{ substr($compromi->description_bien,0,40)}}...</strong> 
                                    </td>
                                    
                                    <td  style="{{$grise}}">
                                        {{number_format($compromi->net_vendeur,'2','.',' ')}}   
                                    </td>
                                    <td  style="{{$grise}}">
                                    {{$compromi->date_mandat->format('d/m/Y')}}   
                                    </td>
                                    <td width="10%">

                                        @if($compromi->est_partage_agent == 0)
                                            <span class="badge badge-danger">Non</span>
                                        @else
                                            <span class="badge badge-success">Oui</span>
                                        @endif

                                    </td>        
                                    <td  style="{{$grise}}">
                                        @if($compromi->je_porte_affaire == 1 && $compromi->agent_id != auth::user()->id)
                                            @if($compromi->demande_facture == 0 )
                                                <span><a class="btn btn-default" href="{{route('facture.demander_facture',Crypt::encrypt($compromi->id))}}" data-toggle="tooltip" title="@lang(' ddddd')">demander facture styl</a> </span>
                                            @elseif($compromi->demande_facture == 1)
                                                <span class="color-warning">En attente de validation..</span>                                            
                                            @else 
                                            <a href="{{route('facture.telecharger_pdf_facture_stylimmo', Crypt::encrypt($compromi->id))}}"  class="btn btn-warning btn-flat btn-addon  m-b-10 m-l-5 " id="ajouter"><i class="ti-download"></i>Télécharger</a>
                                            @endif
                                        @endif
                                    </td>                                
                                  
                                    <td width="15%">
                                            <a href="{{route('compromis.show',Crypt::encrypt($compromi->id))}}" data-toggle="tooltip" title="@lang('Détails  ')"><i class="large material-icons color-info">visibility</i></a> 
                                            @if ($compromi->cloture_affaire == 0 && $compromi->demande_facture == 2 && $compromi->agent_id != auth::user()->id)
                                    <a class="cloturer" href="{{route('compromis.cloturer',Crypt::encrypt($compromi->id))}}" data-toggle="tooltip" data-mandat="{{$compromi->numero_mandat}}" title="@lang('Cloturer l\'affaire  ')"><i class="large material-icons color-danger">clear</i></a> 
                                            @elseif($compromi->cloture_affaire == 1  )
                                                @if ($compromi->je_porte_affaire == 0  || $compromi->agent_id == auth::user()->id || ($compromi->je_porte_affaire == 1 && $compromi->est_partage_agent == 1) )
                                                <a target="blank" href="{{route('facture.preparer_facture_honoraire_partage',Crypt::encrypt($compromi->id))}}" data-toggle="tooltip" title="@lang('Note honoraire  ')"><i class="large material-icons color-danger">insert_drive_file</i></a> 

                                                @else 
                                                <a target="blank" href="{{route('facture.preparer_facture_honoraire',Crypt::encrypt($compromi->id))}}" data-toggle="tooltip" title="@lang('Note honoraire  ')"><i class="large material-icons color-danger">insert_drive_file</i></a> 
                                                    
                                                @endif
                                            @endif
                                            
                                        @if ($compromi->agent_id != auth::user()->id && $compromi->facture_stylimmo_valide == false)
                                            <span><a href="{{route('compromis.show',Crypt::encrypt($compromi->id))}}" data-toggle="tooltip" title="@lang('Modifier ') "><i class="large material-icons color-warning">edit</i></a></span>
                                            <span><a  href="{{route('compromis.archive',[$compromi->id,1])}}" class="delete" data-toggle="tooltip" title="@lang('Archiver ') {{ $compromi->nom }}"><i class="large material-icons color-danger">delete</i> </a></span>
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