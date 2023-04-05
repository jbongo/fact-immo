<a href="#" data-toggle="modal"  data-target="#documents_acquereur_add" class="btn btn-info btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i class="ti-plus"></i>@lang('Ajouter')</a>
<div class="table-responsive" style="overflow-x: inherit !important;">
    <table id="document_acquereur_list" class="table table-hover table-striped">
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
            @if(unserialize($affaire->documents_acquereur) != false)
            @foreach(unserialize($affaire->documents_acquereur) as $key=>$one)
            <tr>
                <td><strong>{{$one["nom"]}}</strong></td>
                @if($one["statut"] === "Traitement")
                <td><span class="badge badge-warning">{{$one["statut"]}}</span></td>
                @else
                <td><span class="badge badge-success">{{$one["statut"]}}</span></td>
                @endif
                <td>
                        <input type="checkbox" route="{{route('suiviaffaire.document.action', [CryptId($affaire->id), CryptId($key), "documents_acquereur", "toggle_compromis"])}}" {{($one['compromis'] == 0) ? "unchecked" : "checked"}} data-toggle="toggle" class="check_compromis_acte" name="check_compromis" data-off="Non" data-on="Oui" data-onstyle="success btn-rounded btn-sm" data-offstyle="danger btn-rounded btn-sm">
                </td>
                <td>
                        <input type="checkbox" route="{{route('suiviaffaire.document.action', [CryptId($affaire->id), CryptId($key), "documents_acquereur", "toggle_acte"])}}" {{($one['acte'] == 0) ? "unchecked" : "checked"}} data-toggle="toggle" class="check_compromis_acte" name="check_acte" data-off="Non" data-on="Oui" data-onstyle="success btn-rounded btn-sm" data-offstyle="danger btn-rounded btn-sm">
                </td>
                <td>
                        @if($one["statut"] === "Traitement")
                        <span><a class="validate_document" href="{{route('suiviaffaire.document.action', [CryptId($affaire->id), CryptId($key), "documents_acquereur", "confirm"])}}" data-toggle="tooltip" title="Valider le document"><i class="large material-icons color-success">check</i></a> </span>
                        @endif
                        <span><a class="delete_document" href="{{route('suiviaffaire.document.action', [CryptId($affaire->id), CryptId($key), "documents_acquereur", "delete"])}}" data-toggle="tooltip" title="Supprimer le document"><i class="large material-icons color-danger">delete</i></a> </span>
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>