@extends('layouts.app')
@section('content')
    @section ('page_title')
    Factures à valider
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
                    <div class="panel panel-default m-t-15" id="cont">
                            <div class="panel-heading"></div>
                            <div class="panel-body">

                    <div class="table-responsive" >
                        <table  id="example2" class=" table table-striped table-hover dt-responsive "  >
                            <thead>
                                <tr>
                                   
                                    <th>@lang('Fact Hono')</th>
                                    <th>@lang('Date Ajout ')</th>
                                    <th>@lang('Fact Styl')</th>
                                    <th>@lang('Mandat')</th>
                                    @if(auth()->user()->role == "admin")
                                    <th>@lang('Mandataire')</th>
                                    @endif
                                    <th>@lang('Type Fact')</th>
                                    <th>@lang('Montant HT ')</th>
                                    <th>@lang('Montant TTC ')</th>

                                    <th>@lang('Note hono')</th>
                                    <th>@lang('Télécharger')</th>
                                    <th>@lang('Action')</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($factures as $facture)

                                <tr>
                                    <td  >
                                        <label class="color-info">{{$facture->numero}} </label> 
                                    </td>
                                    <td  style="color: #342867;" >
                                        <strong>@if($facture->date_ajout_facture != null) {{$facture->date_ajout_facture->format('d/m/Y')}} @endif</strong> 
                                        </td>
                                    <td  >
                                        {{-- <label class="color-info">{{$facture->compromis->getFactureStylimmo()->numero}} </label>  --}}
                                    <a href="{{route('facture.telecharger_pdf_facture_stylimmo', Crypt::encrypt($facture->compromis->getFactureStylimmo()->id))}}"  class="  m-b-10 m-l-5 " id="ajouter"><label class="color-info">{{$facture->compromis->getFactureStylimmo()->numero}}  <i class="ti-download"></i> </label></a>
                                        
                                    </td>
                                    <td  >
                                       
                                    <label class="color-info"><a href="{{route('compromis.show',Crypt::encrypt($facture->compromis->id) )}}" target="_blank" title="@lang('voir l\'affaire  ') ">{{$facture->compromis->numero_mandat}}  <i style="font-size: 17px" class="material-icons color-success">account_balance</i></a></label>

                                    </td>
                                    @if(auth()->user()->role == "admin")
                                    <td  >
                                        <label class="color-info">
                                            @if($facture->user !=null)
                                                @if($facture->type == "partage_externe")
                                                    <a href="#" data-toggle="tooltip" style="color: red; font-weight:bold" > {{$facture->compromis->nom_agent}}</a>   
                                                
                                                @else 
                                                    <a href="{{route('switch_user',Crypt::encrypt($facture->user->id) )}}" data-toggle="tooltip" title="@lang('Se connecter en tant que ') {{$facture->user->nom}}">{{$facture->user->nom}} {{$facture->user->prenom}}<i style="font-size: 17px" class="material-icons color-success">person_pin</i></a>   
                                                @endif
                                            @endif
                                           
                                        </label> 
                                    </td>
                                    @endif
                                    <td  >
                                        <label class="color-info">{{$facture->type}} </label> 
                                    </td>
                                    <td   >
                                    {{number_format($facture->montant_ht,2,'.',' ')}} €
                                    </td>
                                    <td >
                                    {{number_format($facture->montant_ttc,2,'.',' ')}} €
                                    </td>
                                   
                                    
                                    <td  >
                                
                                        {{-- @if ($facture->compromis->je_porte_affaire == 0  || $facture->compromis->agent_id == auth::user()->id || ($facture->compromis->je_porte_affaire == 1 && $facture->compromis->est_partage_agent == 1) ) --}}
                                            @if ($facture->type == "partage" )
                                                <a target="blank" href="{{route('facture.preparer_facture_honoraire_partage',[Crypt::encrypt($facture->compromis->id), $facture->user_id ])}}" data-toggle="tooltip" title="@lang('Note honoraire  ')"><i class="large material-icons color-danger">insert_drive_file</i></a> 
                                            @elseif ($facture->type == "partage_externe" )
                                                <a target="blank" href="{{route('facture.preparer_facture_honoraire_partage_externe',[Crypt::encrypt($facture->compromis->id), $facture->user_id ])}}" data-toggle="tooltip" title="@lang('Note partage externe  ')"><i class="large material-icons color-danger">insert_drive_file</i></a> 

                                          
                                            @elseif($facture->type == "parrainage_partage" || $facture->type == "parrainage")
                                                <a target="blank" href="{{route('facture.preparer_facture_honoraire_parrainage',[Crypt::encrypt($facture->compromis->id), $facture->user_id])}}" data-toggle="tooltip" title="@lang('Note honoraire parrainnage ')"><i class="large material-icons color-danger">insert_drive_file</i></a> 
                                            
                                            @else 
                                                <a target="blank" href="{{route('facture.preparer_facture_honoraire',Crypt::encrypt($facture->compromis->id))}}" data-toggle="tooltip" title="@lang('Note honoraire  ')"><i class="large material-icons color-danger">insert_drive_file</i></a> 
                                                
                                            @endif
                        
                                    </td> 
                                    <td width="" >                                            
                                        <a href="{{route('facture.telecharger_pdf_facture', Crypt::encrypt($facture->id))}}"  class=" btn btn-warning btn-flat btn-addon m-b-10 m-l-5 " id="telecharger"><i class="ti-download"></i> Télécharger</a>
                                    </td>

                                    <td width="" >
                                        <a href="{{route('facture.valider_honoraire', [1,Crypt::encrypt($facture->id)] )}}"  class="btn btn-success btn-flat btn-addon  m-b-10 m-l-5 valider" id="valider"><i class="ti-check"></i>Valider</a>
                                        <a href="{{route('facture.valider_honoraire', [0,Crypt::encrypt($facture->id)] )}}"  class="btn btn-danger btn-flat btn-addon  m-b-10 m-l-5 refuser" id="refuser"><i class="ti-close"></i>Refuser</a>
                                    </td>
                                </tr> 
                           
                        @endforeach
                          </tbody>
                        </table>
                    </div>
                </div>
            </div>


