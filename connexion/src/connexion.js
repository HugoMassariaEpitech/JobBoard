$(".LogButton").click(changeFormToLog);
$(".SendButton").click(addUser);

function changeFormToLog() {
    $(".FormElement:lt(5)").hide();
    $(".LogButton").html("Inscription");
    $(".LogButton").off("click");
    $(".LogButton").click(changeFormToRegister);
    $(".SendButton").off("click");
    $(".SendButton").click(logUser);
}

function changeFormToRegister() {
    $(".FormElement:lt(5)").show();
    $(".LogButton").html("LogIn");
    $(".LogButton").off("click");
    $(".LogButton").click(changeFormToLog);
    $(".SendButton").off("click");
    $(".SendButton").click(addUser);
}

function addUser() {
    $.ajax({type:"POST", url:"../../api/user/register.php", data:`user_email=${$("input[name=Email]").val()}&user_password=${$("input[name=Password]").val()}&user_name=${$("input[name=Name]").val()}&user_firstname=${$("input[name=FirstName]").val()}&user_phone=${$("input[name=Phone]").val()}&user_birthdate=${$("input[name=Birthday]").val()}&user_civility=${$("input[name=Civility]").val()}`, success: function(data) {
        console.log(data);
    }, error: function() {
        console.log("Erreur");
    }});
}

function logUser() {
    $.ajax({type:"POST", url:"../../api/user/logIn.php", data:`user_email=${$("input[name=Email]").val()}&user_password=${$("input[name=Password]").val()}`, success: function(data) {
        if (data) {
            window.location.href = "../../client/client.html";
        } else {
            console.log("Invalid email or password.");
        }
    }, error: function() {
        console.log("Missing email or password.");
    }});
}