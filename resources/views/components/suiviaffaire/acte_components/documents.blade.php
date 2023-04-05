<!--documents-->
<div class="panel lobipanel-basic panel-pink">
    <div class="panel-heading">
       <div class="panel-title">Suivi des documents pour l'acte</div>
    </div>
    <div class="panel-body">
       Simplifiez vous la vie avec une liste pour le suivi de tous les documents necessaires à la transaction, une fois les documents validés 
       vous pouvez les envoyer au notaire en un seul clique ce qui accelère considérablement le traitement du dossier 
       avant la signature du compromis et de l'acte de vente.
    </div>
 </div>
 <div class="card alert">
    <div class="card-body">
       <div class="progress">
          <div class="progress-bar progress-bar-pink progress-bar-striped active w-{{$bar}}" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
             <strong>{{$percent}}%</strong>
          </div>
       </div>
       <br>
       <div class="col-md-6">
          <h5 style="font-weight: bold; color: #ffffff; text-decoration: underline; background: linear-gradient(to right, #57bdff, #9abae8, #60caff); padding: 10px; border: 1px solid #1ddaff; border-radius: 5px; text-align: center;">Documents mandant</h5>
          <br>
          <ul class="list-group">
             @if(unserialize($affaire->documents_mandant) != false)
             @foreach(unserialize($affaire->documents_mandant) as $key=>$one)
             @if($one["acte"] === 1)
             @if($one["statut"] === "Traitement")
             <li class="list-group-item" style="padding: 5px 4px; background:#fff7e3;"><strong>{{$one["nom"]}}</strong> <span class="badge badge-warning">{{$one["statut"]}}</span></li>
             @else
             <li class="list-group-item" style="padding: 5px 4px; background:#e3ffec;"><strong>{{$one["nom"]}}</strong> <span class="badge badge badge-success">{{$one["statut"]}}</span></li>
             @endif
             @endif
             @endforeach
             @endif
          </ul>
       </div>
       <div class="col-md-6">
          <h5 style="font-weight: bold; color: #ffffff; text-decoration: underline; background: linear-gradient(to right, #57bdff, #9abae8, #60caff); padding: 10px; border: 1px solid #1ddaff; border-radius: 5px; text-align: center;">Documents acquéreur</h5>
          <br>
          <ul class="list-group">
             @if(unserialize($affaire->documents_acquereur) != false)
             @foreach(unserialize($affaire->documents_acquereur) as $key=>$one)
             @if($one["acte"] === 1)
             @if($one["statut"] === "Traitement")
             <li class="list-group-item" style="padding: 5px 4px; background:#fff7e3;"><strong>{{$one["nom"]}}</strong> <span class="badge badge-warning">{{$one["statut"]}}</span></li>
             @else
             <li class="list-group-item" style="padding: 5px 4px; background:#e3ffec;"><strong>{{$one["nom"]}}</strong> <span class="badge badge badge-success">{{$one["statut"]}}</span></li>
             @endif
             @endif
             @endforeach
             @endif
          </ul>
       </div>
    </div>
 </div>
 <!--fin documents-->