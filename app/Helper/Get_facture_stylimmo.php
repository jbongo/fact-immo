<?php 

Use App\Facture;

// Obtenir une facture stylimmo à partiur d'un compromis

function get_facture_stylimmo($compromis_id){


$facture = DB::table('factures')->where([['compromis_id', $compromis_id],['type','stylimmo'],['a_avoir', false]])->first();


return $facture;
}