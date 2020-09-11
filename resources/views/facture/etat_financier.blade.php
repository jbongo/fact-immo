@extends('layouts.app')
@section('content')
@section ('page_title')
Etat financier
@endsection

<div class="row">
    <div class="col-md-3">
        <label>Date de début</label>
            <input type="date" required name="date_deb" id="date_deb" value="{{$date_deb}}" class="form-control">
    </div>

    <div class="col-md-3">
        <label>Date de fin</label>
            <input type="date" required name="date_fin" id="date_fin" value="{{$date_fin}}" class="form-control">
    </div>
    <div class="col-md-2">
        <label>.</label>

        <button id="btn_valider" class="btn btn-danger form-control">Valider</button>
    </div>
</div>
<div class="row">
   <div class="col-lg-12 col-md-12 col-sm-12">
      @if (session('ok'))
      <div class="alert alert-success alert-dismissible fade in">
         <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
         <strong> {{ session('ok') }}</strong>
      </div>
      @endif      
      <div class="card">
          <div class="row">
              <div class="col-lg-12">
                TOTAL ENCAISSE STYL :  <strong><span style="font-size:24px" class="color-success"> {{number_format($total_encaisse,'2','.',' ')}} €</span></strong> <br>
                TOTAL RESTE A PAYER :  <strong><span style="font-size:24px" class="color-danger"> {{number_format($total_reste_a_payer,'2','.',' ')}} €</span></strong><br>
                TOTAL TVA A PAYER :  <strong><span style="font-size:24px" class="color-warning"> {{number_format($total_tva_a_payer,'2','.',' ')}} €</span></strong><br>
                
            </div>

         </div>
         <div class="card-body">
                    <div class="panel panel-default m-t-15" id="cont">
                        <div class="panel-heading"></div>
                        <div class="panel-body">

                        <div class="table-responsive" >
                            <table  id="example3" class=" table student-data-table  table-striped table-hover dt-responsive display    "  style="width:100%"  >
                                <thead>
                                    <tr>
                                    
                                        <th>@lang('Facture Stylimmo')</th>
                                        {{-- <th>@lang('Mandat')</th> --}}

                                        <th>@lang('Encaissé ')</th>
                                        <th>@lang('Encaissé TVA ')</th>
                                        <th>@lang('Total dû ')</th>
                                        <th>@lang('Total dû TVA ')</th>

                                        <th>@lang('Reste à payer ')</th>
                                        <th>@lang('TVA à verser')</th>
                                        <th></th>


                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($etats as $etat)

                                    @php 
                                    $print = false;
                                        if($etat['facture_styl']->date_encaissement >= $date_deb && $etat['facture_styl']->date_encaissement <= $date_fin ){
                                            $print = true;
                                        }

                                    @endphp
                                    <tr>
                                    
                                        <td width="" >
                                            <label class="">{{$etat['numero_styl']}} </label>                                  
                                        </td>
                                        {{-- <td width="" >
                                            <label class="">{{$etat['numero_mandat']}} </label>                                  
                                        </td>
                                        --}}
                                        
                                        <td  width="" >
                                           @if($print == true)
                                            <strong><span  style="color:#3b8d30"> {{number_format($etat['montant_styl_ttc'],'2',',','')}} </span></strong>
                                            @endif
                                          
                                        </td>
                                        <td  width="" >
                                           @if($print == true)
                                            <strong><span  style="color:#3b8d30"> {{number_format($etat['montant_styl_tva'],'2',',','')}} </span></strong>
                                            @endif
                                        </td>
                                        <td  width="" >
                                            <span class=""> {{number_format($etat['total_du_ht'] + $etat['total_du_tva'],'2',',','')}} </span>
                                        </td>
                                        <td  width="" >
                                            <span class=""> {{number_format($etat['total_du_tva'],'2',',','')}} </span>
                                        </td>
                                        <td  width="" >
                                            <strong><span class="color-danger"> {{number_format($etat['reste_a_regler'],'2',',','')}} </span></strong>
                                        </td>
                                        <td  width="" >
                                            <strong><span class="color-danger"> {{number_format($etat['tva_a_regler'],'2',',','')}} </span></strong>
                                        </td>
                                    <td></td>
                                        
                            
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


@stop
@section('js-content') 


<script>

    $('#btn_valider').on('click',function(){

    var date_deb = $('#date_deb').val();
    var date_fin = $('#date_fin').val();
      window.location.href = "/etat-financier/"+date_deb+"/"+date_fin;
    // console.log( $('#annee').val());
    
    })
</script>
@endsection