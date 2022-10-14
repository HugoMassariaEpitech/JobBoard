// Check connexion

$.ajax({type:"POST", url:"../../api/connexion/checkLog.php", data:"", dataType: "json", success: function(data) {
    if (data.response) {
        if (!parseInt(data.admin)) {
            window.location = "../../"; // Not admin -> Public
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

getAdvertisements();
$("header").find(".Menu").find(".Item").click(function() {
    window.location = `../${$(this)[0].innerText.toLowerCase()}`;
});

// Get advertisements

function getAdvertisements() {
    $("main").find(".Container").find(".Scroll").empty(); // Delete all current user's data
    $.ajax({type:"GET", url:"../../../api/advertisement/read.php", data:"", dataType: "json", success: function(data) {
        if (data.response) {
            for (const [key, value] of Object.entries(data.message)) {
                // Advertisement
                const Element = document.createElement("div");
                Element.classList.add("Advertisement");
                $("main").find(".Container").find(".Scroll").append(Element);
                // Row
                const Row = document.createElement("div");
                Row.classList.add("Row");
                Element.appendChild(Row);
                // Advertisement -> Name
                const Name = document.createElement("div");
                Name.innerHTML = `${value.advertisement_name}`;
                Row.appendChild(Name);
                // Advertisement -> Company
                const Company = document.createElement("div");
                Company.innerHTML = value.advertisement_company;
                Row.appendChild(Company);
                // Advertisement -> Type
                const Type = document.createElement("div");
                Type.innerHTML = value.advertisement_type;
                Row.appendChild(Type);
                // Advertisement -> Expand
                getApplicants(value.id_advertisement, function(Applicants) {
                    const ExpandIcon = document.createElement("span");
                    ExpandIcon.classList.add("material-icons", "md-17");
                    ExpandIcon.innerHTML = "expand_more";
                    ExpandIcon.param = {id_advertisement: value.id_advertisement, advertisement: Element, applicants: Applicants};
                    ExpandIcon.addEventListener("click", displayApplicants);
                    Row.appendChild(ExpandIcon);
                });
            }
        }
    }, error: function(data) {
    
    }});
}

// Get applicants

function getApplicants(id_advertisement, callback) {
    $.ajax({type:"GET", url:"../../api/application/read.php", data:`id_advertisement=${id_advertisement}`, dataType: "json", success: function(data) {
        callback(data.message);
    }, error: function(data) {
    
    }});
}

// Display applicants

function displayApplicants(data) {
    // Hide applicants button
    data.currentTarget.innerHTML = "expand_less";
    data.currentTarget.removeEventListener("click", displayApplicants);
    data.currentTarget.addEventListener("click", hideApplicants);
    // Add separator Line
    const Line = document.createElement("div");
    data.currentTarget.param.advertisement.appendChild(Line);
    // Applicants
    for (const [key, value] of Object.entries(data.currentTarget.param.applicants)) {
        // Row
        const Row = document.createElement("div");
        Row.classList.add("Row");
        data.currentTarget.param.advertisement.appendChild(Row);
        // User -> Name
        const Name = document.createElement("div");
        Name.innerHTML = `${value.user_firstname} ${value.user_name}`;
        Row.appendChild(Name);
        // User -> Email
        const Email = document.createElement("div");
        Email.innerHTML = value.user_email;
        Row.appendChild(Email);
        // User -> Phone
        const Phone = document.createElement("div");
        Phone.innerHTML = value.user_phone;
        Row.appendChild(Phone);
        // User -> Delete
        const DeleteIcon = document.createElement("span");
        DeleteIcon.classList.add("material-icons", "md-17");
        DeleteIcon.innerHTML = "person_remove";
        DeleteIcon.param = {id_advertisement: data.currentTarget.param.id_advertisement, user_email: value.user_email, applicants: data.currentTarget.param.applicants, application: Row, icon: data.currentTarget};
        DeleteIcon.addEventListener("click", deleteApplicant);
        Row.appendChild(DeleteIcon);
    }
}

// Hide applicants

function hideApplicants(data) {
    // Hide applicants button
    data.currentTarget.innerHTML = "expand_more";
    data.currentTarget.removeEventListener("click", hideApplicants);
    data.currentTarget.addEventListener("click", displayApplicants);
    // Remove applicant's data
    while (data.currentTarget.param.advertisement.childNodes.length > 1) {
        data.currentTarget.param.advertisement.removeChild(data.currentTarget.param.advertisement.lastChild);
    }
}

// Delete applicant

function deleteApplicant(data) {
    data.currentTarget.param.icon.param.applicants = data.currentTarget.param.applicants.filter((obj) => obj.user_email != data.currentTarget.param.user_email);
    let application = data.currentTarget.param.application;
    $.ajax({type:"POST", url:"../../api/application/delete.php", data:`id_advertisement=${data.currentTarget.param.id_advertisement}&user_email=${data.currentTarget.param.user_email}`, dataType: "json", success: function(data) {
        application.remove();
    }, error: function(data) {
    
    }});
}