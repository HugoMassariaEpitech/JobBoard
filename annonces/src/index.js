// Check Connexion

$.ajax({type:"POST", url:"../../api/connexion/checkLog.php", data:"", dataType: "json", success: function(data) {
    if (data.response) {
        if (parseInt(data.admin)) {
            // window.location = "../../admin/advertisements"; // Admin -> Admin
        } else {
            $("header").find("button").click(function() {
                $.ajax({type:"POST", url:"../../api/connexion/logOut.php", data:"", dataType: "json", success: function(data) {
                        if (data.response) {
                            window.location = "../../connexion"; // Not connected -> Connexion
                        }
                    }, error: function(data) {

                    }});
            });
        }
    } else {
        // window.location = "../../connexion"; // Not connected -> Connexion
        $("header").find("button").html("Connexion");
        $("header").find("button").click(function() {
            window.location = "../../connexion";
        });

    }
}, error: function(data) {

}});


// Init page
getAdvertisements();


// Get advertisements
function getAdvertisements() {
    $(".LeftSide").find(".Container").find(".Scroll").empty(); // Delete all current advertisement's data
    $.ajax({type:"GET", url:"../../../api/advertisement/read.php", data:"", dataType: "json", success: function(data) {
        if (data.response) {
            for (const [key, value] of Object.entries(data.message)) {
                // Advertisement
                const Element = document.createElement("div");
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
                getApplicants(value.id_advertisement, function(SubscribersCount, ApplicantStatut) {
                    SubscribersTitle.innerHTML = SubscribersCount.toString();
                    Element.param = {advertisement: Element, id_advertisement: value.id_advertisement, advertisement_name: value.advertisement_name, advertisement_company: value.advertisement_company, advertisement_location: value.advertisement_location, advertisement_type: value.advertisement_type, advertisement_description: value.advertisement_description, advertisement_salary: value.advertisement_salary, applicant: ApplicantStatut};
                    Element.addEventListener("click", displayAdvertisement);
                    $("main").find(".LeftSide").find(".Container").find(".Scroll").find("div").first().click(); // Display first advertisement
                });
            }
        }
    }, error: function(data) {
    
    }});
}

// Display advertisement

function displayAdvertisement(data) {
    $(".RightSide").find(".Panel").empty(); // Delete all current advertisement's data
    // Change borders of selected advertisement
    $(".LeftSide").find(".Container").find(".Scroll").find("div").removeClass("Selected");
    data.currentTarget.param.advertisement.className = "Selected";
    // Advertisement -> Name
    const Name = document.createElement("div");
    Name.classList.add("Name");
    Name.innerHTML = data.currentTarget.param.advertisement_name;
    $(".RightSide").find(".Panel").append(Name);
    // Advertisement -> Company
    const Company = document.createElement("div");
    Company.classList.add("Company");
    Company.innerHTML = data.currentTarget.param.advertisement_company;
    $(".RightSide").find(".Panel").append(Company);
    // Advertisement -> Parameters (location - Type - Salary)
    const Parameters = document.createElement("div");
    Parameters.classList.add("Parameters");
    $(".RightSide").find(".Panel").append(Parameters);
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
    LocationTitle.innerHTML = data.currentTarget.param.advertisement_location;
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
    TypeTitle.innerHTML = data.currentTarget.param.advertisement_type;
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
    SalaryTitle.innerHTML = data.currentTarget.param.advertisement_salary;
    SalaryParameter.appendChild(SalaryTitle);
    // Advertisement -> Description
    const Description = document.createElement("div");
    Description.classList.add("Description");
    $(".RightSide").find(".Panel").append(Description);
    const DescriptionContent = document.createElement("div");
    DescriptionContent.classList.add("Content");
    DescriptionContent.innerHTML = data.currentTarget.param.advertisement_description;
    Description.appendChild(DescriptionContent);
    // Apply button
    if (data.currentTarget.param.applicant) {
        const Button = document.createElement("button");
        Button.classList.add("Applied");
        Button.innerHTML = "Applied";
        Button.param = {id_advertisement: data.currentTarget.param.id_advertisement};
        $(".RightSide").find(".Panel").append(Button);
    } else {
        const Button = document.createElement("button");
        Button.innerHTML = "Apply";
        Button.param = {id_advertisement: data.currentTarget.param.id_advertisement};
        Button.addEventListener("click", applyAdvertisement);
        $(".RightSide").find(".Panel").append(Button);
    }
}

// Apply advertisement

function applyAdvertisement(data) {
    $.ajax({type:"POST", url:"../../api/application/create.php", data:`id_advertisement=${data.currentTarget.param.id_advertisement}`, dataType: "json", success: function(data) {
        getAdvertisements();
    }, error: function(data) {
    
    }});
}

// Get applicants

function getApplicants(id_advertisement, callback) {
    $.ajax({type:"GET", url:"../../api/application/read.php", data:`id_advertisement=${id_advertisement}`, dataType: "json", success: function(data) {
        callback(data.message, data.applicant);
    }, error: function(data) {
    
    }});
}