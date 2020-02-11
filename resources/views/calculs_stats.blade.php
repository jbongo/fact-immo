@extends('layouts.app')
@section('content')
    @section ('page_title')
    Calculs stats {{$mandataire->nom}} {{$mandataire->prenom}}
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
                
                <div class="card-body">
                        
                    <span style="color: #ff0080"> CA directe sur les 12 derniers mois  </span> :<span> {{$ca_direct}}</span> <hr>
                    <span style="color: #ff0080"> CA indirecte sur les 12 derniers mois </span> : <span> {{$ca_indirect}}</span> <hr>
                    <span style="color: #ff0080"> Nombre de vente sur les 12 derniers mois </span> : <span> {{$vente_12}}</span> <hr>
                    <span style="color: #ff0080"> Nombre de filleuls </span> : <span>{{$nb_filleul}} </span> <hr>
                    <span style="color: #ff0080"> CA global Styl'immo 2019 tableau </span> : <span>{{$nb_filleul}} </span> <hr>
                    <span style="color: #ff0080"> CA global Styl'immo 2020 tableau </span> : <span>{{$nb_filleul}} </span> <hr>
                    <span style="color: #ff0080"> CA Styl en attente d'encaissement </span> : <span>{{$nb_filleul}} </span> <hr>
                    <span style="color: #ff0080"> CA Styl encaissé </span> : <span>{{$nb_filleul}} </span> <hr>
                    <span style="color: #ff0080"> Nombre de mandataire </span> : <span>{{$nb_filleul}} </span> <hr>
                    <span style="color: #ff0080"> Nombre d'affaires en cour' </span> : <span>{{$nb_filleul}} </span> <hr>
                    <span style="color: #ff0080"> Est-il à jour dans ses règlements de pubs ? </span> : <span> </span> <hr>
                    <span style="color: #ff0080"> Si filleul, dans quel cycle ?  </span> : <span> </span> <hr>
                </div>
                <!-- end table -->
            </div>
        </div>
    </div>
@endsection
@section('js-content')
<script>

    </script>
@endsection