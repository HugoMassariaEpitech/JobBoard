$.ajax({type:"POST", url:"../../api/user/checkLog.php", data:"", success: function(data) {
    if (!data) {
        window.location.href = "../../index.php";
    }
}, error: function() {
    console.log("Erreur");
}});

$(".LogButton").click(logOut);

function logOut() {
    console.log("ok");
    $.ajax({type:"POST", url:"../../api/user/logOut.php", data:"", success: function(data) {
        if (data) {
            window.location.href = "../../index.php";
        }
    }, error: function() {
        console.log("Erreur");
    }});
}