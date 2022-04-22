@extends('layouts.app')
@section('content')
    @section ('page_title')
    Outils informatique
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
                    <a href="{{route('outil_info.create')}}" class="btn btn-success btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i class="ti-user"></i>@lang('Ajouter un outil ')</a>
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
                                        <th style=" color:#fff">@lang('Nom')</th>
                                        <th style=" color:#fff">@lang('Site web')</th>
                                        <th style=" color:#fff">@lang('Identifiant')</th>
                                        <th style=" color:#fff">@lang('Mot de passe')</th>
                                        <th style=" color:#fff">@lang('Autres champs')</th>
                                  
                                        <th style=" color:#fff">@lang('Action')</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                
                                @foreach ($outils as $outil)
                                    <tr>
            
                                        <td style="color: #e05555; text-decoration: underline;">
                                            <strong>{{$outil->nom}}</strong> 
                                        </td>
                                        
                                        <td style="color: #2f0146; ">
                                            <strong>{{$outil->site_web}}</strong> 
                                        </td>
                                        
                                        <td style="color: #2f0146; ">
                                            <strong>{{$outil->identifiant}}</strong> 
                                        </td>
                                        <td style="color: #2f0146; ">
                                            <strong>{{$outil->password}}</strong> 
                                        </td>
                                        <td style="color: #2f0146; ">
                                            <strong>{!!$outil->autre_champ!!}</strong> 
                                        </td>
                                        
                                                     
                                
                                        <td>
                                            <span><a href="{{route('outil_info.edit',$outil->id)}}" data-toggle="tooltip" title="@lang('Afficher ') {{ $outil->nom }}"><i class="large material-icons color-success">remove_red_eye</i></a></span>
                                           
                                            <span><a href="{{route('outil_info.edit',$outil->id)}}" data-toggle="tooltip" title="@lang('Modifier ') {{ $outil->nom }}"><i class="large material-icons color-warning">edit</i></a></span>
                                            <span><a  data-href="{{route('outil_info.delete',$outil->id)}}" class="delete" data-toggle="tooltip" title="@lang('supprimer ') {{ $outil->nom }}"><i class="large material-icons color-danger">delete</i> </a></span>
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
        title: '@lang('Vraiment supprimer cet outil  ?')',
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
                        that.parents('tr').remove()
                })

            swalWithBootstrapButtons(
            'Supprimé!',
            'L\'outil a bien été supprimé.',
            'success'
            )
            
            
        } else if (
            // Read more about handling dismissals
            result.dismiss === swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons(
            'Annulé',
            'L\'outil n\'a pas été supprimé :)',
            'error'
            )
        }
    })
        })
    })
</script>

@endsection