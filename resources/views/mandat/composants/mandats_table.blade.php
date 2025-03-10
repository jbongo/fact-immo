<table class="table custom-table" id="mandatsTable">
    <thead>
        <tr>
            <th class="text-center sortable" data-column="numero">@lang('Mandat') <i class="ti-exchange-vertical"></i></th>
            <th class="sortable" data-column="type">@lang('Type') <i class="ti-exchange-vertical"></i></th>
            <th class="sortable" data-column="date">@lang('Date du mandat') <i class="ti-exchange-vertical"></i></th>
            <th class="sortable" data-column="mandant">@lang('Mandant(s)') <i class="ti-exchange-vertical"></i></th>
            <th class="sortable" data-column="bien">@lang('Bien') <i class="ti-exchange-vertical"></i></th>
            <th class="sortable" data-column="observations">@lang('Observations') <i class="ti-exchange-vertical"></i></th>
            @if(Auth::user()->role == 'admin')
                <th class="sortable" data-column="suivi">@lang('Suivi par') <i class="ti-exchange-vertical"></i></th>
            @endif
            <th class="text-center">@lang('Action')</th>
        </tr>
    </thead>
    <tbody>
        @foreach($mandats as $mandat)
            <tr>
                <td class="text-center">
                    <span class="badge badge-danger">{{ $mandat->numero }}</span>
                </td>
                <td>{{ $mandat->type ?? 'Réservation' }}</td>
                <td>{{ $mandat->date_debut ? $mandat->date_debut->format('d/m/Y') : '-' }}</td>
                <td>{{ $mandat->contact ? $mandat->contact->nom . ' ' . $mandat->contact->prenom : $mandat->nom_reservation }}</td>
                <td>{{ $mandat->bien ? $mandat->bien->ville : '-' }}</td>
                <td>{{ $mandat->observation ?? '-' }}</td>
                @if(Auth::user()->role == 'admin')
                    <td>{{ $mandat->suiviPar ? $mandat->suiviPar->nom . ' ' . $mandat->suiviPar->prenom : '-' }}</td>
                @endif
                <td class="text-center">
                    @if($mandat->statut == "réservation")
                        <a href="{{ route('mandat.edit', Crypt::encrypt($mandat->id)) }}" 
                            class="btn btn-dark" 
                            title="Compléter">
                            Compléter
                        </a>
                    @else
                        <a href="{{ route('mandat.show', Crypt::encrypt($mandat->id)) }}" 
                            class="btn btn-info" 
                            title="Voir">
                            <i class="ti-eye"></i>
                        </a>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $mandats->links() }} 