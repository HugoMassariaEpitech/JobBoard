// Check Connexion

$.ajax({type:"POST", url:"../../api/user/checkLog.php", data:"", dataType: "json", success: function(data) {
    if (data.response) {
        window.location = "../../annonces";
    }
}, error: function(data) {

}});

// Register Button

$(".Form").submit(function() {
    const Data = $(".Form").serializeArray();
    logIn(Data[0].value, Data[1].value);
    return false;
});

function logIn(email, password) {
    $.ajax({type:"POST", url:"../../api/user/logIn.php", data:`user_email=${email}&user_password=${password}`, dataType: "json", success: function(data) {
        if (data.response) {
            if (parseInt(data.admin)) {
                console.log(data.message);
                console.log("admin");
            } else {
                window.location = "../../annonces";
            }
        } else {
            $(".Form").find(".FormMessage").html(data.message);
        }
    }, error: function(data) {
        $(".Form").find(".FormMessage").html(data.responseJSON.message);
    }});
}

// LogIn Button

$(".Footer").find("button").not(":first-child").click(function() {
    window.location = "../../register";
});