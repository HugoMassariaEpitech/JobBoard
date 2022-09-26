$.ajax({type:'GET', url:'Advertisements.php', data:"", dataType: 'json', success: function(data) {
    // $(".LeftSide").append(`<div><h1>${data[0].advertisement_name}</h1><p>${data[0].advertisement_company}</p><p>${data[0].advertisement_location}</p><p>${data[0].advertisement_type}</p><p>${data[0].advertisement_description}</p></div>`);
}, error: function() {
    console.log("Erreur");
}});