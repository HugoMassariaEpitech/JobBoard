// Check connexion

$.ajax({type:"POST", url:"../../api/user/checkLog.php", data:"", dataType: "json", success: function(data) {
    if (data.response) {
        if (!parseInt(data.admin)) {
            window.location = "../../annonces"; // Not admin -> Public
        }
    } else {
        window.location = "../../connexion"; // Not connected -> Connexion
    }
}, error: function(data) {

}});

// LogOut button

$("header").find("button").click(function() {
    $.ajax({type:"POST", url:"../../api/user/logOut.php", data:"", dataType: "json", success: function(data) {
        if (data.response) {
            window.location = "../../connexion"; // Not connected -> Connexion
        }
    }, error: function(data) {
    
    }});
});

