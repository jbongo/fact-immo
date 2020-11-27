
 
                <!-- table -->
                
                <div class="row">
                
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <span style="font-size: 18px; font-weight:bold">Total H à payer TTC : </span> <span style="font-size: 18px; color:red; font-weight:bold"> {{number_format( $totalApayer ,2,'.',',')}} </span> <br>
                
                    <span style="font-size: 20px; font-weight:bold">+</span> <br>
                    
                    <span style="font-size: 18px; font-weight:bold">Total H non ajouté TTC : </span> <span style="font-size: 18px; color:blue; font-weight:bold"> {{number_format( $totalNonAjou ,2,'.',',')}} </span>
                    <hr>
                    <span style="font-size: 20px; font-weight:bold">Total : </span> <span style="font-size: 20px; color:rgb(222, 21, 198); font-weight:bold"> {{number_format( $totalNonAjou + $totalApayer ,2,'.',',')}} </span>
                </div>
                
                </div>
                
                 
 
            </div>
        <!-- end table -->
        