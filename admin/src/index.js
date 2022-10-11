// Check Connexion

$.ajax({type:"POST", url:"../../api/user/checkLog.php", data:"", dataType: "json", success: function(data) {
    if (data.response) {
        if (!parseInt(data.admin)) {
            window.location = "../../annonces";
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

$(".RightSide").find(".Panel").find(".Footer").find("button").not(":first-child").hide();

getAdvertisement()

function getAdvertisement() {
    $(".LeftSide").find(".Container").find(".Scroll").empty();
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
                Element.param = {advertisement: Element, id_advertisement: value.id_advertisement, advertisement_name: value.advertisement_name, advertisement_company: value.advertisement_company, advertisement_location: value.advertisement_location, advertisement_type: value.advertisement_type, advertisement_description: value.advertisement_description, advertisement_salary: value.advertisement_salary};
                $(".LeftSide").find(".Container").find(".Scroll").append(Element);
            }
        }
    }, error: function(data) {
    
    }});
}

// Show Advertisement

function showAdvertisement(data) {
    $(".LeftSide").find(".Container").find(".Scroll").find("div").removeClass("Selected");
    data.currentTarget.param.advertisement.className = "Selected";
    $(".Form").find("input")[0].value = data.currentTarget.param.advertisement_name;
    $(".Form").find("input")[1].value = data.currentTarget.param.advertisement_company;
    $(".Form").find("input")[2].value = data.currentTarget.param.advertisement_location;
    $(".Form").find("input")[3].value = data.currentTarget.param.advertisement_type;
    $(".Form").find("input")[4].value = data.currentTarget.param.advertisement_salary.replace(" €", "");
    $(".Form").find("textarea")[0].value = data.currentTarget.param.advertisement_description;
    $(".RightSide").find(".Panel").find(".Footer").find("button").first().html("Mettre à jour");
    $(".Form").unbind("submit");
    updateAdvertisement(data.currentTarget.param.id_advertisement);
    $(".RightSide").find(".Panel").find(".Footer").find("button").not(":first-child").show();
    deleteAdvertisement(data.currentTarget.param.id_advertisement);
}

// Update Advertisement

function updateAdvertisement(id_advertisement) {
    $(".Form").submit(function() {
        const Data = $(".Form").serializeArray();
        $.ajax({type:"POST", url:"../../api/advertisement/update.php", data:`id_advertisement=${id_advertisement}&advertisement_name=${Data[0].value}&advertisement_company=${Data[1].value}&advertisement_location=${Data[2].value}&advertisement_type=${Data[3].value}&advertisement_salary=${Data[4].value} €&advertisement_description=${Data[5].value}`, dataType: "json", success: function(data) {
            getAdvertisement();
            $(".Form").find("input").val("");
            $(".Form").find("textarea").val("");
            $(".RightSide").find(".Panel").find(".Footer").find("button").first().html("Add");
            $(".Form").unbind("submit");
            $(".Form").submit(function() {
                const Data = $(".Form").serializeArray();
                addAdvertisement(Data[0], Data[1], Data[2], Data[3], Data[4], Data[5]);
                return false;
            });
        }, error: function(data) {
        
        }});
        return false;
    });
}

// Delete Advertisement

function deleteAdvertisement(id_advertisement) {
    $(".RightSide").find(".Panel").find(".Footer").find("button").not(":first-child").click(function() {
        $.ajax({type:"POST", url:"../../api/advertisement/delete.php", data:`id_advertisement=${id_advertisement}`, dataType: "json", success: function(data) {
            getAdvertisement();
            $(".Form").find("input").val("");
            $(".Form").find("textarea").val("");
            $(".RightSide").find(".Panel").find(".Footer").find("button").first().html("Add");
            $(".Form").unbind("submit");
            $(".Form").submit(function() {
                const Data = $(".Form").serializeArray();
                addAdvertisement(Data[0], Data[1], Data[2], Data[3], Data[4], Data[5]);
                return false;
            });
            $(".RightSide").find(".Panel").find(".Footer").find("button").not(":first-child").unbind("click");
            $(".RightSide").find(".Panel").find(".Footer").find("button").not(":first-child").hide();
        }, error: function(data) {
        
        }});
    });
}

// Add Advertisement

$(".Form").submit(function() {
    const Data = $(".Form").serializeArray();
    addAdvertisement(Data[0], Data[1], Data[2], Data[3], Data[4], Data[5]);
    return false;
});

function addAdvertisement(name, company, location, type, salary, description) {
    $.ajax({type:"POST", url:"../../api/advertisement/create.php", data:`advertisement_name=${name.value}&advertisement_company=${company.value}&advertisement_location=${location.value}&advertisement_type=${type.value}&advertisement_salary=${salary.value} €&advertisement_description=${description.value}`, dataType: "json", success: function(data) {
        getAdvertisement();
        $(".Form").find("input").val("");
        $(".Form").find("textarea").val("");
    }, error: function(data) {
    
    }});
}