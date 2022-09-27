$.ajax({type:'GET', url:'api/advertisement/readAll.php', data:"", dataType: 'json', success: function(data) {
    for (const advertisement of data) {
        $(".Scroll").append(`<div class="Element"><h3 class="Titre">${advertisement.advertisement_name}</h3><p class="Description">${advertisement.advertisement_description}</p><button class="mdc-button mdc-button--outlined mdc-button--icon-leading"><span class="mdc-button__ripple"></span><i class="material-icons mdc-button__icon" aria-hidden="true">read_more</i><span class="mdc-button__label">VOIR</span></button></div>`);
    }
}, error: function() {
    console.log("Erreur");
}});