<div class="col-lg-4">
    <div class="panel panel-pink lobipanel-basic">
       <div class="panel-heading"><strong>Etat actuel</strong></div>
       <div class="panel-body" style="background:radial-gradient(circle, rgba(206, 188, 188, 0.41) 0%, rgb(240, 240, 240) 100%);">
          <ul class="timeline">
             <li class="timeline-item">
                <div class="timeline-badge {{$state['diffusion']}}"><i class="glyphicon {{$icon[0]}}"></i></div>
                <div class="timeline-panel">
                   <div class="timeline-heading">
                      <h4 class="timeline-title"><strong class="color-{{$state['diffusion']}}">Bien en diffusion</strong></h4>
                   </div>
                </div>
             </li>
             <li class="timeline-item">
                <div class="timeline-badge {{$state['offre']}}"><i class="glyphicon {{$icon[1]}}"></i></div>
                <div class="timeline-panel">
                   <div class="timeline-heading">
                      <h4 class="timeline-title"><strong class="color-{{$state['offre']}}">Offre</strong></h4>
                   </div>
                </div>
             </li>
             <li class="timeline-item">
                <div class="timeline-badge {{$state['compromis']}}"><i class="glyphicon {{$icon[2]}}"></i></div>
                <div class="timeline-panel">
                   <div class="timeline-heading">
                      <h4 class="timeline-title"><strong class="color-{{$state['compromis']}}">Compromis</strong></h4>
                   </div>
                </div>
             </li>
             <li class="timeline-item">
                <div class="timeline-badge {{$state['acte']}}"><i class="glyphicon {{$icon[3]}}"></i></div>
                <div class="timeline-panel">
                   <div class="timeline-heading">
                      <h4 class="timeline-title"><strong class="color-{{$state['acte']}}">Acte</strong></h4>
                   </div>
                </div>
             </li>
             <li class="timeline-item">
                <div class="timeline-badge {{$state['cloture']}}"><i class="glyphicon {{$icon[4]}}"></i></div>
                <div class="timeline-panel">
                   <div class="timeline-heading">
                      <h4 class="timeline-title"><strong class="color-{{$state['cloture']}}">Cloture</strong></h4>
                   </div>
                </div>
             </li>
          </ul>
       </div>
    </div>
    <div class="card p-0" style="border: 3px solid #ff7923; border-radius: 10px;background: radial-gradient(circle, rgb(255, 239, 222) 0%, rgb(224, 244, 255) 100%);">
      <div class="media">
         <div class="p-20 bg-default-dark media-left media-middle">
             <img style="border-radius: 10px;width: 185px;position: relative;height: 155px;object-fit: cover; border: 7px solid #af99ad;" src='https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcRWQuWU3bnjXH-g8yL_2YC9BQBzzEQQbInghDKmovIstsANG7dh' alt=''>
         </div>
         <div class="p-20 media-body">
             <h4><strong style="color:#2cabe0;">Bien</strong></h4>
            <p>5 pièces 120 m² Maison de campagne.</p>
            <strong>06300 Nice</strong>
            <a type="button" href="#" target="blanc" class="btn btn-warning btn-outline btn-rounded m-b-10 m-l-5">Voir</a>
         </div>
      </div>
   </div>
 </div>