@extends('layouts.app')
@section('content')
@section('page_title')
    Programmer votre diffusion
@endsection
<link rel="stylesheet" href="{{ asset('css/date-ranges-selector.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/flick/jquery-ui.css">
@endsection


@section('content')
<style>
    .btn-blue {
        background-color: #03a9f5;
        color: white;
    }

    .modal-body {
        max-height: calc(100vh - 200px);
        overflow-y: auto;
    }

    .linetop {
        border-top: 1px dotted;
    }
</style>

<style>
    body {
        padding: 10px;
        font-family: 'Roboto';
        background-color: #fafafa;
    }

    .date_ranges {
        margin: 10px;
        padding: 10px 0px;
    }

    .list_container {
        width: 50%;
        margin: 10px;
        padding: 20px;

        background-color: #F7F7F7;
    }

    .options_container {
        margin: 10px;
    }

    .code {
        margin: 10px;
        padding: 20px;
        font-family: monospace;

        background-color: #E2E2E2;
    }

    .log {
        margin: 10px;
        padding: 20px;
        background-color: #F7F7F7;
        font-family: monospace;

        max-height: 500px;
        overflow-y: scroll;
    }
</style>


<div class="row">

    <div class="col-lg-6 col-md-6">
        <div class="col-lg-10">
            <a href="{{ url()->previous() }}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5"><i
                    class="ti-arrow-left "></i>@lang('Retour')</a>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-lg-6 col-md-6">
        <h2>@lang('Choisissez les périodes de diffusion et les annonces correspondantes')</h2>


        <div id="date_ranges_container" class="date_ranges"> </div>

        <br />
        <br />
        <br />
        <br />

        <div class="options_container">
            {{-- <button onclick="add_range_with_dates()">Add range with dates</button> --}}
            <button onclick="get_date_ranges()" class="btn btn-primary" id="valider">Valider</button>
            <button class="btn btn-danger"
                onclick='$("#date_ranges_container").datesRangesSelector("removeAllDateRanges");'>Tout
                supprimer</button>
        </div>

        <div class="options_container">
            {{-- <button onclick="get_date_ranges()">Obtenir la liste</button> --}}
        </diV>

        {{-- <div class="options_container">
        <button onclick="$('#date_ranges_container').datesRangesSelector('disable');">Disable</button>
        <button onclick="$('#date_ranges_container').datesRangesSelector('enable');">Enable</button>
    </div> --}}

        <div id="log" class="log">
            <strong>liste:</strong><br />
        </div>

    </div>



    <div class="col-lg-6 col-md-6">
        <h2>Vous allez diffuser sur les passerelles suivantes : </h2>
        <div class="row">
            @foreach ($passerelles as $passerelle)
                <div class="col-lg-4 col-md-4 col-sm-4">

                    <span>{{ $passerelle->nom }}</span>
                    <a class="btn btn-lg info_pass" href="#" id="{{ $passerelle->id }}" data-toggle="modal"
                        data-target="#add-category" title="@lang('Modifier la passerelle ') ">
                        <img src="{{ asset('images/passerelles/' . $passerelle->logo) }}" width="150px" height="100px"
                            alt="">
                    </a>

                </div>
            @endforeach
        </div>

    </div>
</div>
@endsection

@section('js-content')
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="{{ asset('js/date-ranges-selector.js') }}"></script>

<script>
    $(document).ready(function() {

        $("#date_ranges_container").datesRangesSelector({
            // text for 'New Data Range' button
            new_date_range_text: "+ Démarrer",

            // prefix class
            main_class_prefix: "drs",

            // max date
            max_date: "+1Y",

            // min date
            min_date: 0,
            // date format
            date_format: "D, dd/mm/yy",

            // adds an aditional selector to every range
            selector: true,
            placeholder_date_begin: "Date Début",
            placeholder_date_end: "Date Fin",
            // selector name
            selector_name: "appear",

            // selector options
            selector_options:

                [
                    @foreach ($bien->annonces as $annonce)
                        ["{{ $annonce->identifiant_annonce }}", "{{ $annonce->id }}"],
                    @endforeach
                ],

            // uses timezone offsets
            use_timezone_offset: true
        });

        $("#date_ranges_container").on("datesRangesSelector.rangeAdded", function(event, position, date_begin,
            date_end) {
            // $("#log").append("Added in pos " + position + " with date_begin: " + date_begin + " and date_end " + date_end + "<br />");
        });

        $("#date_ranges_container").on("datesRangesSelector.rangeRemoved", function(event, position) {
            $("#log").append("Removed in pos " + position + "<br />");
        });

        $("#date_ranges_container").on("datesRangesSelector.allRangesRemoved", function(event) {
            $("#log").append("Tout est supprimé <br />");
        });

        $("#date_ranges_container").on("datesRangesSelector.becameEmpty", function(event) {
            // $("#log").append("Empty! <br />");
        });

        $("#date_ranges_container").on("datesRangesSelector.becameFull", function(event) {
            // $("#log").append("Not empty anymore! <br />");
        });

    });

    function add_range_with_dates() {
        $("#date_ranges_container").datesRangesSelector("addDateRange", {
            date_begin: "1527554515",
            date_end: "1528559515",
            selector: 0
        });
    }
    var passerelles_id = '{{ $passerelles_id }}';
    //console.log(passerelles_id);
    function get_date_ranges() {
        var ranges = $("#date_ranges_container").datesRangesSelector("getDateRanges");
        console.log(ranges);

        var text_ranges = "";
        if (ranges.length == 0) {
            text_ranges = "&nbsp;&nbsp;&nbsp;&nbsp;No ranges<br />";
        } else {
            $.each(ranges, function(index, value) {
                text_ranges += "&nbsp;&nbsp;&nbsp;&nbsp;Position " + (index + 1) + ". date_begin: " + value
                    .date_begin + ". date_end: " + value.date_end + ". appear: " + value.appear + "<br />";
            });
            // Envoie des données 
            $(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                var passerelles_id = JSON.parse("{{ $passerelles_id }}");
                //  console.log(passerelles_id);

                $('[data-toggle="tooltip"]').tooltip()
                // $('#valider').click(function(e) {
                let that = $(this)
                // e.preventDefault()
                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger m-l-15',
                    buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                    title: '@lang('Vraiment valider cette planification ?')',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: '@lang('Oui')',
                    cancelButtonText: '@lang('Non')',

                }).then((result) => {
                    if (result.value) {
                        $('[data-toggle="tooltip"]').tooltip('hide')
                        $.ajax({
                                url: '{{ url('diffusion/prog/diffuser') }}',
                                data: {
                                    "ranges": JSON.stringify(ranges),
                                    "bien_id": "{{ $bien->id }}",
                                    "passerelles_id": passerelles_id
                                },
                                type: 'POST'
                            })
                            .done(function(data) {
                                console.log(data);
                                $(location).attr('href',
                                    '{{ url('/diffusion/prog/show/all') }}/{{ $bien->id }}'
                                    );

                            }).error(function(data) {
                                console.log(data);
                            })
                        swalWithBootstrapButtons(
                            'Archivé!',
                            'L\'utilisateur a bien été archivé.',
                            'success'
                        )


                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons(
                            'Annulé',
                            'L\'utlisateur n\'a pas été archivé :)',
                            'error'
                        )
                    }
                })
                // })
            })
        }

        // $("#log").append("Getting current date ranges:<br />" + text_ranges);

    }
</script>
@endsection
