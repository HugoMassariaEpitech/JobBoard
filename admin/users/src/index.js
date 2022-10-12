// Check connexion

$.ajax({type:"POST", url:"../../api/connexion/checkLog.php", data:"", dataType: "json", success: function(data) {
    if (data.response) {
        if (!parseInt(data.admin)) {
            window.location = "../../annonces"; // Not admin -> Public
        }
    } else {
        window.location = "../../connexion"; // Not connected -> Connexion
    }
}, error: function(data) {

}});

// LogOut button

$("header").find("button").click(function() {
    $.ajax({type:"POST", url:"../../api/connexion/logOut.php", data:"", dataType: "json", success: function(data) {
        if (data.response) {
            window.location = "../../connexion"; // Not connected -> Connexion
        }
    }, error: function(data) {
    
    }});
});

// Init page

getUsers();
$("header").find(".Menu").find(".Item").click(function() {
    window.location = `../${$(this)[0].innerText.toLowerCase()}`;
});

// Get Users

function getUsers() {
    $("main").find(".Container").find(".Scroll").empty(); // Delete all current user's data
    $.ajax({type:"GET", url:"../../api/user/read.php", data:"", dataType: "json", success: function(data) {
        if (data.response) {
            for (const [key, value] of Object.entries(data.message)) {
                // User
                const Element = document.createElement("div");
                Element.classList.add("Row");
                $("main").find(".Container").find(".Scroll").append(Element);
                // User -> Name
                const Name = document.createElement("div");
                Name.innerHTML = `${value.user_firstname} ${value.user_name}`;
                Element.appendChild(Name);
                // User -> Email
                const Email = document.createElement("div");
                Email.innerHTML = value.user_email;
                Element.appendChild(Email);
                // User -> Phone
                const Phone = document.createElement("div");
                Phone.innerHTML = value.user_phone;
                Element.appendChild(Phone);
                // User -> Birthdate
                const Birthdate = document.createElement("div");
                Birthdate.innerHTML = value.user_birthdate;
                Element.appendChild(Birthdate);
                // User -> Password
                const Password = document.createElement("div");
                Password.innerHTML = "••••••••••";
                Element.appendChild(Password);
                // User -> Upgrade
                const UpgradeIcon = document.createElement("span");
                UpgradeIcon.classList.add("material-icons", "md-17");
                UpgradeIcon.innerHTML = "supervisor_account";
                UpgradeIcon.param = {id_user: value.id_user};
                UpgradeIcon.addEventListener("click", upgradeUser);
                Element.appendChild(UpgradeIcon);
                // User -> Delete
                const DeletIcon = document.createElement("span");
                DeletIcon.classList.add("material-icons", "md-17");
                DeletIcon.innerHTML = "person_remove";
                DeletIcon.param = {id_user: value.id_user};
                DeletIcon.addEventListener("click", deleteUser);
                Element.appendChild(DeletIcon);
            }
        }
    }, error: function(data) {
    
    }});
}

// Delete User

function deleteUser(data) {
    $.ajax({type:"POST", url:"../../api/user/delete.php", data:`id_user=${data.currentTarget.param.id_user}`, dataType: "json", success: function(data) {
        getUsers();
    }, error: function(data) {
    
    }});
}

// Upgrade User

function upgradeUser(data) {
    $.ajax({type:"POST", url:"../../api/user/upgrade.php", data:`id_user=${data.currentTarget.param.id_user}`, dataType: "json", success: function(data) {
        getUsers();
    }, error: function(data) {
    
    }});
}