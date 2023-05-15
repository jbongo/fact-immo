<a href="#" data-toggle="modal" data-target="#documents_mandant_add"
    class="btn btn-success btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i class="ti-plus"></i>@lang('Ajouter')</a>
<div class="table-responsive" style="overflow-x: inherit !important;">
    <table id="document_mandant_list" class="table table-hover table-striped">
        <thead>
            <tr>
                <th>@lang('Intitulé du document')</th>
                <th>@lang('Statut')</th>
                <th>@lang('Compromis')</th>
                <th>@lang('Acte')</th>
                <th>@lang('Action')</th>
            </tr>
        </thead>
        <tbody>
            @if (unserialize($bien->documents_mandant) != false)
                @foreach (unserialize($bien->documents_mandant) as $key => $one)
                    <tr>
                        <td><strong>{{ $one['nom'] }}</strong></td>
                        @if ($one['statut'] === 'Traitement')
                            <td><span class="badge badge-warning">{{ $one['statut'] }}</span></td>
                        @else
                            <td><span class="badge badge-success">{{ $one['statut'] }}</span></td>
                        @endif
                        <td>
                            <input type="checkbox"
                                route="{{ route('suiviaffaire.document.action', [Crypt::encrypt($bien->id), Crypt::encrypt($key), 'documents_mandant', 'toggle_compromis']) }}"
                                {{ $one['compromis'] == 0 ? 'unchecked' : 'checked' }} data-toggle="toggle"
                                class="check_compromis_acte" name="check_compromis" data-off="Non" data-on="Oui"
                                data-onstyle="success btn-rounded btn-sm" data-offstyle="danger btn-rounded btn-sm">
                        </td>
                        <td>
                            <input type="checkbox"
                                route="{{ route('suiviaffaire.document.action', [Crypt::encrypt($bien->id), Crypt::encrypt($key), 'documents_mandant', 'toggle_acte']) }}"
                                {{ $one['acte'] == 0 ? 'unchecked' : 'checked' }} data-toggle="toggle"
                                class="check_compromis_acte" name="check_acte" data-off="Non" data-on="Oui"
                                data-onstyle="success btn-rounded btn-sm" data-offstyle="danger btn-rounded btn-sm">
                        </td>
                        <td>
                            @if ($one['statut'] === 'Traitement')
                                <span><a class="validate_document"
                                        href="{{ route('suiviaffaire.document.action', [Crypt::encrypt($bien->id), Crypt::encrypt($key), 'documents_mandant', 'confirm']) }}"
                                        data-toggle="tooltip" title="Valider le document"><i
                                            class="large material-icons color-success">check</i></a> </span>
                            @endif
                            <span><a class="delete_document"
                                    href="{{ route('suiviaffaire.document.action', [Crypt::encrypt($bien->id), Crypt::encrypt($key), 'documents_mandant', 'delete']) }}"
                                    data-toggle="tooltip" title="Supprimer le document"><i
                                        class="large material-icons color-danger">delete</i></a> </span>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
