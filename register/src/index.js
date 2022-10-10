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
    register(Data[0].value, Data[1].value, Data[2].value, Data[3].value, Data[4].value, Data[5].value, Data[6].value, Data[7].value);
    return false;
});

function register(civility, firstname, name, birthdate, phone, email, password, passwordConfirmation) {
    $.ajax({type:"POST", url:"../../api/user/register.php", data:`user_civility=${civility}&user_firstname=${firstname}&user_name=${name}&user_birthdate=${birthdate}&user_phone=${phone}&user_email=${email}&user_password=${password}&password_confirmation=${passwordConfirmation}`, dataType: "json", success: function(data) {
        if (data.response) {
            console.log("Registered.");
        } else {
            $(".Form").find(".FormMessage").html(data.message);
        }
    }, error: function(data) {
        $(".Form").find(".FormMessage").html(data.responseJSON.message);
    }});
}

// Register Button

$(".Footer").find("button").not(":first-child").click(function() {
    window.location = "../../connexion";
});