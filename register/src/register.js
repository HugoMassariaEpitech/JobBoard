$(".SendButton").click(addUser);

function addUser() {
    $.ajax({type:"POST", url:"../../api/user/register.php", data:"user_email=hugo.massaria@google.com&user_password=Hugo", success: function(data) {
        console.log(data);
    }, error: function() {
        console.log("Erreur");
    }});
}