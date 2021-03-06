@extends('layouts.app')


@section('content')

@section ('page_title')
    <a class="btn btn-success  btn-rounded btn-addon btn-sm m-b-10 m-l-5" id="ajouter"><i class="ti-plus"></i>Stats 2019</a> 

    <a href="{{route('compromis.index')}}#sous_offre_nav"><div title="Sous offre" class="button" style="background:#FF8C00;" href="{{route('compromis.index')}}#sous_offre_nav"><div  style=" color:black;font-family: Montserrat; font-size:13px;" >{{config('stats.STATS')["nb_sous_offre_N"]}}</div></div> </a></span> <span style="font-family: Montserrat; font-size:13px;  "> Les affaires sous offre</span> 
    <a href="{{route('compromis.index')}}#sous_compromis_nav"><div title="Sous compromis" class="button" style="background: #0ad2ff;" href="{{route('compromis.index')}}#sous_compromis_nav"><div  style=" color:black;font-family: Montserrat; font-size:13px;" >{{config('stats.STATS')["nb_sous_compromis_N"]}}</div></div> </a></span> <span style="font-family: Montserrat; font-size:13px;  "> Les affaires sous compromis</span> 
    <a href="{{route('compromis.index')}}#en_attente_nav"><div title="En attente d'encaissement" class="button" style="background: #e6e6e6;" ><div><div  style=" color:black;font-family: Montserrat; font-size:13px;" >{{config('stats.STATS')["nb_en_attente_N"]}}</div></div></div> </a></span> <span style="font-family: Montserrat; font-size:13px;  "> Les affaires non encaissée</span>
    <a href="{{route('compromis.index')}}#encaissee_nav"><div title="Encaissé" class="button" style="background: #2e5;" ><div><div  style=" color:black;font-family: Montserrat; font-size:13px;" >{{config('stats.STATS')["nb_encaisse_N"]}}</div></div></div> </a></span> <span style="font-family: Montserrat; font-size:13px;  "> Les affaires encaissée</span>  
    <a href="{{route('compromis.index')}}"><div title="Général" class="button" style="background: #ff1a1a;" ><div><div  style=" color:black;font-family: Montserrat; font-size:13px;" >{{config('stats.STATS')["nb_global_N"]}}</div></div></div></a> <span style="font-family: Montserrat; font-size:13px;  "> Toutes les affaires</span> 
 
 
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
                <h4>Chiffre d'affaires 2020 </h4>
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
                <h4 class="card-title">Chiffre d'affaire annuel (2020)</h4>
                <div id="morris-donut-chart"></div>
            </div>
            <div>
                <button style="background-color:#ff1a1a; width:50px; height:20px"></button> <span style="font-family: Montserrat; font-size:16px; font-weight:bold; ">Chiffre d'affaires Général : {{number_format( array_sum(config('stats.CA_N')[0]) ,2,'.',',')}}</span> 
            </div>
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




{{-- CA ANNEE N-1 --}}
<div class="row" >
      
    <div class="col-lg-8">
        <div class="card alert">
            <div class="card-header">
                <h4>Chiffre d'affaires 2019 </h4>
                {{-- <div class="card-header-right-icon">
                    <ul>
                        <li class="card-close" data-dismiss="alert"><i class="ti-close"></i></li>
                        <li class="doc-link"><a href="#"><i class="ti-link"></i></a></li>
                    </ul>
                </div> --}}
            </div>
            <div class="sales-chart_n_1">
                <canvas id="sales-chart_n_1"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4" >
        <div class="card" style="height: 100%; ">
            <div class="card-body">
                <h4 class="card-title">Chiffre d'affaire annuel (2019)</h4>
                <div id="morris-donut-chart_n_1"></div>
            </div>
            <div>
                <button style="background-color:#ff1a1a; width:50px; height:20px"></button> <span style="font-family: Montserrat; font-size:16px; font-weight:bold; ">Chiffre d'affaires Général : {{number_format( array_sum(config('stats.CA_N_1')[0]) ,2,'.',',')}}</span> 
            </div>
        </div>
        
    </div>
     
  
