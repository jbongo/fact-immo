<button class="btn btn-success btn-rounded btn-addon btn-sm m-b-10 m-l-5" id="show_form_compromis"><i class="ti-plus"></i>@lang('Ajouter')</button>
                  <!--form conditions-->
                  <div class="form-validation form_conditions_suspensives" hidden="true">
                     <form class="form-horizontal form-condition_compromis" action="#" method="post">
                        @csrf
                        <div class="form-group row">
                           <label class="col-sm-4 control-label" for="intitule">Intitulé de la condition suspensive<span class="text-danger">*</span></label>
                           <div class="col-lg-3">
                              <input type="text" id="intitule" class="form-control" value="" name="intitule" required>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label class="col-sm-4 control-label" for="fin_condition">Date butoir (Optionel)</label>
                           <div class="col-lg-3">
                              <input type="date" min="" id="fin_condition" class="form-control" value="" name="fin_condition" required>
                           </div>
                        </div>
                        <div class="form-group row" style="text-align: center;">
                           <button type="submit" id="compromis_check" class="btn btn-primary submitcondition"><strong>Valider</strong></button>
                        </div>
                     </form>
                  </div>
                  <!--end form-->
                  <div class="table-responsive lst_conditions" style="overflow-x: inherit !important;">
                     <table id="document_mandant_list" class="table table-hover table-striped">
                        <thead>
                           <tr>
                              <th>@lang('Intitulé')</th>
                              <th>@lang('Statut')</th>
                              <th>@lang('Date butoir')</th>
                              <th>@lang('Action')</th>
                           </tr>
                        </thead>
                        <tbody>
                           @if($compromis_actif != NULL)
                           @foreach ($compromis_actif->conditionoffres as $one)
                           <tr>
                              <td><strong>{{$one->intitule}}</strong></td>
                              <td>
                                 @if($one->statut === "En cours")
                                 <span class="badge badge-warning">{{$one->statut}}</span>
                                 @elseif($one->statut === "Accomplie")
                                 <span class="badge badge-success">{{$one->statut}}</span>
                                 @else
                                 <span class="badge badge-danger">{{$one->statut}}</span>
                                 @endif
                              </td>
                              <td><strong>{{date('d/m/Y',strtotime($one->date_fin))}}</strong></td>
                              <td>
                                 @if($one->statut === "En cours")
                                 <span><a class="confirm_condition" href="{{route('suiviaffaire.offre.condition.action', [CryptId($one->id), "Accomplie"])}}" data-toggle="tooltip" title="Valider la condition"><i class="large material-icons color-success">check</i></a> </span>
                                 <span><a class="reject_condition" href="{{route('suiviaffaire.offre.condition.action', [CryptId($one->id), "Non accomplie"])}}" data-toggle="tooltip" title="Ajourner la condition"><i class="large material-icons color-danger">close</i></a> </span>
                                 @endif
                              </td>
                           </tr>
                           @endforeach
                           @endif
                        </tbody>
                     </table>
                  </div>