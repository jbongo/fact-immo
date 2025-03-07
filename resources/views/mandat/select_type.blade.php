@extends('layouts.app')
@section('content')
@section ('page_title')
    <a href="{{route('mandat.index')}}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5">
        <i class="ti-angle-double-left"></i>@lang('Retour')
    </a>
    Créer un nouveau mandat
@endsection

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="alert alert-info">
                            <i class="ti-info-alt"></i> 
                            Vous avez des réservations en cours. Vous pouvez soit les compléter, soit créer un nouveau mandat.
                        </div>

                        <!-- Liste des réservations -->
                        <div class="reservations-list mb-4 col-md-6 ">
                            <h4 class="mb-3">Réservations en cours</h4> <br>
                            @foreach($reservations as $reservation)
                                <div class="reservation-item p-3 mb-3 border rounded">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="mb-1">Réservation #{{ $reservation->numero }}</h5>
                                            <p class="mb-1 text-muted">
                                                {{ $reservation->nom_reservation }}
                                                @if(Auth::user()->role == 'admin')
                                                    <br>
                                                   @if($reservation->suiviPar != null) <small>Suivi par: {{ $reservation->suiviPar->nom }} {{ $reservation->suiviPar->prenom }} @endif</small>
                                                @endif
                                            </p>
                                            <small>Créée le {{ $reservation->created_at->format('d/m/Y') }}</small>
                                        </div>
                                        <a href="{{ route('mandat.edit', Crypt::encrypt($reservation->id)) }}" 
                                           class="btn btn-info btn-sm">
                                            <i class="ti-pencil"></i> Compléter
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Bouton nouveau mandat -->
                        <div class="text-center col-md-6">
                            <a href="{{ route('mandat.create') }}" class="btn btn-primary btn-lg">
                                <i class="ti-plus"></i> Créer un nouveau mandat
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.reservation-item {
    transition: all 0.3s ease;
    background: #fff;
}

.reservation-item:hover {
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}
</style>
@endsection 