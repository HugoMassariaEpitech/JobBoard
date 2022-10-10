// Check Connexion

$.ajax({type:"POST", url:"../../api/user/checkLog.php", data:"", dataType: "json", success: function(data) {
    if (data.response) {
        if (parseInt(data.admin)) {
            window.location = "../../admin";
        }
    } else {
        window.location = "../../register";
    }
}, error: function(data) {

}});

// LogOut 

$("header").find("button").click(function() {
    $.ajax({type:"POST", url:"../../api/user/logOut.php", data:"", dataType: "json", success: function(data) {
        
    }, error: function(data) {
    
    }});
})