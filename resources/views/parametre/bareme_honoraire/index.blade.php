@extends('layouts.app')
@section('content')
    @section ('page_title')
    Fournisseurs
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
                @if(Auth::user()->role == "admin")                
                    <a href="{{route('bareme_honoraire.create')}}" class="btn btn-success btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i class="ti-plus"></i>@lang('Ajouter un barème')</a>
                      <br> <hr>
               @endif
               <div class="row">
             
                    
                    <!-- Content -->
                    <div class=" col-lg-12 col-md-12 col-sm-12">
                       <div class="card">
                          <div class="card-body">
                            <div class="table-responsive" style="overflow-x: inherit !important;">
                                <table  id="example" class=" table student-data-table  m-t-20 "  style="width:100%">
                                    <thead>
                                        <tr  style="background-color: #2a596d;">
                                            <th style=" color:#fff">Prix de vente min</th>
                                            <th style=" color:#fff">Prix de vente max</th>
                                            <th style=" color:#fff">Honoraires</th>
                                     
                                            <th style=" color:#fff">@lang('Action')</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    @foreach ($baremes as $bareme)
                                        <tr>
                
                                            <td style="color: #e05555;">
                                            <strong>{{$bareme->prix_min}}</strong> 
                                            </td>
                                            <td style="color: #e05555;">
                                                 {{$bareme->prix_max}}  
                                            </td>
                                            
                                            @if($bareme->est_forfait)                                            
                                            
                                                <td style="color: #32ade1;">
                                                    @if($bareme->forfait_min != null )
                                                    Forfait Minimum de {{$bareme->forfait_min}} TTC
                                                    @else
                                                    Forfait Maximum de {{$bareme->forfait_max}} TTC
                                                    @endif
                                                </td>                                         
                                       
                                            @else 
                                                <td style="color: #32ade1;">
                                                    {{$bareme->pourcentage}} %
                                                </td>    
                                            @endif
                                                                             
                                    
                                            <td>                                             
                                                <span><a href="{{route('bareme_honoraire.edit',Crypt::encrypt($bareme->id))}}" data-toggle="tooltip" title="@lang('Modifier ') "><i class="large material-icons color-warning">edit</i></a></span>
                                                <span><a data-href="{{route('bareme_honoraire.delete', Crypt::encrypt($bareme->id))}}" style="cursor: pointer;" class="delete" data-toggle="tooltip" title="@lang('Supprimer ') "><i class="large material-icons color-danger">delete</i> </a></span>
                                            </td>
                                        </tr>
                                    @endforeach
                                  </tbody>
                                </table>
                            </div>
                          </div>
                       </div>
                    </div>
                </div>
            
            
            
            
         </div>
      </div>
    </div>
@endsection

@section('js-content')

<script>
    $(function() {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        })
        $('[data-toggle="tooltip"]').tooltip()
        $('a.delete').click(function(e) {
            let that = $(this)
            e.preventDefault()
            const swalWithBootstrapButtons = swal.mixin({
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
})

    swalWithBootstrapButtons({
        title: '@lang('Vraiment supprimer ce barème  ?')',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: '@lang('Oui')',
        cancelButtonText: '@lang('Non')',
        
    }).then((result) => {
        if (result.value) {
            $('[data-toggle="tooltip"]').tooltip('hide')
                $.ajax({                        
                    url: that.attr('data-href'),
                    type: 'DELETE'
                })
                .done(function () {
                        that.parents('tr').remove();
                })

            swalWithBootstrapButtons(
            'Supprimé!',
            'Le barème a bien été supprimé.',
            'success'
            )
            
            
        } else if (
            // Read more about handling dismissals
            result.dismiss === swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons(
            'Annulé',
            'Le barème n\'a pas été supprimé :)',
            'error'
            )
        }
    })
        })
    })
</script>

@endsection