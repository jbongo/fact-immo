<!DOCTYPE html>
<html>
  <head>
    <title>Fiche Info</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <style>
      html, body {
      min-height: 100%;
      }
      body, div, form, input, select, textarea, p { 
      padding: 0;
      margin: 0;
      outline: none;
      font-family: Roboto, Arial, sans-serif;
      font-size: 14px;
      color: #666;
      line-height: 22px;
      }
      h1 {
      position: absolute;
      margin: 0;
      font-size: 32px;
      color: #fff;
      z-index: 2;
      }
      .testbox {
      display: flex;
      justify-content: center;
      align-items: center;
      height: inherit;
      padding: 20px;
      }
      form {
      width: 100%;
      padding: 20px 200px 20px 200px;
      border-radius: 6px;
      background: #fff;
      box-shadow: 0 0 230px 0 #4282bf; 
      }
      .banner {
      /* position: relative; */
      height: 210px;
      /* background-image: url("/images/fiche_info2.jpg");   */
      background-size: cover;
  
    
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: #0aa0d9; 
      
      text-align: center;
      }
      
      .banner > img {
        z-index:1;
      }
      .banner::after {
      content: "";
      /* position: absolute; */
      width: 100%;
      height: 100%;
      }
      p.top-info {
      margin: 10px 0;
      }
      input, select, textarea {
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 3px;
      }
      input {
      /* width: calc(100% - 10px); */
      padding: 5px;
      }
      select {
      width: 100%;
      padding: 7px 0;
      background: transparent;
      }
      textarea {
      width: calc(100% - 12px);
      padding: 5px;
      }
      .item:hover p, .item:hover i, .question:hover p, .question label:hover, input:hover::placeholder {
      color: #8ebf42;
      }
      .item input:hover, .item select:hover, .item textarea:hover {
      border: 1px solid transparent;
      box-shadow: 0 0 8px 0 #223646;
      color: #8ebf42;
      }
      .item {
      position: relative;
      margin: 10px 0;
      }
      input[type="date"]::-webkit-inner-spin-button {
      display: none;
      }
      .item i, input[type="date"]::-webkit-calendar-picker-indicator {
      position: absolute;
      font-size: 20px;
      color: #a9a9a9;
      }
      .item i {
      right: 2%;
      top: 30px;
      z-index: 1;
      }
      [type="date"]::-webkit-calendar-picker-indicator {
      right: 1%;
      z-index: 2;
      opacity: 0;
      cursor: pointer;
      }
      /* input[type=radio] {
      width: 0;
      visibility: hidden;
      } */
      /* label.radio {
      position: relative;
      display: inline-block;
      margin: 5px 20px 25px 0;
      cursor: pointer;
      }
      .question span {
      margin-left: 30px;
      }
      label.radio:before {
      content: "";
      position: absolute;
      left: 0;
      width: 17px;
      height: 17px;
      border-radius: 50%;
      border: 2px solid #8ebf42;
      } */
      /* label.radio:after {
      content: "";
      position: absolute;
      width: 8px;
      height: 4px;
      top: 6px;
      left: 5px;
      background: transparent;
      border: 3px solid #8ebf42;
      border-top: none;
      border-right: none;
      transform: rotate(-45deg);
      opacity: 0;
      } */
      /* input[type=radio]:checked + label:after {
      opacity: 1;
      } */
      .btn-block {
      margin-top: 10px;
      text-align: center;
      }
      button {
      width: 150px;
      padding: 10px;
      border: none;
      border-radius: 5px; 
      background: #223646;
      font-size: 16px;
      color: #fff;
      cursor: pointer;
      }
      button:hover {
      background: #0aa0d9;
      }
      @media (min-width: 568px) {
      .name-item, .city-item {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      }
      .name-item input, .city-item input {
      width: calc(50% - 20px);
      }
      .city-item select {
      width: calc(50% - 8px);
      }
      }
    </style>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  </head>
  
  
  
  
  
  
  
  <body>
    <div class="testbox">
    <form action="{{route('bibliotheque.reponseuser', [$document->id, $user_id, $type_user])}} " method="POST" enctype="multipart/form-data">
    @csrf
        <div class="banner">
        
        <img src="{{asset('/images/logo.jpg')}}" width="400px" alt="">
          <h1>{{$document->nom}}</h1>
        </div>
        <br>
        @if (session('ok'))
          <div class="alert alert-success ">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <a href="#" class="alert-link"><strong> {{ session('ok') }}</strong></a> 
          </div>
        @endif       
       <br>

       
       <hr style="border-top: 4px solid #3e3a92">
       <br>
       
        <br>
        <a href="{{route('bibliotheque.telecharger', $document->id)}}" data-toggle="tooltip" title="Télécharger {{$document->nom}}"  class="btn btn-danger btn-flat btn-addon "><i class="ti-download"></i>Télécharger</a>    
        
        <div class="row">
        
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
                <iframe src ="/bibliotheques/{{$pdf}}" width="100%" height="900px"></iframe>
            
            </div>
          {{-- {{  $document->url}} --}}
            
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
            
                <div class="form-row item">
                    <div class="form-group col-12">
                      <label for="question1">Avez-vous lu et compris le document   <span>*</span> </label>
                      <select name="question1" id="question1" required>
                            <option value=""></option>
                            <option value="Oui">Oui</option>
                            <option value="Non">Non</option>
                      </select>
                    </div>
                    
                    @if ($errors->has('question1'))
                       <br>
                       <div class="alert alert-warning ">
                          <strong>{{$errors->first('question1')}}</strong> 
                       </div>
                     @endif
                   
                </div>
                
                <div class="btn-block">
                    <button type="submit" >Valider</button>
                </div>
            
            </div>
        </div>
        
        
        

        
        
    
    
        
       <br>
       <br>       
       <hr style="border-top: 4px solid #3e3a92">
       <br>
       

      

      
   
     
      
     

        
        <br>

        
        
        <br><br>
        
       
      </form>
    </div>
    
    
  
    
    
    
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>

 