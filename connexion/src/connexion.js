$(".LogButton").click(changeFormToLog);
$(".Form").submit(function(event) {
    event.preventDefault();
    console.log("oui");
    // const Data = $(".Form").serializeArray();
    // addUser(Data[0].value, Data[1].value, Data[2].value, Data[3].value, Data[4].value, Data[5].value, Data[6].value, Data[7].value);
});

function changeFormToLog() {
    $(".FormElement:lt(5)").hide();
    $(".FormElement:last").hide();
    $(".LogButton").html("Inscription");
    $(".LogButton").off("click");
    $(".LogButton").click(changeFormToRegister);
    $(".SendButton").off("click");
    $(".SendButton").click(logUser);
}

function changeFormToRegister() {
    $(".FormElement:lt(5)").show();
    $(".FormElement:last").show();
    $(".LogButton").html("LogIn");
    $(".LogButton").off("click");
    $(".LogButton").click(changeFormToLog);
    $(".SendButton").off("click");
    $(".SendButton").click(addUser);
}

function addUser(Civility, FirstName, Name, Birthday, Phone, Email, Password, Password2) {
    $.ajax({type:"POST", url:"../../api/user/register.php", data:`user_email=${Email}&user_password=${Password}&user_name=${Name}&user_firstname=${FirstName}&user_phone=${Phone}&user_birthdate=${Birthday}&user_civility=${Civility}&user_confirmpass=${Password2}`, success: function(data) {
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