<div class="container">

    <!-- Trigger the modal with a button -->
    {{-- <button type="button" class="btn btn-info btn-lg" id="myBtn">Open Modal</button> --}}
  
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog modal-sm">
      
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Date de règlement</h4>
          </div>
          <div class="modal-body">
            <p><form action="" method="get" id="form_regler">
                    <div class="modal-body">
                      
                            <div class="col-lg-offset-2  col-md-offset-2 col-sm-offset-2 col-lg-4 col-md-4 col-sm-4">
                                <div class="form-group row">
                                    <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="date_reglement">Date de règlement <span class="text-danger">*</span> </label>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <input type="date"  class="form-control {{ $errors->has('date_reglement') ? ' is-invalid' : '' }}" value="{{old('date_reglement')}}" id="date_reglement" name="date_reglement" required >
                                        @if ($errors->has('date_reglement'))
                                        <br>
                                        <div class="alert alert-warning ">
                                            <strong>{{$errors->first('date_reglement')}}</strong> 
                                        </div>
                                        @endif   
                                    </div>
                                </div>
                            </div>
                      </p>
          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-success" id="valider_reglement"  value="Valider" />
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
    </form> 
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
            title: '@lang('Vraiment archiver cet compromis  ?')',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: '@lang('Oui')',
            cancelButtonText: '@lang('Non')',
            
        }).then((result) => {
            if (result.value) {
                $('[data-toggle="tooltip"]').tooltip('hide')
                    $.ajax({                        
                        url: that.attr('href'),
                        type: 'PUT'
                    })
                    .done(function () {
                            that.parents('tr').remove()
                    })

                swalWithBootstrapButtons(
                'Archivé!',
                'L\'compromis a bien été archivé.',
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
            })
        })
    </script>

      
  <script>

//###Valider la facture      

    $(function() {
       $.ajaxSetup({
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
       })
       
      
       $('[data-toggle="tooltip"]').tooltip()
       $('body').on('click','a.valider',function(e) {
          let that = $(this)
      
          e.preventDefault()
          const swalWithBootstrapButtons = swal.mixin({
          confirmButtonClass: 'btn btn-success',
          cancelButtonClass: 'btn btn-danger',
          buttonsStyling: false,
          })

    swalWithBootstrapButtons({
       title: '@lang('Voulez-vous vraiment valider la facture ?')',
       type: 'warning',
       showCancelButton: true,
       confirmButtonColor: '#DD6B55',
       confirmButtonText: '@lang('Oui')',
       cancelButtonText: '@lang('Non')',
       
    }).then((result) => {
       if (result.value) {
          $('[data-toggle="tooltip"]').tooltip('hide')
                $.ajax({                        
                   url: that.attr('href'),
                   type: 'GET',
                   success: function(data){
                     document.location.reload();
                   },
                   error : function(data){
                      console.log(data);
                   }
                })
                .done(function () {
                      
                })

          swalWithBootstrapButtons(
          'Validée!',
          'Le mandatataire sera notifié par mail.',
          'success'
          )
          
          
       } else if (
          // Read more about handling dismissals
          result.dismiss === swal.DismissReason.cancel
       ) {
          swalWithBootstrapButtons(
          'Annulé',
          'Aucune validation effectuée :)',
          'error'
          )
       }
    })
       })
    })



// ###  Refuser la facture


    $(function() {
       $.ajaxSetup({
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
       })
       
      
       $('[data-toggle="tooltip"]').tooltip()
       $('body').on('click','a.refuser',function(e) {
          let that = $(this)
      
          e.preventDefault()
          const swalWithBootstrapButtons = swal.mixin({
          confirmButtonClass: 'btn btn-success',
          cancelButtonClass: 'btn btn-danger',
          buttonsStyling: false,
          })

    swalWithBootstrapButtons({
       title: '@lang('Voulez-vous vraiment refuser la facture ?')',
       type: 'warning',
       showCancelButton: true,
       confirmButtonColor: '#DD6B55',
       confirmButtonText: '@lang('Oui')',
       cancelButtonText: '@lang('Non')',
       
    }).then((result) => {
       if (result.value) {
          $('[data-toggle="tooltip"]').tooltip('hide')
                $.ajax({                        
                   url: that.attr('href'),
                   type: 'GET',
                   success: function(data){
                     document.location.reload();
                   },
                   error : function(data){
                      console.log(data);
                   }
                })
                .done(function () {
                      
                })

          swalWithBootstrapButtons(
          'Refusée!',
          'Le mandatataire sera notifié par mail.',
          'success'
          )
          
          
       } else if (
          // Read more about handling dismissals
          result.dismiss === swal.DismissReason.cancel
       ) {
          swalWithBootstrapButtons(
          'Annulé',
          'Aucune action effectuée :)',
          'error'
          )
       }
    })
       })
    })
</script>
@endsection