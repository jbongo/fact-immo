
 
                <!-- table -->
    <div class="card-body">
        <div class="panel panel-info ">
           <div class="panel-body">
             
                          
                <div class="row">
                
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <span style="font-size: 18px; font-weight:bold"> Total montant TVA  <span style="color: #abc; font-size: 15px;">(H à Payer + H non ajouté) </span>: </span> <span style="font-size: 18px; color:red; font-weight:bold"> {{number_format( $motantTvaFAPayer + $motantTvaFNonAjou ,2,'.',',')}} </span> <br><br>
                    
                        
                        <span style="font-size: 18px; font-weight:bold"> Total HT <span style="color: #abc; font-size: 15px;">(H à Payer + H non ajouté) </span> : </span> <span style="font-size: 18px; color:blue; font-weight:bold"> {{number_format( $totalApayer_HT + $totalNonAjou_HT ,2,'.',',')}} </span>
                        <hr>
                        <span style="font-size: 20px; font-weight:bold"> Total A Payer <span style="color: #abc; font-size: 15px;">(H à Payer + H non ajouté) </span> : </span> <span style="font-size: 20px; color:rgb(222, 21, 198); font-weight:bold"> {{number_format( $totalNonAjou + $totalApayer ,2,'.',',')}} </span>
                    </div>
                
                </div>
                
                 
 
           
        </div>
     </div>
  </div>

        <!-- end table -->
    