@extends('layouts.app')


@section('content')

@section ('page_title')
    {{-- <a class="btn btn-success  btn-rounded btn-addon btn-sm m-b-10 m-l-5" id="ajouter"><i class="ti-plus"></i>Stats {{config('stats.STATS.annee')}} </a>  --}}
    <label>Modifier l'année</label>
    <div class="row">
        <div class="col-md-2">
  
    <select name="annee" id="annee" class="form-control">
            @for ($an = 2017; $an <= date('Y') +1 ; $an++)
                @if($an == config('stats.STATS.annee'))
                    <option selected="selected" value="{{config('stats.STATS.annee')}}">{{config('stats.STATS.annee')}}</option>
                @else
                    <option value="{{$an}}">{{$an}} </option>

                @endif
            @endfor

    </select>

        </div>
    </div>

    <a href="{{route('compromis.index_from_dashboard',config('stats.STATS.annee'))}}#sous_offre_nav"><div title="Sous offre" class="button" style="background:#FF8C00;" href="{{route('compromis.index')}}#sous_offre_nav"><div  style=" color:black;font-family: Montserrat; font-size:13px;" >{{config('stats.STATS')["nb_sous_offre_N"]}}</div></div> </a></span> <span style="font-family: Montserrat; font-size:13px;  "> Les affaires sous offre</span> 
    <a href="{{route('compromis.index_from_dashboard',config('stats.STATS.annee'))}}#sous_compromis_nav"><div title="Sous compromis" class="button" style="background: #0ad2ff;" href="{{route('compromis.index')}}#sous_compromis_nav"><div  style=" color:black;font-family: Montserrat; font-size:13px;" >{{config('stats.STATS')["nb_sous_compromis_N"]}}</div></div> </a></span> <span style="font-family: Montserrat; font-size:13px;  "> Les affaires sous compromis</span> 
    <a href="{{route('compromis.index_from_dashboard',config('stats.STATS.annee'))}}#en_attente_nav"><div title="En attente d'encaissement" class="button" style="background: #e6e6e6;" ><div><div  style=" color:black;font-family: Montserrat; font-size:13px;" >{{config('stats.STATS')["nb_en_attente_N"]}}</div></div></div> </a></span> <span style="font-family: Montserrat; font-size:13px;  "> Les affaires non encaissées</span>
    <a href="{{route('compromis.index_from_dashboard',config('stats.STATS.annee'))}}#encaissee_nav"><div title="Encaissé" class="button" style="background: #2e5;" ><div><div  style=" color:black;font-family: Montserrat; font-size:13px;" >{{config('stats.STATS')["nb_encaisse_N"]}}</div></div></div> </a></span> <span style="font-family: Montserrat; font-size:13px;  "> Les affaires encaissées</span>  
    <a href="{{route('compromis.index_from_dashboard',config('stats.STATS.annee'))}}"><div title="Général" class="button" style="background: #ff1a1a;" ><div><div  style=" color:black;font-family: Montserrat; font-size:13px;" >{{config('stats.STATS')["nb_global_N"]}}</div></div></div></a> <span style="font-family: Montserrat; font-size:13px;  "> Toutes les affaires</span> 
 
 
    {{-- <a href="{{route('compromis_type.index')}}" class="btn btn-danger btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i class="ti-folder"></i>@lang('Voir les affaires')</a> --}}
    <br>

<style type="text/css">
  .button {
    backface-visibility: hidden;
  position: relative;
  width: 40px;
  height: 40px;
  cursor: pointer;
  display: inline-block;
  white-space: nowrap;
  
  border-radius: 100px;
  border: 0px solid #444;
  border-width: 0px 0px 0px 0px;
  padding: 10px 13px 10px 13px;
    color: #000;
  font-size: 16px;
  font-family: Helvetica Neue;
  font-weight: 900;
  font-style: normal
  }
  .button > div {
    color: #999;
  font-size: 10px;
  font-family: Helvetica Neue;
  font-weight: initial;
  font-style: normal;
  text-align: center;
  margin: 0px 0px 0px 0px
  }
  .button > i {
    color: #fff;
  font-size: 1em;
  border-radius: 0px;
  border: 0px solid transparent;
  border-width: 0px 0px 0px 0px;
  padding: 0px 0px 0px 0px;
  margin: 0px 0px 0px 0px;
  position: static
  }
  .button > .ld {
    font-size: initial
  }
</style>
@endsection

{{-- @if(Auth::user()->role == "admin") --}}

{{--  CA ANNEE N --}}
<div class="row" >
      
    <div class="col-lg-8">
        <div class="card alert">
            <div class="card-header">
                <h4>Chiffre d'affaires Styl HT {{config('stats.STATS.annee')}}  </h4>
                {{-- <div class="card-header-right-icon">
                    <ul>
                        <li class="card-close" data-dismiss="alert"><i class="ti-close"></i></li>
                        <li class="doc-link"><a href="#"><i class="ti-link"></i></a></li>
                    </ul>
                </div> --}}
            </div>
            <div class="sales-chart">
                <canvas id="sales-chart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4" >
        <div class="card" style="height: 100%; ">
            <div class="card-body">
                <h4 class="card-title">Chiffre d'affaires Styl HT annuel {{config('stats.STATS.annee')}} </h4>
                <div id="morris-donut-chart"></div>
            </div>
            <div>
                <button style="background-color:#ff1a1a; width:50px; height:20px"></button> <span style="font-family: Montserrat; font-size:16px; font-weight:bold; ">Chiffre d'affaires Styl HT Général : {{number_format( array_sum(config('stats.CA_N')[0]) ,2,'.',',')}}</span> 
            </div>

            @if(Auth::user()->role == "mandataire")
            <div>
                <button style="background-color:#66556f; width:50px; height:20px"></button> <span style="font-family: Montserrat; font-size:16px; font-weight:bold; ">Chiffre d'affaires Styl HT contractuel : {{number_format( Auth::user()->chiffre_affaire_styl(Auth::user()->date_anniv(), date('Y-m-d')) ,2,'.',',')}}</span> 
            </div>
            @endif

        </div>
        
    </div>
     
  
</div>
{{-- ######## --}}

{{--  CA ANNEE N --}}
<div class="row" >
      
    <div class="col-lg-12">
        <div class="card alert">
            <div class="card-header">
                <h4>Légende </h4>
                
               
            </div>
            <div class="sales-chart">
                <!-- sample html for this button-->

  <!-- stylesheet for this button -->
  
            </div>
        </div>
    </div>
   
     
  
</div>






{{-- ############# --}}

<div class="row">
<div class="col-lg-2">
    <div class="card">
        <div class="stat-widget-five">
            <div class="stat-icon">
                <i class="ti-home bg-primary"></i>
            </div>
            <div class="stat-content">
                <div class="stat-heading color-primary"><strong>Affaires en cours</strong></div>
                <div class="stat-text">{{config('stats.STATS')["nb_affaires_en_cours"]}}</div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-3">
    <div class="card">
        <div class="stat-widget-five">
            <div class="stat-icon">
                <i class="ti-user bg-success"></i>
            </div>
            <div class="stat-content">
                <div class="stat-heading color-success"><strong>Mandataires actifs</strong></div>
                <div class="stat-text">{{config('stats.STATS')["nb_mandataires_actifs"] }}</div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-3">
    <div class="card">
        <div class="stat-widget-five">
            <div class="stat-icon">
                <i class="ti-money bg-warning"></i>
            </div>
            <div class="stat-content">
                <div class="stat-heading color-primary"><strong>Chiffre d'affaires Styl HT</strong></div>
                <div class="stat-text">{{number_format( array_sum(config('stats.CA_N')[0]) ,2,',',' ')}}</div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-3">
    <div class="card">
        <div class="stat-widget-five">
            <div class="stat-icon bg-danger">
                <i class="ti-medall-alt"></i>
            </div>
            <div class="stat-content">
                <div class="stat-heading color-primary"><strong>Parrainages</strong></div>
                <div class="stat-text">{{config('stats.STATS')["nb_filleuls"]}}</div>
            </div>
        </div>
    </div>
</div>
</div>

</div>


@stop
@section('js-content')


<script>

    //Sales chart ANNEE N
    var ctx = document.getElementById("sales-chart");
    ctx.height = 150;
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet","Août","Septembre","Octobre","Novembre","Décembre"],
            type: 'line',
            defaultFontFamily: 'Montserrat',
            datasets: [
                {
                label: "Sous offre",
                data: {{json_encode(config('stats.CA_N')[3])}},
                backgroundColor: 'transparent',
                borderColor: '#FFA500',
                borderWidth: 3,
                pointStyle: 'circle',
                pointRadius: 5,
                pointBorderColor: 'transparent',
                pointBackgroundColor: '#FFA500',
                    },
                    {
                label: "Sous compromis",
                data: {{json_encode(config('stats.CA_N')[4])}},
                backgroundColor: 'transparent',
                borderColor: '#0ad2ff',
                borderWidth: 3,
                pointStyle: 'circle',
                pointRadius: 5,
                pointBorderColor: 'transparent',
                pointBackgroundColor: '#0ad2ff',
                    },

                {
                label: "En attente",
                data: {{json_encode(config('stats.CA_N')[1])}},
                backgroundColor: 'transparent',
                borderColor: '#e6e6e6',
                borderWidth: 3,
                pointStyle: 'circle',
                pointRadius: 5,
                pointBorderColor: 'transparent',
                pointBackgroundColor: '#e6e6e6',
                    },
                {
                label: "Encaissé",
                data: {{json_encode(config('stats.CA_N')[2])}},
                backgroundColor: 'transparent',
                borderColor: '#6eff1a',
                borderWidth: 3,
                pointStyle: 'circle',
                pointRadius: 5,
                pointBorderColor: 'transparent',
                pointBackgroundColor: '#6eff1a',
                    }, 
                    {
                label: "Général",
                data: {{json_encode(config('stats.CA_N')[0])}},
                backgroundColor: 'transparent',
                borderColor: '#ff1a1a',
                borderWidth: 3,
                pointStyle: 'circle',
                pointRadius: 5,
                pointBorderColor: 'transparent',
                pointBackgroundColor: '#ff1a1a',

                    },
                   
                    
                
                ]
        },

            
        options: {
            // responsive: true,

            tooltips: {
                mode: 'index',
                titleFontSize: 12,
                titleFontColor: '#000',
                bodyFontColor: '#000',
                backgroundColor: '#fff',
                titleFontFamily: 'Montserrat',
                bodyFontFamily: 'Montserrat',
                cornerRadius: 3,
                intersect: false,
            },
            legend: {
                labels: {
                    usePointStyle: true,
                    fontFamily: 'Montserrat',
                },
            },
            scales: {
                xAxes: [{
                    display: true,
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    scaleLabel: {
                        display: false,
                        labelString: 'Mois'
                    }
                        }],
                yAxes: [{
                    display: true,
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    scaleLabel: {
                        display: true,
                        labelString: "Chiffre d'affaires Styl HT"
                    }
                        }]
            },
            title: {
                display: false,
                text: 'Normal Legend'
            }
        }
    });

    // ############# 

  
</script>





<script>

    // Morris donut chart ANNEE N
    Morris.Donut({
        element: 'morris-donut-chart',
        data: [
        //     {
        //     label: "Général",
        //     value: {{array_sum(config('stats.CA_N')[0])}},

        // }, 
        {
            label: "Sous offre",
            value:  {{array_sum(config('stats.CA_N')[3])}}
        }, {
            label: "Sous Compromis",
            value:  {{array_sum(config('stats.CA_N')[4])}}
        },
        
        {
            label: "En attente",
            value:  {{array_sum(config('stats.CA_N')[1])}}
        }, {
            label: "Encaissé",
            value:  {{array_sum(config('stats.CA_N')[2])}}
        } ],
        resize: true,
        colors:[ '#FFA500','#0ad2ff','#e6e6e6', '#6eff1a']
    });

</script>





<script>


   

</script>


<script>

    $('#annee').on('change',function(){

    var annee = $('#annee').val();
      window.location.href = "/home/"+annee;
    // console.log( $('#annee').val());
    
    })
</script>
@endsection