
 
                <!-- table -->
                <label class="color-danger" style="font-size:16px; font-weight: bold">NB: Ajoutez le numéro de la facture à régler dans la description de votre virement ! </label> 
                
                <div class="card-body">
                    <div class="panel panel-default m-t-15" id="cont">
                            <div class="panel-heading"></div>
                            <div class="panel-body">


                    <div class="table-responsive" >
                        <table  id="example3" class=" table student-data-table  table-striped table-hover dt-responsive display    "  style="width:100%"  >
                            <thead>
                                <tr>
                                   
                                    <th>@lang('Numéro ')</th>
                                    <th>@lang('Type ')</th>
                                    <th>@lang('Montant HT ')</th>
                                    <th>@lang('Montant TTC ')</th>
                                    <th>@lang('Pour le mois de')</th>
                                   
                                    <th>@lang('Régler')</th>
                                    {{-- <th>@lang('Action')</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                            
                                @php 
                                $mois = Array('','Janvier','Février','Mars','Avril', 'Mai','Juin','Juillet','Aôut', 'Septembre','Octobre','Novembre','Décembre');
                                @endphp
                            
                            
                                @foreach ($factureCommunications as $facture)

                                <tr>
                                
                                    <td  >
                                        <a class="color-info" data-toggle="tooltip"  title="Télécharger la facture {{$facture->numero}} "  href="{{route('facture.telecharger_pdf_facture', Crypt::encrypt($facture->id))}}"  class="  m-b-10 m-l-5 " id="ajouter">{{$facture->numero}} <i class="ti-download"></i> </a>                                        
                                    </td>
                                    <td  >
                                        <label class="color-info">{{$facture->type}} </label> 
                                    </td>
                                    <td  >
                                        <label class="color-warning">{{$facture->montant_ht}} </label> 
                                    </td>
                                    
                                    <td  >
                                        <label class="color-warning">{{$facture->montant_ttc}} </label> 
                                    </td>
                                    
                                    <td >
                                        @if($facture->type == "pack_pub")
                                            <span class="badge badge-warning"> @if($facture->factpublist() != null ) {{ $mois[$facture->factpublist()->created_at->format('m')*1]}} @endif</span> 
                                        @else 
                                            <span class="badge badge-warning"> {{ $mois[$facture->created_at->format('m')*1]}}</span> 
                                        @endif
                                    </td>
                                   
                                  

                                    <td>
                                        @if($facture->reglee == 0)
                                   
                                            <button data-toggle="modal"   data-target="#myModal2" onclick="getIdPayer('{{Crypt::encrypt($facture->id)}}')" id="{{Crypt::encrypt($facture->id)}}"  class="btn btn-success btn-flat btn-addon  m-b-10 m-l-5 payer" ><i class="ti-wallet"></i>
                                               A payer</button>
                                        
                                        @else 
                                            <label class="color-warning">@if($facture->date_reglement != null) Réglée le {{$facture->date_reglement->format('d/m/Y')}} @else Réglée @endif</label> 
                                        @endif 
                                    </td>
                                  
                                    {{--  paiement--}}
                                    @php
                                        // $datevente = date_create($facture->compromis->date_vente->format('Y-m-d'));
                                        // $today = date_create(date('Y-m-d'));
                                        // $interval = date_diff($today, $datevente);
                                    @endphp
                                  
                           

                                    
                               
                                    
                                  

                              
                                </tr> 
                           
                        @endforeach
                          </tbody>
                        </table>
                    </div>
                </div>
            </div>



{{-- Règlement dela facture --}}
            <div class="modal fade" id="myModal2" role="dialog">
                <div class="modal-dialog modal-sm">
                
                  <!-- Modal content-->
                  <div class="modal-content col-lg-offset-4  col-md-offset-4 col-sm-offset-4 col-lg-4 col-md-4 col-sm-4">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Date de règlement</h4>
                    </div>
                    <div class="modal-body">
                    <p><form action="" id="form_regler_pub">
                              <div class="modal-body">
                                @csrf
                                      <div class="">
                                          <div class="form-group row">
                                              <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="date_reglement_pub">Date de règlement <span class="text-danger">*</span> </label>
                                              <div class="col-lg-8 col-md-8 col-sm-8">
                                                  <input type="date"  class="form-control {{ $errors->has('date_reglement_pub') ? ' is-invalid' : '' }}" value="{{old('date_reglement_pub')}}" id="date_reglement_pub" name="date_reglement_pub" required >
                                                  @if ($errors->has('date_reglement_pub'))
                                                  <br>
                                                  <div class="alert alert-warning ">
                                                      <strong>{{$errors->first('date_reglement_pub')}}</strong> 
                                                  </div>
                                                  @endif   
                                              </div>
                                          </div>
                                      </div>
                                </p>
                    </div>
                    <div class="modal-footer">
                      <input type="submit" class="btn btn-success" id="valider_reglement_pub"  value="Valider" />
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </div>
              </form> 
                </div>
              </div>

{{-- <div class="container"> --}}


    
  {{-- </div>               --}}


            </div>
            </div>
        <!-- end table -->
        