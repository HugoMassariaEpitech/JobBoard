// Check connexion

$.ajax({type:"POST", url:"../../../api/connexion/checkLog.php", data:"", dataType: "json", success: function(data) {
    if (data.response) {
        if (!parseInt(data.admin)) {
            window.location = "../../../"; // Not admin -> Public
        }
    } else {
        window.location = "../../../connexion"; // Not connected -> Connexion
    }
}, error: function(data) {

}});

// LogOut button

$("header").find("button").click(function() {
    $.ajax({type:"POST", url:"../../../api/connexion/logOut.php", data:"", dataType: "json", success: function(data) {
        if (data.response) {
            window.location = "../../../connexion"; // Not connected -> Connexion
        }
    }, error: function(data) {
    
    }});
});

// Init page

$(".RightSide").find(".Panel").find(".Footer").find("button").not(":first-child").hide(); // Hide Delete & Cancel Button
getAdvertisements();
createAdvertisement();
$("header").find(".Menu").find(".Item").click(function() {
    window.location = `../${$(this)[0].innerText.toLowerCase()}`;
});

// Get advertisements

function getAdvertisements() {
    $(".LeftSide").find(".Container").find(".Scroll").empty(); // Delete all current advertisement's data
    $.ajax({type:"GET", url:"../../../api/advertisement/read.php", data:"", dataType: "json", success: function(data) {
        if (data.response) {
            for (const [key, value] of Object.entries(data.message)) {
                // Advertisement
                const Element = document.createElement("div");
                Element.param = {advertisement: Element, id_advertisement: value.id_advertisement, advertisement_name: value.advertisement_name, advertisement_company: value.advertisement_company, advertisement_location: value.advertisement_location, advertisement_type: value.advertisement_type, advertisement_description: value.advertisement_description, advertisement_salary: value.advertisement_salary};
                Element.addEventListener("click", displayAdvertisement);
                $(".LeftSide").find(".Container").find(".Scroll").append(Element);
                // Advertisement -> Name
                const Name = document.createElement("div");
                Name.classList.add("Name");
                Name.innerHTML = value.advertisement_name;
                Element.appendChild(Name);
                // Advertisement -> Company
                const Company = document.createElement("div");
                Company.classList.add("Company");
                Company.innerHTML = value.advertisement_company;
                Element.appendChild(Company);
                // Advertisement -> Parameters (location - Type - Salary)
                const Parameters = document.createElement("div");
                Parameters.classList.add("Parameters");
                Element.appendChild(Parameters);
                const ParametersContent = document.createElement("div");
                ParametersContent.classList.add("Content");
                Parameters.appendChild(ParametersContent);
                // Location
                const LocationParameter = document.createElement("div");
                LocationParameter.classList.add("Parameter");
                ParametersContent.appendChild(LocationParameter);
                const LocationIcon = document.createElement("span");
                LocationIcon.classList.add("material-icons", "md-13");
                LocationIcon.innerHTML = "near_me";
                LocationParameter.appendChild(LocationIcon);
                const LocationTitle = document.createElement("div");
                LocationTitle.innerHTML = value.advertisement_location;
                LocationParameter.appendChild(LocationTitle);
                // Type
                const TypeParameter = document.createElement("div");
                TypeParameter.classList.add("Parameter");
                ParametersContent.appendChild(TypeParameter);
                const TypeIcon = document.createElement("span");
                TypeIcon.classList.add("material-icons", "md-13");
                TypeIcon.innerHTML = "work";
                TypeParameter.appendChild(TypeIcon);
                const TypeTitle = document.createElement("div");
                TypeTitle.innerHTML = value.advertisement_type;
                TypeParameter.appendChild(TypeTitle);
                // Salary
                const SalaryParameter = document.createElement("div");
                SalaryParameter.classList.add("Parameter");
                ParametersContent.appendChild(SalaryParameter);
                const SalaryIcon = document.createElement("span");
                SalaryIcon.classList.add("material-icons", "md-13");
                SalaryIcon.innerHTML = "payments";
                SalaryParameter.appendChild(SalaryIcon);
                const SalaryTitle = document.createElement("div");
                SalaryTitle.innerHTML = value.advertisement_salary;
                SalaryParameter.appendChild(SalaryTitle);
                // Advertisement -> Description
                const Description = document.createElement("div");
                Description.classList.add("Description");
                Element.appendChild(Description);
                const DescriptionContent = document.createElement("div");
                DescriptionContent.classList.add("Content");
                DescriptionContent.innerHTML = value.advertisement_description;
                Description.appendChild(DescriptionContent);
                // Advertisement -> Subscribers
                const Subscribers = document.createElement("div");
                Subscribers.classList.add("Subscribers");
                Element.appendChild(Subscribers);
                const SubscribersIcon = document.createElement("span");
                SubscribersIcon.classList.add("material-icons", "md-13");
                SubscribersIcon.innerHTML = "group";
                Subscribers.appendChild(SubscribersIcon);
                const SubscribersTitle = document.createElement("div");
                Subscribers.appendChild(SubscribersTitle);
                // Get advertisement's applicants
                getApplicants(value.id_advertisement, function(SubscribersCount) {
                    SubscribersTitle.innerHTML = SubscribersCount.toString();
                });
            }
        }
    }, error: function(data) {
    
    }});
}

// Display advertisement

