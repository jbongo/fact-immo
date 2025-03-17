@extends('layouts.app')
@section('content')
@section('page_title')
    <a href="{{ route('mandat.index') }}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5">
        <i class="ti-angle-double-left"></i>@lang('Retour')
    </a>
    Import de mandats
@endsection

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                       

                        <form action="{{ route('mandat.process_import') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                            @csrf
                            <div class="form-group">
                                <label>Fichier Excel</label>
                                <input type="file" name="file" class="form-control" accept=".xlsx,.xls" required>
                                @error('file')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti-upload"></i> Importer
                                </button>
                            </div>
                        </form>

                        @if(session('preview'))
                            <div class="mt-5">
                                <h4>Aperçu des données (30 premières lignes)</h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Numéro</th>
                                                <th>Date début</th>
                                                <th>Mandataire</th>
                                                <th>Date fin</th>
                                                <th>Mandant</th>
                                                <th>Adresse mandat</th>
                                                <th>Type de mandat</th>
                                                <th>Adresse du bien</th>
                                                <th>Observations</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(session('preview') as $row)
                                                <tr>
                                                    <td>{{ $row['numero'] }}</td>
                                                    <td>{{ $row['date_debut'] }}</td>
                                                    <td>{{ $row['mandataire'] }}</td>
                                                    <td>{{ $row['date_fin'] }}</td>
                                                    <td>{{ $row['mandant'] }}</td>
                                                    <td>{!! nl2br(e($row['adresse_mandat'])) !!}</td>
                                                    <td>
                                                        <strong>Original :</strong> {{ $row['type_mandat']['original'] }}
                                                        <br>
                                                        <strong>Extrait :</strong> {{ $row['type_mandat']['extrait'] }}
                                                    </td>
                                                    <td>{{ $row['adresse_bien'] }}</td>
                                                    <td>{{ $row['observations'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-control[type="file"] {
    padding: 3px 12px;
    height: auto;
}
.table-responsive {
    overflow-x: auto;
    max-width: 100%;
}
.table td {
    white-space: normal;
    min-width: 150px;
}
.table th {
    background-color: #f8f9fa;
}
</style>
@endsection 