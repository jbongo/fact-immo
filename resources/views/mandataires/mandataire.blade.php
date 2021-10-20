
                
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
                                        <th>@lang('TVA')</th>
                                        <th>@lang('Jeton')</th>
                                        <th>@lang('Facturation')</th>
                                        {{-- <th>@lang('Email')</th> --}}
                                        <th>@lang('Téléphone pro')</th>
                                        {{-- <th>@lang('Adresse')</th> --}}
                                        <th>@lang('date anniv')</th>
                                        <th>@lang('Comm')</th>
                                        <th>@lang('Comm Départ')</th>
                                        <th>@lang('CA HT STYL')</th>
                                     
                                        <th>@lang('Action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($mandataires as $mandataire)
                                
                                @if(($mandataire->contrat != null && $mandataire->contrat->a_demission == false && $mandataire->contrat->est_fin_droit_suite == false) ) 
                                    <tr>
                                        
                                        <td>
                                            <a href="{{route('switch_user',Crypt::encrypt($mandataire->id) )}}" data-toggle="tooltip" title="@lang('Se connecter en tant que ') {{ $mandataire->nom }}">{{$mandataire->nom}} {{$mandataire->prenom}}<i style="font-size: 17px" class="material-icons color-success">person_pin</i></a> 
                                        </td>
                                        <td>
                                        {{$mandataire->statut}} 
                                        </td>
                                        <td style="color: #32ade1; text-decoration: underline;">
                                            @if($mandataire->contrat != null)
                                                @if($mandataire->contrat->est_soumis_tva == true)
                                                    <span class="badge badge-success">Oui</span>
                                                @else 
                                                    <span class="badge badge-danger">Non</span>
                                                @endif
                                               
                                            @endif
                                        </td>
                                        <td style="color: #32ade1;  ">
                                            @if($mandataire->contrat != null)
                                                @if($mandataire->contrat->deduis_jeton == true)
                                        <a href="{{route('mandataire.historique_jeton', Crypt::encrypt($mandataire->id))}}" class="badge badge-default"><i style="font-size: 15px" class="material-icons color-success ">launch</i>  <span style="font-size: 22px"> {{$mandataire->nb_mois_pub_restant}} </span></a>
                                                @else 
                                                    <span class="badge badge-danger">Non</span>
                                                @endif                                                  
                                            @endif
                                            
                                        </td>
                                        
                                        <td style="color: #32ade1;  ">
                                            @if($mandataire->contrat != null)
                                                @if($mandataire->contrat->est_soumis_fact_pub == true)
                                                    <span class="badge badge-success">Oui</span>
                                                
                                                @else 
                                                    <span class="badge badge-danger">Non</span>
                                                @endif                                                  
                                            @endif
                                            
                                        </td>
                                        
                                        
                                        {{-- <td style="color: #32ade1; text-decoration: underline;">
                                        <strong>{{$mandataire->email}}</strong> 
                                        </td> --}}
                                        <td style="color: #e05555;; text-decoration: underline;">
                                            <strong> {{$mandataire->telephone1}} </strong> 
                                        </td>
                                        {{-- <td>
                                            {{$mandataire->adresse}} 
                                        </td> --}}
                                        
                                        <td>
                                            {{$mandataire->date_anniv()}}   
                                        </td>                                  
                                        <td @if($mandataire->contrat== null) style="background:#757575; color:white" @endif>                                             
                                            <span class="color-success" >@if($mandataire->contrat!= null) {{$mandataire->commission}} % @else Pas de contrat @endif</span>
                                        </td>
                                        
                                        <td @if($mandataire->contrat== null) style="background:#757575; color:white" @endif>                                             
                                            <span class="color-primary" >@if($mandataire->contrat!= null) 
                                            
                                                @if($mandataire->pack_actuel == "expert")
                                                    {{$mandataire->contrat->pourcentage_depart_expert}} %
                                                
                                                @else 
                                                
                                                {{$mandataire->contrat->pourcentage_depart_starter}} %
                                                
                                                @endif
                                            
                                            @else Pas de contrat @endif</span>
                                        </td>
                                        <td>                                             
                                            <span class="color-warning">{{number_format($mandataire->chiffre_affaire_styl(date('Y').'-01-01', date('Y-m-d')),2)}} €</span>
                                        </td>
                                      
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

