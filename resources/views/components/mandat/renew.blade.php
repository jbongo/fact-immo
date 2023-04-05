<div class="modal fade" id="mandat_renew" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
           <div class="modal-content">
              <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel"><strong>Prolonger un mandat expiré</strong></h5>
              </div>
              <div class="modal-body">
               <div class="panel lobipanel-basic panel-warning">
                  <div class="panel-heading">
                     <div class="panel-title">Notice</div>
                  </div>
                  <div class="panel-body">
                     La prolongation ou la reconduction tacite d'un mandat expiré implique l'accord du mandant au préalable, assurez vous d'avoir cet accord avant de prolonger le mandat.
                  </div>
               </div>
               <br>
                 <div class="form-validation">
                    <form class="form-appel form-horizontal form-valid-mandat" action="{{route('mandat.renew', CryptId($mandat->id))}}" method="post">
                     @csrf
                     <div class="form-group row @if($errors->has('duration'))has-error @endif">
                        <label class="col-sm-4 control-label" for="duration">Durée de la prolongation (mois)</label>
                        <div class="col-lg-3">
                           <input type="number" min="3" max="36" value="3" id="duration" class="form-control {{$errors->has('duration') ? 'is-invalid' : ''}}"  name="duration" required>
                        </div>
                     </div>
                       <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                          <button type="submit" class="btn btn-primary submitappel">valider</button>
                       </div>
                    </form>
                 </div>
              </div>
           </div>
        </div>
     </div>