
                
                <div class="card-body">
                    <div class="panel panel-danger m-t-15" id="cont">
                            <div class="panel-heading"></div>
                            <div class="panel-body">

                    <div class="table-responsive" style="overflow-x: inherit !important;">
                        <table  id="example2" class=" table student-data-table  table-striped table-hover dt-responsive display    "  style="width:100%">
                            <thead>
                                <tr>
                                    <th>@lang('Parrain')</th>
                                    <th>@lang('Filleul')</th>
                                    <th>@lang('Date d\'expiration')</th>
                                    <th>@lang('Commission encaissée')</th>
                                   
 
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($filleuls_expires as $filleul)
                            
   
                                <tr>
                                    
                                    <td>
                                        <a href="{{route('switch_user',Crypt::encrypt($filleul->parrain_id) )}}" data-toggle="tooltip" title="@lang('Se connecter en tant que ') {{ $filleul->parrain()->nom }}">{{$filleul->parrain()->nom}} {{$filleul->parrain()->prenom}}<i style="font-size: 17px" class="material-icons color-success">person_pin</i></a> 
                                    </td>
                                    <td>
                                        <a href="{{route('switch_user',Crypt::encrypt($filleul->user_id) )}}" data-toggle="tooltip" title="@lang('Se connecter en tant que ') {{ $filleul->user->nom }}">{{$filleul->user->nom}} {{$filleul->user->prenom}}<i style="font-size: 17px" class="material-icons color-success">person_pin</i></a> 
                                    </td>
                                   
                                                                  
                                    <td style="color: #e05555;; ">
                                        <strong> {{ date('d/m/Y ', strtotime('+2 years', strtotime($filleul->created_at->format('Y-m-d'))))     }} </strong> 
                                    </td>
                                    <td>                                             
                                        <span class="color-warning">{{number_format($filleul->commission(),2,'.',' ')}} €</span>
                                    </td>
                                  
                                    <td width="13%">
                                        {{-- <span><a href="{{route('filleul.show',Crypt::encrypt($filleul->id) )}}" data-toggle="tooltip" title="@lang('Détails de ') {{ $filleul->nom }}"><i class="large material-icons color-info">visibility</i></a> </span>
                                        <span><a href="{{route('filleul.edit',Crypt::encrypt($filleul->id) )}}" data-toggle="tooltip" title="@lang('Modifier ') {{ $filleul->nom }}"><i class="large material-icons color-warning">edit</i></a></span>                                        
                                        <span><a  href="{{route('filleul.activer',[$filleul->id])}}" class="activer" contrat="{{route('contrat.edit',Crypt::encrypt($filleul->contrat->id))}}" data-toggle="tooltip" title="@lang('Activer ') {{ $filleul->nom }}"><i class="large material-icons color-danger">replay</i> </a></span> --}}
                                    </td>
                                </tr>
                   
                                
                                
                        @endforeach
                          </tbody>
                        </table>
                    </div>
                </div>
            </div>

                </div>

