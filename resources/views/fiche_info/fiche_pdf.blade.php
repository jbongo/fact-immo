<p><img style="display: flex; justify-content: center; width: 30%;" src="https://www.stylimmo.com/images/logo.jpg" /></p>
{{-- <p>&nbsp;</p>
<p>&nbsp;</p>
<p>Bonjour vous trouverez ci-dessous votre fiche personnalis&eacute;e avec vos codes d'acc&egrave;s pour tous les outils necessaires.</p>
<p>Restant &agrave; votre enti&egrave;re disposition !</p> --}}

{{-- <p style="text-align: rigth;">Jean-Pierre VASILE</p> --}}
<p style="text-align: center;">&nbsp;</p>
<h2 style="text-align: center;"><strong>FICHE OUTILS</strong></h2>
<p style="text-align: center;">{{$mandataire->prenom}} {{$mandataire->nom}} </p>
<p style="text-align: center;">&nbsp;</p>


@foreach ($champs as $key => $champ )
    <p style="text-align: left; font-size: 20px;"><strong>{{$key + 1}} \ {{$champ[0]}}</strong></p>
    
    
    
    @if($champ[1] != null) <p style="text-align: left;"><span style="font-size: 16px; font-weight:600 ; ">Acc&egrave;s Web:&nbsp;&nbsp;</span>  <span style="color: blue;">{{$champ[1]}}</span></p> @endif
    @if($champ[2] != null) <p style="text-align: left;"><span style="font-size: 16px; font-weight:600 ; ">Utilisateur:</span>  <span style="color: blue;">{{$champ[2]}}</span></p> @endif
    @if($champ[3] != null) <p style="text-align: left;"><span style="font-size: 16px; font-weight:600 ; ">Mot de passe:&nbsp;</span>  <span style="color: red;">{{$champ[3]}}</span></p> @endif
    @if($champ[4] != null) <p style="text-align: left;"> <span>{!!$champ[4]!!}</span></p> @endif
    {{-- <p style="text-align: left;">&nbsp;</p> --}}
@endforeach

