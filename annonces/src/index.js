// Check Connexion

$.ajax({type:"POST", url:"../../api/user/checkLog.php", data:"", dataType: "json", success: function(data) {
    if (data.response) {
        if (parseInt(data.admin)) {
            window.location = "../../admin";
        }
    } else {
        window.location = "../../connexion";
    }
}, error: function(data) {

}});

// LogOut

$("header").find("button").click(function() {
    logOut();
});

function logOut() {
    $.ajax({type:"POST", url:"../../api/user/logOut.php", data:"", dataType: "json", success: function(data) {

    }, error: function(data) {
    
    }});

}

// Get Advertisements

$.ajax({type:"GET", url:"../../api/advertisement/readAll.php", data:"", dataType: "json", success: function(data) {
    if (data.response) {
        for (const [key, value] of Object.entries(data.message)) {
            const Element = document.createElement("div");
            const Name = document.createElement("div");
            Name.classList.add("Name");
            Name.innerHTML = value.advertisement_name;
            Element.appendChild(Name);
            const Company = document.createElement("div");
            Company.classList.add("Company");
            Company.innerHTML = value.advertisement_company;
            Element.appendChild(Company);
            const Parameters = document.createElement("div");
            Parameters.classList.add("Parameters");
            Element.appendChild(Parameters);
            const ParametersContent = document.createElement("div");
            ParametersContent.classList.add("Content");
            Parameters.appendChild(ParametersContent);
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
            const Description = document.createElement("div");
            Description.classList.add("Description");
            Element.appendChild(Description);
            const DescriptionContent = document.createElement("div");
            DescriptionContent.classList.add("Content");
            DescriptionContent.innerHTML = value.advertisement_description;
            Description.appendChild(DescriptionContent);
            Element.addEventListener("click", showAdvertisement);
            Element.param = {advertisement: Element, id_advertisement: key, advertisement_name: value.advertisement_name, advertisement_company: value.advertisement_company, advertisement_location: value.advertisement_location, advertisement_type: value.advertisement_type, advertisement_description: value.advertisement_description, advertisement_salary: value.advertisement_salary};
            $(".LeftSide").find(".Container").find(".Scroll").append(Element);
        }
        $("main").find(".LeftSide").find(".Container").find(".Scroll").find("div").first().click();
    }
}, error: function(data) {

}});

// Show Advertisement

function showAdvertisement(data) {
    $(".RightSide").find(".Panel").empty();
    $(".LeftSide").find(".Container").find(".Scroll").find("div").removeClass("Selected");
    data.currentTarget.param.advertisement.className = "Selected";
    const Name = document.createElement("div");
    Name.classList.add("Name");
    Name.innerHTML = data.currentTarget.param.advertisement_name;
    $(".RightSide").find(".Panel").append(Name);
    const Company = document.createElement("div");
    Company.classList.add("Company");
    Company.innerHTML = data.currentTarget.param.advertisement_company;
    $(".RightSide").find(".Panel").append(Company);
    const Parameters = document.createElement("div");
    Parameters.classList.add("Parameters");
    $(".RightSide").find(".Panel").append(Parameters);
    const ParametersContent = document.createElement("div");
    ParametersContent.classList.add("Content");
    Parameters.appendChild(ParametersContent);
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
    const Description = document.createElement("div");
    Description.classList.add("Description");
    $(".RightSide").find(".Panel").append(Description);
    const DescriptionContent = document.createElement("div");
    DescriptionContent.classList.add("Content");
    DescriptionContent.innerHTML = data.currentTarget.param.advertisement_description;
    Description.appendChild(DescriptionContent);
    const Button = document.createElement("button");
    Button.innerHTML = "Subscribe";
    $(".RightSide").find(".Panel").append(Button);
}