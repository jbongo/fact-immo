
                
                <div class="card-body">
                    <div class="panel panel-info m-t-15" id="cont">
                            <div class="panel-heading"></div>
                            <div class="panel-body">

                    <div class="table-responsive" style="overflow-x: inherit !important;">
                        <table  id="example00" class=" table student-data-table  table-striped table-hover dt-responsive display    "  style="width:100%">
                            <thead>
                                <tr>
                                    <th>@lang('Nom')</th>
                                    <th>@lang('Statut')</th>
                                    {{-- <th>@lang('Email')</th> --}}
                                    <th>@lang('Téléphone')</th>
                                    <th>@lang('Email pro')</th>
                                    <th>@lang('Email perso')</th>
                                    <th>@lang('Adresse')</th>
                                    <th>@lang('Numéro Siret')</th>
                                    <th>@lang('Numéro TVA')</th>
                                    <th>@lang('Date de création')</th>
                                 
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($mandataires as $mandataire)
                            
                            @if($mandataire->contrat == null   ) 
                                <tr>
                                    
                                    <td>
                                        <a href="{{route('switch_user',Crypt::encrypt($mandataire->id) )}}" data-toggle="tooltip" title="@lang('Se connecter en tant que ') {{ $mandataire->nom }}">{{$mandataire->nom}} {{$mandataire->prenom}}<i style="font-size: 17px" class="material-icons color-success">person_pin</i></a> 
                                    </td>
                                    <td>
                                    {{$mandataire->statut}} 
                                    </td>
                                    
                                    {{-- <td style="color: #32ade1; text-decoration: underline;">
                                        <strong>{{$mandataire->email}}</strong> 
                                    </td> --}}
                                    <td style="color: #e05555;; text-decoration: underline;">
                                        <strong> {{$mandataire->telephone1}} </strong> 
                                    </td>
                                    
                                    
                                    
                                    
                                    <td style="color: #32ade1; text-decoration: underline;"><span  >{{$mandataire->email}} </td>
                                    <td style="color: #32ade1; text-decoration: underline;"><span  >{{$mandataire->email_perso}} </td>
                                    <td>{{$mandataire->adresse}} </td>
                                    
                                        
                                    <td style="color: #4da62f; text-decoration: underline;"><span class="badge badge-success">{{$mandataire->numero_siret}}</span></td>
                                    <td style="color: #4da62f; text-decoration: underline;"><span class="badge badge-success">{{$mandataire->numero_tva}}</span></td>
                                    <td style="color: #32ade1; "><span  >{{$mandataire->created_at->format('d/m/Y')}} </td>
                                    
                                    <td width="13%">
                                        <span><a href="{{route('mandataire.show',Crypt::encrypt($mandataire->id) )}}" data-toggle="tooltip" title="@lang('Détails de ') {{ $mandataire->nom }}"><i class="large material-icons color-info">visibility</i></a> </span>
                                        <span><a href="{{route('mandataire.edit',Crypt::encrypt($mandataire->id) )}}" data-toggle="tooltip" title="@lang('Modifier ') {{ $mandataire->nom }}"><i class="large material-icons color-warning">edit</i></a></span>
                                        {{-- <span><a href="{{route('switch_user',Crypt::encrypt($mandataire->id) )}}" data-toggle="tooltip" title="@lang('Se connecter en tant que ') {{ $mandataire->nom }}"><i class="large material-icons color-success">person_pin</i></a></span> --}}
                                    
                                        {{-- <span><a  href="{{route('mandataire.archive',[$mandataire->id,1])}}" class="delete" data-toggle="tooltip" title="@lang('Archiver ') {{ $mandataire->nom }}"><i class="large material-icons color-danger">delete</i> </a></span> --}}
                                    </td>
                                    
                                </tr>
                                
                                @endif
                                
                                
                        @endforeach
                    </tbody>
                        </table>
                    </div>
                </div>
            </div>

                </div>