</div>
{{-- ##################### --}}


{{-- Chiffre d'affaires mensuels N BAR --}}

<div class="row">
 <!-- Bar Chart -->
    <div class="col-sm-12 col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4>Chiffre d'affaires mensuels 2020</h4>
                </div>
            </div>
            <div class="panel-body">
                <canvas id="barChart"></canvas>
            </div>
        </div>
    </div>
</div>
{{-- ############ --}}

{{-- Chiffre d'affaires mensuels N-1 BAR --}}

<div class="row">
    <!-- Bar Chart -->
       <div class="col-sm-12 col-md-12">
           <div class="panel">
               <div class="panel-heading">
                   <div class="panel-title">
                       <h4>Chiffre d'affaires mensuels 2019</h4>
                   </div>
               </div>
               <div class="panel-body">
                   <canvas id="barChart_n_1"></canvas>
               </div>
           </div>
       </div>
   </div>

{{-- ############# --}}

<div class="row">
<div class="col-lg-3">
    <div class="card">
        <div class="stat-widget-five">
            <div class="stat-icon">
                <i class="ti-home bg-primary"></i>
            </div>
            <div class="stat-content">
                <div class="stat-heading color-primary"><strong>Affaires</strong></div>
                <div class="stat-text">{{config('stats.STATS')["nb_affaires"]}}</div>
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
                <div class="stat-heading color-success"><strong>Mandataires</strong></div>
                <div class="stat-text">{{config('stats.STATS')["nb_mandataires"] }}</div>
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
                <div class="stat-heading color-primary"><strong>Chiffre d'affaires</strong></div>
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
{{-- {{dd(config('stats.STATS')["nb_filleuls"])}} --}}
{{-- @else 



<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card">
            <div class="stat-widget-five">
                <div class="stat-icon">
                    <i class="ti-home bg-primary"></i>
                </div>
                <div class="stat-content">
                    <div class="color-primary">Affaires </div>
                    <div class="stat-text">27</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card">
            <div class="stat-widget-five">
                <div class="stat-icon">
                    <i class="ti-money bg-success"></i>
                </div>
                <div class="stat-content">
                    <div class=" color-success">Chiffre d'affaires</div>
                    <div class="stat-text">5000</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card">
            <div class="stat-widget-five">
                <div class="stat-icon">
                    <i class="ti-user bg-warning"></i>
                </div>
                <div class="stat-content">
                    <div class=" color-primary">Mandataire</div>
                    <div class="stat-text">200</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card">
            <div class="stat-widget-five">
                <div class="stat-icon bg-danger">
                    <i class="ti-sharethis"></i>
                </div>
                <div class="stat-content">
                    <div class="color-primary">Partage</div>
                    <div class="stat-text">{{6}}</div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
{{-- 
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="media">
                <div class="media-left meida media-middle">
                    <span><i class="ti-target f-s-22 color-primary border-primary round-widget"></i></span>
                </div>
                <div class="media-body media-text-right">
                    <h4>278</h4>
                    <h6>Aquéreurs potentiels</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="media">
                <div class="media-left meida media-middle">
                    <span><i class="ti-target f-s-22 color-warning border-warning round-widget"></i></span>
                </div>
                <div class="media-body media-text-right">
                    <h4>45</h4>
                    <h6>Aquéreurs ayant acheté un bien</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="media">
                <div class="media-left meida media-middle">
                    <span><i class="ti-target f-s-22 color-success border-success round-widget"></i></span>
                </div>
                <div class="media-body media-text-right">
                    <h4>458</h4>
                    <h6>Aquéreurs cherchants une maison</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="media">
                <div class="media-left meida media-middle">
                    <span><i class="ti-target f-s-22 border-danger color-danger round-widget"></i></span>
                </div>
                <div class="media-body media-text-right">
                    <h4>895</h4>
                    <h6>Aquéreurs cherchants un appartement</h6>
                </div>
            </div>
        </div>
    </div>
</div> --}}


{{-- <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">
       
                <!-- /# row -->
                <div id="main-content">
                    <div class="row">
                        <!-- column -->
                        
                        <!-- column -->
                      
                        <!-- column -->
                    
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Chiffre d'affaires mensuel 2019</h4>
                                    <div id="morris-bar-chart"></div>
                                </div>
                            </div>
                        </div>
                        <!-- column -->
                        <!-- column -->
                       
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="footer">
                                <p>This dashboard was generated on <span id="date-time"></span> <a href="#" class="page-refresh">Refresh Dashboard</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
{{-- @endif --}}

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
                        labelString: "Chiffre d'affaires"
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

    //Sales chart ANNEE N-1
    var ctx = document.getElementById("sales-chart_n_1");
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
                data: {{json_encode(config('stats.CA_N_1')[3])}},
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
                data: {{json_encode(config('stats.CA_N_1')[4])}},
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
                data: {{json_encode(config('stats.CA_N_1')[1])}},
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
                data: {{json_encode(config('stats.CA_N_1')[2])}},
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
                data: {{json_encode(config('stats.CA_N_1')[0])}},
                backgroundColor: 'transparent',
                borderColor: '#ff1a1a',
                borderWidth: 3,
                pointStyle: 'circle',
                pointRadius: 5,
                pointBorderColor: 'transparent',
                pointBackgroundColor: '#ff1a1a',

                    }
                    
                
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
                        labelString: "Chiffre d'affaires"
                    }
                        }]
            },
            title: {
                display: false,
                text: 'Normal Legend'
            }
        }
    });
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


// #################

// Morris donut chart ANNEE N-1
Morris.Donut({
        element: 'morris-donut-chart_n_1',
        data: [
        //     {
        //     label: "Général",
        //     value: {{array_sum(config('stats.CA_N')[0])}},

        // }, 
        
        {
            label: "Sous offre",
            value:  {{array_sum(config('stats.CA_N_1')[3])}}
        }, {
            label: "Sous Compromis",
            value:  {{array_sum(config('stats.CA_N_1')[4])}}
        },
        
        {
            label: "En attente",
            value:  {{array_sum(config('stats.CA_N_1')[1])}}
        }, {
            label: "Encaissé",
            value:  {{array_sum(config('stats.CA_N_1')[2])}}
        }],
        resize: true,
        colors:[ '#FFA500','#0ad2ff','#e6e6e6', '#6eff1a']

    });

</script>





<script>


//bar chart ANNEE N
var ctx = document.getElementById("barChart");
//    ctx.height = 200;
    var myChart = new Chart(ctx, { 
        type: 'bar',
        data: {
            labels: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet","Août","Septembre","Octobre","Novembre","Décembre"],
            datasets: [

                {
                    label: "Sous offre",
                    data: {{json_encode(config('stats.CA_N')[3])}},
                    borderColor: "#FFA500",
                    borderWidth: "0",
                    backgroundColor: "#FFA500"
                },
                {
                    label: "Sous compromis",
                    data: {{json_encode(config('stats.CA_N')[4])}},
                    borderColor: "rgba(10, 210, 255, 1)",
                    borderWidth: "0",
                    backgroundColor: "rgba(10, 210, 255, 1)"
                },
               
                {
                    label: "En attente",
                    data: {{json_encode(config('stats.CA_N')[1])}},
                    borderColor: "rgba(0,0,0,0.09)",
                    borderWidth: "0",
                    backgroundColor: "rgba(0,0,0,0.07)"
                },
                {
                    label: "Encaissé",
                    data: {{json_encode(config('stats.CA_N')[2])}},
                    borderColor: "rgba(110, 255, 26, 1)",
                    borderWidth: "0",
                    backgroundColor: "rgba(110, 255, 26, 1)"
                },
                {
                    label: "Général",
                    data: {{json_encode(config('stats.CA_N')[0])}},
                    borderColor: "rgba(255, 26, 26, 1)",
                    borderWidth: "0",
                    backgroundColor: "rgba(255, 26, 26, 1)"
                }
                            
                        ]
        },
        options: {
            scales: {
              
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                                }]
            }
        }
    });


    
//bar chart ANNEE N-1
var ctx = document.getElementById("barChart_n_1");
   ctx.height = 80;
    var myChart = new Chart(ctx, { 
        type: 'bar',
        data: {
            labels: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet","Août","Septembre","Octobre","Novembre","Décembre"],
            datasets: [
                {
                    label: "Sous offre",
                    data: {{json_encode(config('stats.CA_N_1')[3])}},
                    borderColor: "#FFA500",
                    borderWidth: "0",
                    backgroundColor: "#FFA500"
                },
                {
                    label: "Sous compromis",
                    data: {{json_encode(config('stats.CA_N_1')[4])}},
                    borderColor: "rgba(10, 210, 255, 1)",
                    borderWidth: "0",
                    backgroundColor: "rgba(10, 210, 255, 1)"
                },
               
                {
                    label: "En attente",
                    data: {{json_encode(config('stats.CA_N_1')[1])}},
                    borderColor: "rgba(0,0,0,0.09)",
                    borderWidth: "0",
                    backgroundColor: "rgba(0,0,0,0.07)"
                },
                {
                    label: "Encaissé",
                    data: {{json_encode(config('stats.CA_N_1')[2])}},
                    borderColor: "rgba(110, 255, 26, 1)",
                    borderWidth: "0",
                    backgroundColor: "rgba(110, 255, 26, 1)"
                },
                {
                    label: "Général",
                    data: {{json_encode(config('stats.CA_N_1')[0])}},
                    borderColor: "rgba(255, 26, 26, 1)",
                    borderWidth: "0",
                    backgroundColor: "rgba(255, 26, 26, 1)"
                }
                        ]
        },
        options: {
            scales: {
              
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                                }]
            }
        }
    });

</script>
@endsection