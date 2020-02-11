@extends('layouts.app')


@section('content')


@if(Auth::user()->role == "admin")
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
                <button style="background-color:#ff1a1a; width:50px; height:20px"></button> <span style="font-family: Montserrat; font-size:16px; font-weight:bold; ">Chiffre d'affaires Général : {{number_format( array_sum(config('stats.CA_N')[0]) ,0,'',',')}}</span> 
            </div>
        </div>
        
    </div>
     
  
</div>

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

<div class="row">
<div class="col-lg-3">
    <div class="card">
        <div class="stat-widget-five">
            <div class="stat-icon">
                <i class="ti-home bg-primary"></i>
            </div>
            <div class="stat-content">
                <div class="stat-heading color-primary"><strong>Affaires</strong></div>
                <div class="stat-text">17</div>
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
                <div class="stat-text">13</div>
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
                <div class="stat-text">207050</div>
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
                <div class="stat-heading color-primary"><strong>Parrainage</strong></div>
                <div class="stat-text">6</div>
            </div>
        </div>
    </div>
</div>
</div>

</div>

@else 



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
                    <div class="stat-text">6</div>
                </div>
            </div>
        </div>
    </div>
</div>
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


<div class="content-wrap">
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
    </div>
@endif

@stop
@section('js-content')


<script>

    //Sales chart
    var ctx = document.getElementById("sales-chart");
    ctx.height = 150;
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet","Août","Septembre","Octobre","Novembre","Décembre"],
            type: 'line',
            defaultFontFamily: 'Montserrat',
            datasets: [{
                label: "Général",
                data: {{json_encode(config('stats.CA_N')[0])}},
                backgroundColor: 'transparent',
                borderColor: '#ff1a1a',
                borderWidth: 3,
                pointStyle: 'circle',
                pointRadius: 5,
                pointBorderColor: 'transparent',
                pointBackgroundColor: '#ff1a1a',

                    }, {
                label: "Encaissé",
                data: {{json_encode(config('stats.CA_N')[2])}},
                backgroundColor: 'transparent',
                borderColor: '#6eff1a',
                borderWidth: 3,
                pointStyle: 'circle',
                pointRadius: 5,
                pointBorderColor: 'transparent',
                pointBackgroundColor: '#6eff1a',
                    }, {
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
                label: "Prévisionnel",
                data: {{json_encode(config('stats.CA_N')[3])}},
                backgroundColor: 'transparent',
                borderColor: '#0ad2ff',
                borderWidth: 3,
                pointStyle: 'circle',
                pointRadius: 5,
                pointBorderColor: 'transparent',
                pointBackgroundColor: '#0ad2ff',
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

// Morris donut chart
    
// Morris.Donut({
//     element: 'morris-donut-chart',
//     data: [{
//         label: "Général",
//         value: 9500,
//     }, {
//         label: "En Attente",
//         value: 3000
//     }, {
//         label: "En attente de validation",
//         value: 2000
//     }],
//     resize: true,
//     colors:['#c38e15', '#ff258a', '#8b67c9']
// });
// });  
</script>

<script>

    // Morris donut chart
    Morris.Donut({
        element: 'morris-donut-chart',
        data: [
        //     {
        //     label: "Général",
        //     value: {{array_sum(config('stats.CA_N')[0])}},

        // }, 
        
        {
            label: "En attente",
            value:  {{array_sum(config('stats.CA_N')[1])}}
        }, {
            label: "Encaissé",
            value:  {{array_sum(config('stats.CA_N')[2])}}
        }, {
            label: "Prévisionnel",
            value:  {{array_sum(config('stats.CA_N')[3])}}
        }],
        resize: true,
        colors:[ '#e6e6e6', '#6eff1a','#0ad2ff']
    });

</script>





<script>


//bar chart
var ctx = document.getElementById("barChart");
//    ctx.height = 200;
    var myChart = new Chart(ctx, { 
        type: 'bar',
        data: {
            labels: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet","Août","Septembre","Octobre","Novembre","Décembre"],
            datasets: [
                {
                    label: "Général",
                    data: {{json_encode(config('stats.CA_N')[0])}},
                    borderColor: "rgba(255, 26, 26, 1)",
                    borderWidth: "0",
                    backgroundColor: "rgba(255, 26, 26, 1)"
                            },
                {
                    label: "Encaissé",
                    data: {{json_encode(config('stats.CA_N')[2])}},
                    borderColor: "rgba(110, 255, 26, 1)",
                    borderWidth: "0",
                    backgroundColor: "rgba(110, 255, 26, 1)"
                            },
                            {
                    label: "En attente",
                    data: {{json_encode(config('stats.CA_N')[1])}},
                    borderColor: "rgba(0,0,0,0.09)",
                    borderWidth: "0",
                    backgroundColor: "rgba(0,0,0,0.07)"
                            },
                            {
                    label: "Prévisionnel",
                    data: {{json_encode(config('stats.CA_N')[3])}},
                    borderColor: "rgba(10, 210, 255, 1)",
                    borderWidth: "0",
                    backgroundColor: "rgba(10, 210, 255, 1)"
                            }
                        ]
        },
        options: {
            scales: {
                xAxes: [{ overlaping: true }],
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