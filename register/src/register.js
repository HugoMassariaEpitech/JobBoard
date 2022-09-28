$(".LogButton").click(changeFormToLog);
$(".SendButton").click(addUser);

function changeFormToLog() {
    $(".FormElement:lt(5)").hide();
    $(".LogButton").html("Inscription");
    $(".LogButton").click(changeFormToRegister);
}

function changeFormToRegister() {
    $(".FormElement:lt(5)").show();
    $(".LogButton").html("LogIn");
    $(".LogButton").click(changeFormToLog);
    $(".SendButton").click(addUser);
}

function addUser() {
    console.log("Hugo");
    $.ajax({type:'POST', url:'../../api/user/register.php', data:`user_email=${"Hugo"}&user_password=${"Hugo"}&user_name=${"Hugo"}&user_firstname=${"Hugo"}&user_phone=${"Hugo"}&user_birthdate=${"01.09.1999"}&user_civility=${"Hugo"}`, success: function(data) {
        console.log(data);
    }, error: function() {
        console.log("Erreur");
    }});
}

function logUser() {

}