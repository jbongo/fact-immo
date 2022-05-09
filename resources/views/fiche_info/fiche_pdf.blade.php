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
    <p style="text-align: left; font-size: 20px;"><strong>{{$key + 1}} \ {{$champ->nom}}</strong></p>
    
    
    
    @if($champ->site_web != null) <p style="text-align: left;"><span style="font-size: 16px; font-weight:600 ; ">Acc&egrave;s Web:&nbsp;&nbsp;</span>  <span style="color: blue;">{{$champ->site_web}}</span></p> @endif
    @if($champ->identifiant != null) <p style="text-align: left;"><span style="font-size: 16px; font-weight:600 ; ">Utilisateur:</span>  <span style="color: blue;">{{$champ->identifiant}}</span></p> @endif
    @if($champ->password != null) <p style="text-align: left;"><span style="font-size: 16px; font-weight:600 ; ">Mot de passe:&nbsp;</span>  <span style="color: red;">{{$champ->password}}</span></p> @endif
    @if($champ->autre_champ != null) <p style="text-align: left;"> <span>{!!$champ->autre_champ!!}</span></p> @endif
    {{-- <p style="text-align: left;">&nbsp;</p> --}}
@endforeach

