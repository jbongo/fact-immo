<div class="panel lobipanel-basic panel-dark">
    <div class="panel-heading">
        <div class="panel-title"><strong>Détails des documents</strong></div>
    </div>
    <div class="panel-body">
            <div class="card alert">
                    <div class="card-body">
                       <br>
                       <div class="col-md-6">
                          <h5 style="font-weight: bold; color: #ffffff; text-decoration: underline; background: linear-gradient(to right, #57bdff, #9abae8, #60caff); padding: 10px; border: 1px solid #1ddaff; border-radius: 5px; text-align: center;">Documents mandant</h5>
                          <br>
                          <ul class="list-group">
                             @if(unserialize($affaire->documents_mandant) != false)
                             @foreach(unserialize($affaire->documents_mandant) as $key=>$one)
                             @if(($one["compromis"] === 1 && $affaire->statut === "compromis") || ($one["acte"] === 1 && $affaire->statut === "acte"))
                             @if($one["statut"] === "Traitement")
                             <li class="list-group-item" style="padding: 5px 4px; background:#fff7e3;"><strong>{{$one["nom"]}}</strong> <span class="badge badge-warning">{{$one["statut"]}}</span></li>
                             @else
                             <li class="list-group-item" style="padding: 5px 4px; background:#e3ffec;"><strong>{{$one["nom"]}}</strong> <a href="#" class="badge badge badge-success">Télécharger</a></li>
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
                             @if(($one["compromis"] === 1 && $affaire->statut === "compromis") || ($one["acte"] === 1 && $affaire->statut === "acte"))
                             @if($one["statut"] === "Traitement")
                             <li class="list-group-item" style="padding: 5px 4px; background:#fff7e3;"><strong>{{$one["nom"]}}</strong> <span class="badge badge-warning">{{$one["statut"]}}</span></li>
                             @else
                             <li class="list-group-item" style="padding: 5px 4px; background:#e3ffec;"><strong>{{$one["nom"]}}</strong> <a href="#" class="badge badge badge-success">Télécharger</a></li>
                             @endif
                             @endif
                             @endforeach
                             @endif
                          </ul>
                       </div>
                    </div>
                 </div>
    </div>
</div>