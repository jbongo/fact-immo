
<?php 

use App\Facture;
use Illuminate\Support\Facades\DB;


// Retourne la l'avoir de la factuyre stylimmo
function get_avoir_facture ($facture_id){

// $facture = Facture::where('facture_id',$facture_id)->first();

$facture = DB::table('factures')->where('facture_id',$facture_id)->first();


return $facture;
}