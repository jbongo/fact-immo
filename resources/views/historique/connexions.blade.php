@extends('layouts.app')
@section('content')
@section('page_title')
    Dernières connexions
@endsection
<div class="row">

    <div class="col-lg-12">
        @if (session('ok'))
            <div class="alert alert-success alert-dismissible fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <a href="#" class="alert-link"><strong> {{ session('ok') }}</strong></a>
            </div>
        @endif
        <div class="card alert">
            <!-- table -->
            {{-- <a href="{{route('historique.create')}}" class="btn btn-success btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i class="ti-user"></i>@lang('Nouveau historique')</a> --}}

            <div class="card-body">
                <div class="panel panel-info m-t-15" id="cont">
                    <div class="panel-heading"> Dernières connexions</div>
                    <div class="panel-body">

                        <div class="table-responsive" style="overflow-x: inherit !important;">
                            <table id="example3"
                                class=" table student-data-table  table-striped table-hover dt-responsive display    "
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>@lang('Utilisateur')</th>

                                        <th>@lang('Dernière connexion')</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($historiques as $historique)
                                        <tr>

                                            <td>
                                                <a href="{{ route('switch_user', Crypt::encrypt($historique['user']->id)) }}"
                                                    data-toggle="tooltip"
                                                    title="@lang('Se connecter en tant que ') {{ $historique['user']->nom }}">{{ $historique['user']->nom }}
                                                    {{ $historique['user']->prenom }}<i style="font-size: 17px"
                                                        class="material-icons color-success">person_pin</i></a>
                                            </td>


                                            <td style="color: #e05555;">
                                                <strong> {{ $historique['last_connexion'] }}</strong>
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
@endsection

@section('js-content')
@endsection
