function autocomplete_cp_ville( cp_id,  cp_name, ville_id, ville_name, adresse_id=null, adresse_name = null ){
    $(cp_id).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "https://api-adresse.data.gouv.fr/search/?postcode="+$("input[name="+cp_name+"]").val(),
                data: { q: request.term },
                dataType: "json",
                success: function (data) {
                    var postcodes = [];
                    response($.map(data.features, function (item) {
                        // Ici on est obligé d'ajouter les CP dans un array pour ne pas avoir plusieurs fois le même
                        if ($.inArray(item.properties.postcode, postcodes) == -1) {
                            postcodes.push(item.properties.city);
                            return { label: item.properties.postcode + " - " + item.properties.city, 
                                    city: item.properties.city,
                                    value: item.properties.postcode
                            };
                        }
                    }));
                }
            });
        },
        // On remplit aussi la ville
        select: function(event, ui) {
            $(ville_id).val(ui.item.city);
        }
    });

    $(ville_id).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "https://api-adresse.data.gouv.fr/search/?city="+$("input[name="+ville_name+"]").val(),
                data: { q: request.term },
                dataType: "json",
                success: function (data) {
                    var cities = [];
                    response($.map(data.features, function (item) {
                        // Ici on est obligé d'ajouter les villes dans un array pour ne pas avoir plusieurs fois la même
                        if ($.inArray(item.properties.postcode, cities) == -1) {
                            cities.push(item.properties.postcode);
                            return { label: item.properties.postcode + " - " + item.properties.city, 
                                    postcode: item.properties.postcode,
                                    value: item.properties.city
                            };
                        }
                    }));
                }
            });
        },
        // On remplit aussi le CP
        select: function(event, ui) {
            $(cp_id).val(ui.item.postcode);
        }
    });
    $(adresse_id).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "https://api-adresse.data.gouv.fr/search/?postcode="+$("input[name="+adresse_name+"]").val(),
                data: { q: request.term },
                dataType: "json",
                success: function (data) {
                    response($.map(data.features, function (item) {
                        return { label: item.properties.label,
                                city : item.properties.city,
                                cp : item.properties.postcode,
                                value: item.properties.name};
                    }));
                }
            });
        },
        // On remplit aussi le CP et la ville
        select: function(event, ui) {
            $(cp_id).val(ui.item.code_postal_vente_maison);
            $(ville_id).val(ui.item.city);
        }
    });
}