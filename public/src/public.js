$.ajax({type:"GET", url:"../../api/advertisement/readAll.php", data:"", dataType: "json", success: function(data) {
    console.log(data);
}, error: function() {
    console.log("Erreur");
}});