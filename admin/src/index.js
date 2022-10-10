// Check Connexion

$.ajax({type:"POST", url:"../../api/user/checkLog.php", data:"", dataType: "json", success: function(data) {
    if (data.response) {
        if (!parseInt(data.admin)) {
            window.location = "../../annonces";
        }
    } else {
        window.location = "../../register";
    }
}, error: function(data) {

}});