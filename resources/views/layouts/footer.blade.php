
    <script src="{{ asset('js/lib/jquery.min.js')}}"></script>
    <!-- jquery vendor -->
    <script src="{{ asset('js/lib/jquery.nanoscroller.min.js')}}"></script>
    <!-- nano scroller -->
    <script src="{{ asset('js/lib/menubar/sidebar.js')}}"></script>
    <script src="{{ asset('js/lib/preloader/pace.min.js')}}"></script>
    <!-- sidebar -->
    <script src="{{ asset('js/lib/bootstrap.min.js')}}"></script>
    <!-- bootstrap -->
    {{-- <script src="{{ asset('js/lib/weather/jquery.simpleWeather.min.js')}}"></script>
    <script src="{{ asset('js/lib/weather/weather-init.js')}}"></script> --}}
    {{-- <script src="{{ asset('js/lib/circle-progress/circle-progress.min.js')}}"></script>
    <script src="{{ asset('js/lib/circle-progress/circle-progress-init.js')}}"></script>
    <script src="{{ asset('js/lib/chartist/chartist.min.js')}}"></script>
    <script src="{{ asset('js/lib/chartist/chartist-init.js')}}"></script> --}}

{{-- 
    <script src="{{ asset('js/lib/morris-chart/raphael-min.js')}}"></script>
    <script src="{{ asset('js/lib/morris-chart/morris.js')}}"></script> --}}
    {{-- <script src="{{ asset('js/lib/morris-chart/morris-init.js')}}"></script> --}}





    {{-- <script src="{{ asset('js/lib/sparklinechart/jquery.sparkline.min.js')}}"></script>
    <script src="{{ asset('js/lib/sparklinechart/sparkline.init.js')}}"></script>
    <script src="{{ asset('js/lib/owl-carousel/owl.carousel.min.js')}}"></script>
    <script src="{{ asset('js/lib/owl-carousel/owl.carousel-init.js')}}"></script> --}}
    <script src="{{ asset('js/scripts.js')}}"></script>
    {{-- <script src="{{ asset('js/dropzone.js')}}"></script>
    <script src="{{ asset('js/dropzone-config.js')}}"></script> --}}
    <script src="{{ asset('js/sweetalert2.js')}}"></script>
    <script src="{{ asset('js/lib/select2/select2.full.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script>
        var table = $('#example').DataTable({
            "order": [],
            "iDisplayLength": 50,
            "language": {
            "decimal":        "",
            "emptyTable":     "Aucune donnée disponible dans le tableau",
            "info":           "Affichage _START_ à _END_ sur _TOTAL_ lignes",
            "infoEmpty":      "Affichage 0 à 0 sur 0 lignes",
            "infoFiltered":   "(filtrés sur _MAX_ total lignes)",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "Voir _MENU_ lignes",
        
           
            "search":         "Rechercher:",
            "zeroRecords":    "Aucune donnée trouvée",
            "paginate": {
                "first":      "First",
                "last":       "Last",
                "next":       "Suivant",
                "previous":   "Précédent"
            },
   
            }
        });
        var table1 = $('#example1').DataTable({
            "order": [],
            "iDisplayLength": 50,

            "language": {
            "decimal":        "",
            "emptyTable":     "Aucune donnée disponible dans le tableau",
            "info":           "Affichage _START_ à _END_ sur _TOTAL_ lignes",
            "infoEmpty":      "Affichage 0 à 0 sur 0 lignes",
            "infoFiltered":   "(filtrés sur _MAX_ total lignes)",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "Voir _MENU_ lignes",
        
           
            "search":         "Rechercher:",
            "zeroRecords":    "Aucune donnée trouvée",
            "paginate": {
                "first":      "First",
                "last":       "Last",
                "next":       "Suivant",
                "previous":   "Précédent"
            },
   
            }

        }); 
        // mandataire
        var table = $('#example3').DataTable({
            paging: false,
            "order": [],

            "language": {
            "decimal":        "",
            "emptyTable":     "Aucune donnée disponible dans le tableau",
            "info":           "Affichage _START_ à _END_ sur _TOTAL_ lignes",
            "infoEmpty":      "Affichage 0 à 0 sur 0 lignes",
            "infoFiltered":   "(filtrés sur _MAX_ total lignes)",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "Voir _MENU_ lignes",
        
           
            "search":         "Rechercher:",
            "zeroRecords":    "Aucune donnée trouvée",
            "paginate": {
                "first":      "First",
                "last":       "Last",
                "next":       "Suivant",
                "previous":   "Précédent"
            },
   
            }
        });       

    </script>
    @yield('js-content')
</body>

</html>