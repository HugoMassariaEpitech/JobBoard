// Check Connexion

$.ajax({type:"POST", url:"../../api/user/checkLog.php", data:"", dataType: "json", success: function(data) {
    if (data.response) {
        if (!parseInt(data.admin)) {
            window.location = "../../annonces";
        }
    } else {
        window.location = "../../connexion";
    }
}, error: function(data) {

}});

// LogOut

$("header").find("button").click(function() {
    logOut();
});

function logOut() {
    $.ajax({type:"POST", url:"../../api/user/logOut.php", data:"", dataType: "json", success: function(data) {

    }, error: function(data) {
    
    }});
    window.location = "../../connexion";
}