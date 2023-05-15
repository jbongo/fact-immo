<a href="#" data-toggle="modal" data-target="#offre_add"
    class="btn btn-info btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i class="ti-plus"></i>@lang('Ajouter')</a>
<div class="table-responsive" style="overflow-x: inherit !important;">
    <table id="offre_list" class="table table-hover table-striped student-data-table  m-t-20 ">
        <thead>
            <tr>
                <th>@lang('Statut')</th>
                <th>@lang('Montant')</th>
                <th>@lang('Frais d\'agence')</th>
                <th>@lang('Acquéreur')</th>
                <th>@lang('Date')</th>
                <th>@lang('Fin le')</th>
                <th>@lang('Action')</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bien->offreachats as $one)
                <tr>
                    <td>
                        @if ($one->statut === 'En cours')
                            <span class="badge badge-warning">{{ $one->statut }}</span>
                        @elseif($one->statut === 'Compromis')
                            <span class="badge badge-success">{{ $one->statut }}</span>
                        @else
                            <span class="badge badge-danger">{{ $one->statut }}</span>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $one->montant }} €</strong>
                    </td>
                    <td>
                        <strong>{{ $one->frais_agence }} €</strong>
                    </td>
                    <td>
                        <span><a href="{{ route('contact.entite.show', Crypt::encrypt($one->entite_id)) }}"
                                data-toggle="tooltip" title="Voir le visiteur"><i
                                    class="large material-icons color-info">visibility</i></a> </span>
                    </td>
                    <td>
                        {{ date('d/m/Y', strtotime($one->date_debut)) }}
                    </td>
                    <td>
                        {{ date('d/m/Y', strtotime($one->date_fin)) }}
                    </td>
                    <td>
                        <span><a href="{{ route('suiviaffaire.offre.download', Crypt::encrypt($one->id)) }}"
                                data-toggle="tooltip" title="Télécharger le fichier pdf"><i
                                    class="large material-icons color-pink">cloud_download</i></a> </span>
                        @if ($bien->statut === 'offre')
                            @if ($one->statut === 'En cours')
                                <span><a class="confirm_offre"
                                        href="{{ route('suiviaffaire.offre.accept', [Crypt::encrypt($one->id), 1]) }}"
                                        data-toggle="tooltip" title="Accepter l'offre"><i
                                            class="large material-icons color-success">check</i></a> </span>
                                <span><a class="reject_offre"
                                        href="{{ route('suiviaffaire.offre.accept', [Crypt::encrypt($one->id), 0]) }}"
                                        data-toggle="tooltip" title="Rejeter l'offre"><i
                                            class="large material-icons color-warning">close</i></a> </span>
                            @elseif($one->statut === 'Rejetée')
                                <span><a class="counter_offre" href="#"
                                        route="{{ route('suiviaffaire.offre.contreoffre.add', Crypt::encrypt($one->id)) }}"
                                        data-toggle="tooltip" title="Ajouter une contre offre"><i
                                            class="large material-icons color-warning">restore</i></a> </span>
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@section('js_offres')
    <script>
        $('a.confirm_offre').click(function(b) {
            b.preventDefault();
            let that = $(this);
            var route = that.attr('href');
            var reload = 1;
            var warning = 'Valider uniquement si l\'offre est acceptée par le mandant, confirmez ?';
            processAjaxSwal(route, warning, reload);
        })
        $('a.reject_offre').click(function(b) {
            b.preventDefault();
            let that = $(this);
            var route = that.attr('href');
            var reload = 1;
            var warning = 'Valider uniquement si l\'offre est rejetée par le mandant, confirmez ?';
            processAjaxSwal(route, warning, reload);
        })
        $('a.counter_offre').click(function(b) {
            b.preventDefault();
            let that = $(this);
            var route = that.attr('route');
            $('.form_contre_offre').attr('action', route);
            $('#offre_counter').modal('show');
        })
    </script>
@endsection
