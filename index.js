$.ajax({type:'GET', url:'api/advertisement/readAll.php', data:"", dataType: 'json', success: function(data) {
    for (const advertisement of data) {
        var Element = document.createElement("div");
        Element.className = "Advertisement";
        var Title = document.createElement("div");
        Title.className = "AdvertisementTitle";
        Title.innerHTML = advertisement.advertisement_name;
        Element.appendChild(Title);
        var Description = document.createElement("div");
        Description.className = "AdvertisementDescription";
        Description.innerHTML = advertisement.advertisement_description;
        Element.appendChild(Description);
        $(".Scroll").append(Element);
    }
}, error: function() {
    console.log("Erreur");
}});