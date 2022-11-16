<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Goggle place adresse</title>
</head>
<body>
    
    
    <form action="" method="post">
        
        <input type="text" name="adresse" id="autocomplete" placeholder="adresse" style="width: 600px;">
        <input type="text" value="" name="code_postal" id="code_postal" placeholder="code_postal">
        <input type="text" value="" name="ville" id="ville" placeholder="ville">
    
    </form>

<script>                    
    let autocomplete;
    function initAutocomplete(){
            autocomplete = new google.maps.places.Autocomplete(
                document.getElementById('autocomplete'),
                {
                    types:['address'],
                    componentRestrictions: {'country': ['FR']},
                    fields:['address_components', 'address_components','adr_address', 'formatted_address', 'name','vicinity']
                }
            
            )
            
            autocomplete.addListener('place_changed', onPlaceChanged);
           
    }
    
    function onPlaceChanged(){
        
        var place = autocomplete.getPlace();
        
        if(!place.name){
            document.getElementById('autocomplete').placeholder = "Ajoutez une adresse valide";
        }else{
            document.getElementById('autocomplete').value = place.name;
            document.getElementById('ville').value = place.vicinity;
            document.getElementById('code_postal').value = place.address_components[6].long_name;
            
        }
    }
</script>
    <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCD0y8QWgApdFG33-i8dVHWia-fIXcOMyc&libraries=places&callback=initAutocomplete" async defer>
        
       
    </script>
</body>
</html>