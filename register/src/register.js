$(".LogButton").click(changeFormToLog);

function changeFormToLog() {
    $(".FormElement:lt(5)").hide();
    $(".LogButton").html("Inscription");
    $(".LogButton").click(changeFormToRegister);
}

function changeFormToRegister() {
    $(".FormElement:lt(5)").show();
    $(".LogButton").html("LogIn");
    $(".LogButton").click(changeFormToLog);
}

function addUser() {
    $.ajax({type:'POST', url:'api/user/register.php', data:`user_email=${}&user_password=${}&user_name=${}&user_firstname=${}&user_phone=${}&user_birthdate=${}&user_civility=${}`, success: function(data) {
        console.log(data);
    }, error: function() {
        console.log("Erreur");
    }});
}

function logUser() {

}