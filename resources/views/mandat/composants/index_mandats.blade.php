<div class="card-body">
    <div class="panel panel-info m-t-15" id="cont">
        <div class="panel-heading"></div>
        <div class="panel-body">

            <div class="table-responsive" style="overflow-x: inherit !important;">
                <table id="example00"
                    class=" table student-data-table  table-striped table-hover dt-responsive display    "
                    style="width:100%">
                    <thead>
                        <tr>
                            <th>@lang('Mandat')</th>
                            <th>@lang('Type')</th>
                            <th>@lang('Date du mandat')</th>
                            <th>@lang('Mandant(s)')</th>
                            <th>@lang('Bien')</th>
                            <th>@lang('Observations')</th>
                            @if(Auth::user()->role == 'admin')
                                <th>@lang('Suivi par')</th>
                            @endif

                            <th>@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mandats as $mandat)                         
                            <tr>
                                <td>
                                    <span class="badge  badge-danger border-orange-600">{{$mandat->numero}}</span>
                                </td>
                                <td style="font-size: 15px; font-weight: bold;   ">
                                    @if($mandat->type == null)
                                        <span class="color-primary"> <strong> {{ $mandat->statut }} </strong> </span>
                                    @else 
                                        <span class="color-success"> <strong> {{ $mandat->type }} </strong> </span>
                                    @endif
                                </td>
                                <td style="color: #32ade1;  ">
                                    {{ $mandat->date_debut != null ? $mandat->date_debut->format('d/m/Y') : '' }} -
                                    {{ $mandat->date_fin != null ? $mandat->date_fin->format('d/m/Y') : '' }}
                                </td>

                                <td>
                                    @if($mandat->contact_id != null)
                                        @if($mandat->contact->type_contact == 'personne_physique')
                                            <span>{{ $mandat->contact->civilite }} {{ $mandat->contact->nom }} {{ $mandat->contact->prenom }}</span> <br>
                                            <span>{{ $mandat->contact->adresse }} {{ $mandat->contact->code_postal }} {{ $mandat->contact->ville }}</span>
                                        @elseif($mandat->contact->type_contact == 'entreprise')
                                            <span>{{ $mandat->contact->raison_sociale }}</span> <br>
                                            <span>{{ $mandat->contact->adresse }} {{ $mandat->contact->code_postal }} {{ $mandat->contact->ville }}</span>
                                        @elseif($mandat->contact->type_contact == 'couple')
                                            <span>{{ $mandat->contact->nom_p1 }} {{ $mandat->contact->prenom_p1 }}</span> <br>
                                            <span>{{ $mandat->contact->adresse_p1 }} {{ $mandat->contact->code_postal_p1 }} {{ $mandat->contact->ville_p1 }}</span> <br>
                                            <span>{{ $mandat->contact->nom_p2 }} {{ $mandat->contact->prenom_p2 }}</span> <br>
                                            <span>{{ $mandat->contact->adresse_p2 }} {{ $mandat->contact->code_postal_p2 }} {{ $mandat->contact->ville_p2 }}</span>
                                     
                                        @elseif($mandat->contact->type_contact == 'indivision')
                                            <span>{{ $mandat->contact->nom_indivision }}</span> <br>
                                            <span>{{ $mandat->contact->adresse }} {{ $mandat->contact->code_postal }} {{ $mandat->contact->ville }}</span>
                                        @else 
                                            <span>{{ $mandat->contact->nom }} </span> <br>
                                            <span>{{ $mandat->contact->adresse }} {{ $mandat->contact->code_postal }} {{ $mandat->contact->ville }}</span>
                                        @endif
                                    @else
                                        <span>{{$mandat->nom_reservation}}</span>
                                    @endif
                                </td>

                                <td style="color: #e05555;">
                                    @if($mandat->bien_id != null)
                                        <span>{{ $mandat->bien->type_bien }} <br>
                                            {{ $mandat->bien->adresse }} <br>
                                            {{ $mandat->bien->code_postal }} {{ $mandat->bien->ville }}</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $mandat->observation }}
                                </td>
                                @if(Auth::user()->role == 'admin')
                                    <td>
                                        @if($mandat->suivi_par_id != null)
                                            <a href="{{ route('switch_user', Crypt::encrypt($mandat->suivi_par_id)) }}"
                                                data-toggle="tooltip"
                                                title="@lang('Se connecter en tant que ') {{ $mandat->suiviPar->nom }}">
                                                {{ $mandat->suiviPar->nom }} {{ $mandat->suiviPar->prenom }}<i style="font-size: 17px"
                                                    class="material-icons color-success">person_pin</i>
                                            </a>
                                        @endif
                                    </td>
                                @endif
                             
                                <td width="13%">
                                    @if($mandat->statut != "réservation" )
                                    <span>
                                        <a href="{{ route('mandat.show', Crypt::encrypt($mandat->id)) }}"
                                            data-toggle="tooltip"
                                            title="@lang('Détails de ') {{ $mandat->nom }}"><i
                                                class="large material-icons color-info">visibility</i>
                                        </a>
                                    </span>
                                    @endif
                                    @if($mandat->statut == "réservation" )
                                    <span>
                                        <a href="{{ route('mandat.edit', Crypt::encrypt($mandat->id)) }}" class="btn btn-dark" 
                                           title="@lang('Compléter le mandat ') {{ $mandat->nom_reservation }}">
                                            Compléter
                                        </a>
                                    </span>
                                    <span>
                                        <a href="#" class="btn-edit-reservation" 
                                           data-id="{{ $mandat->id }}"
                                           data-nom="{{ $mandat->nom_reservation }}"
                                           data-suivi="{{ $mandat->suivi_par_id }}"
                                           data-toggle="tooltip"
                                           title="@lang('Modifier ') {{ $mandat->nom_reservation }}">
                                            <i class="large material-icons color-warning">edit</i>
                                        </a>
                                    </span>
                                    @else
                                        <span>
                                            <a href="{{ route('mandat.edit', Crypt::encrypt($mandat->id)) }}"
                                                data-toggle="tooltip"
                                                title="@lang('Modifier ') {{ $mandat->nom }}"><i
                                                    class="large material-icons color-warning">edit</i>
                                            </a>
                                        </span>
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
