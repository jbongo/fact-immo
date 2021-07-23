
<?php 

use App\Facture;
use Illuminate\Support\Facades\DB;


// Retourne la facture stylimmo lié à l'voir passé en paramètre
function get_facture_avoir ($facture_id){

// $facture = Facture::where('id',$facture_id)->first();
$facture = DB::table('factures')->where('id',$facture_id)->first();


return $facture;
}