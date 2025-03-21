@extends('layouts.app')
@section('content')
@section('page_title')
    <a href="{{ route('mandat.index') }}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5">
        <i class="ti-angle-double-left"></i>@lang('Retour')
    </a>
    Import de mandats
@endsection

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                       
                        <div class="row">
                            <div class="col-lg-6">
                                <form action="{{ route('mandat.process_import') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                                    @csrf
                                    <div class="form-group">
                                        <label>Fichier d'import de mandats</label>
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
        
                            </div>
                            <div class="col-lg-6">
                                <form action="{{ route('mandat.process_import_retour') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                                    @csrf
                                    <div class="form-group">
                                        <label>Fichier pour retour de mandats</label>
                                        <input type="file" name="file" class="form-control" accept=".xlsx,.xls" required>
                                        @error('file')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
        
                                    <div class="form-group mt-4">
                                        <button type="submit" class="btn btn-danger">
                                            <i class="ti-upload"></i> Importer
                                        </button>
                                    </div>
                                </form>
        
                            </div>
                        </div>
                        
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
                                                <th>Mandataire ID</th>
                                                <th>Mandant</th>
                                                <th>Adresse du mandant</th>
                                                <th>Code postal mandant</th>
                                                <th>Ville mandant</th>
                                                <th>Type de mandat</th>
                                                <th>Type de bien</th>
                                                <th>Adresse du bien</th>
                                                <th>Code postal</th>
                                                <th>Ville</th>
                                                <th>Observations</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- @foreach(session('preview') as $row)
                                                <tr>
                                                    <td>{{ $row['numero'] }}</td>
                                                    <td>{{ $row['date_debut'] }}</td>
                                                    <td>{{ $row['mandataire'] }}</td>
                                                    <td>{{ $row['mandataire_id'] }}</td>
                                                    <td>{{ $row['mandant'] }}</td>
                                                    <td>{{ $row['adresse_mandant']['adresse'] }}</td>
                                                    <td>{{ $row['adresse_mandant']['code_postal'] }}</td>
                                                    <td>{{ $row['adresse_mandant']['ville'] }}</td>
                                                    <td>{{ $row['type_mandat'] }}</td>
                                                    <td>{{ $row['bien']['type'] }}</td>
                                                    <td>{{ $row['bien']['adresse'] }}</td>
                                                    <td>{{ $row['bien']['code_postal'] }}</td>
                                                    <td>{{ $row['bien']['ville'] }}</td>
                                                    <td>{{ $row['observations'] }}</td>
                                                </tr>
                                            @endforeach --}}
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