$.ajax({type:"GET", url:"../../api/advertisement/readAll.php", data:"", dataType: "json", success: function(data) {
    for (const advertisement of data) {
        var Element = document.createElement("div");
        Element.className = "Advertisement";
        var Title = document.createElement("div");
        Title.className = "Title";
        Title.innerHTML = advertisement.advertisement_name;
        Element.appendChild(Title);
        var Description = document.createElement("div");
        Description.className = "Description";
        Description.innerHTML = advertisement.advertisement_description;
        Element.appendChild(Description);
        $(".Scroll").append(Element);
    }
    console.log(JSON.parse(data[0].advertisement_details).Salaire);
}, error: function() {
    console.log("Erreur");
}});