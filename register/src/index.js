// Check Connexion

$.ajax({type:"POST", url:"../../api/connexion/checkLog.php", data:"", dataType: "json", success: function(data) {
    if (data.response) {
        if (parseInt(data.admin)) {
            window.location = "../../admin/advertisements";
        } else {
            window.location = "../../";
        }
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
    $.ajax({type:"POST", url:"../../api/user/create.php", data:`user_civility=${civility}&user_firstname=${firstname}&user_name=${name}&user_birthdate=${birthdate}&user_phone=${phone}&user_email=${email}&user_password=${password}&password_confirmation=${passwordConfirmation}`, dataType: "json", success: function(data) {
        if (data.response) {
            window.location = "../../";
        } else {
            $(".Form").find(".FormMessage").html(data.message);
        }
    }, error: function(data) {
        $(".Form").find(".FormMessage").html(data.responseJSON.message);
    }});
}

// Connexion Button

$(".Footer").find("button").not(":first-child").click(function() {
    window.location = "../../connexion";
});