function displayAdvertisement(data) {
    // Change borders of selected advertisement
    $(".LeftSide").find(".Container").find(".Scroll").find("div").removeClass("Selected");
    data.currentTarget.param.advertisement.className = "Selected";
    // Display advertisement in the admin panel
    $(".Form").find("input")[0].value = data.currentTarget.param.advertisement_name;
    $(".Form").find("input")[1].value = data.currentTarget.param.advertisement_company;
    $(".Form").find("input")[2].value = data.currentTarget.param.advertisement_location;
    $(".Form").find("input")[3].value = data.currentTarget.param.advertisement_type;
    $(".Form").find("input")[4].value = data.currentTarget.param.advertisement_salary.replace(" €", "");
    $(".Form").find("textarea")[0].value = data.currentTarget.param.advertisement_description;
    // Change admin panel -> Update
    $(".Form").unbind("submit");
    $(".RightSide").find(".Panel").find(".Footer").find("button").first().html("Update");
    updateAdvertisement(data.currentTarget.param.id_advertisement);
    // Change admin panel -> Delete
    $(".RightSide").find(".Panel").find(".Footer").find("button:nth-child(2)").show(); // Show Delete Button
    deleteAdvertisement(data.currentTarget.param.id_advertisement);
    // Change admin panel -> Cancel
    $(".RightSide").find(".Panel").find(".Footer").find("button:nth-child(3)").show(); // Show Cancel Button
    cancel();
}

// Update advertisement

function updateAdvertisement(id_advertisement) {
    $(".Form").submit(function() {
        const Data = $(".Form").serializeArray();
        $.ajax({type:"POST", url:"../../../api/advertisement/update.php", data:`id_advertisement=${id_advertisement}&advertisement_name=${Data[0].value}&advertisement_company=${Data[1].value}&advertisement_location=${Data[2].value}&advertisement_type=${Data[3].value}&advertisement_salary=${Data[4].value} €&advertisement_description=${Data[5].value}`, dataType: "json", success: function(data) {
            getAdvertisements() // Refresh all current advertisement's data
            // Change admin panel -> Create
            $(".Form").find("input").val("");
            $(".Form").find("textarea").val("");
            $(".Form").unbind("submit");
            $(".RightSide").find(".Panel").find(".Footer").find("button").first().html("Add");
            $(".RightSide").find(".Panel").find(".Footer").find("button").not(":first-child").unbind("click");
            $(".RightSide").find(".Panel").find(".Footer").find("button").not(":first-child").hide(); // Hide Delete & Cancel Button
            createAdvertisement();
        }, error: function(data) {
        
        }});
        return false;
    });
}

// Delete advertisement

function deleteAdvertisement(id_advertisement) {
    $(".RightSide").find(".Panel").find(".Footer").find("button:nth-child(2)").click(function() {
        $.ajax({type:"POST", url:"../../../api/advertisement/delete.php", data:`id_advertisement=${id_advertisement}`, dataType: "json", success: function(data) {
            getAdvertisements() // Refresh all current advertisement's data
            // Change admin panel -> Create
            $(".Form").find("input").val("");
            $(".Form").find("textarea").val("");
            $(".Form").unbind("submit");
            $(".RightSide").find(".Panel").find(".Footer").find("button").first().html("Add");
            $(".RightSide").find(".Panel").find(".Footer").find("button").not(":first-child").unbind("click");
            $(".RightSide").find(".Panel").find(".Footer").find("button").not(":first-child").hide(); // Hide Delete & Cancel Button
            createAdvertisement();
        }, error: function(data) {
        
        }});
    });
}

// Create Advertisement

function createAdvertisement() {
    $(".Form").submit(function() {
        const Data = $(".Form").serializeArray();
        $.ajax({type:"POST", url:"../../../api/advertisement/create.php", data:`advertisement_name=${Data[0].value}&advertisement_company=${Data[1].value}&advertisement_location=${Data[2].value}&advertisement_type=${Data[3].value}&advertisement_salary=${Data[4].value} €&advertisement_description=${Data[5].value}`, dataType: "json", success: function(data) {
            getAdvertisements() // Refresh all current advertisement's data
            $(".Form").find("input").val("");
            $(".Form").find("textarea").val("");
        }, error: function(data) {
        
        }});
        return false;
    });
}

// Cancel

function cancel() {
    $(".RightSide").find(".Panel").find(".Footer").find("button:nth-child(3)").click(function() {
        // Change borders of selected advertisement
        $(".LeftSide").find(".Container").find(".Scroll").find("div").removeClass("Selected");
        // Change admin panel -> Create
        $(".Form").find("input").val("");
        $(".Form").find("textarea").val("");
        $(".Form").unbind("submit");
        $(".RightSide").find(".Panel").find(".Footer").find("button").first().html("Add");
        $(".RightSide").find(".Panel").find(".Footer").find("button").not(":first-child").unbind("click");
        $(".RightSide").find(".Panel").find(".Footer").find("button").not(":first-child").hide(); // Hide Delete & Cancel Button
        createAdvertisement();
    });
}

// Get applicants

function getApplicants(id_advertisement, callback) {
    $.ajax({type:"GET", url:"../../api/application/read.php", data:`id_advertisement=${id_advertisement}`, dataType: "json", success: function(data) {
        callback(data.message.length);
    }, error: function(data) {
    
    }});
}