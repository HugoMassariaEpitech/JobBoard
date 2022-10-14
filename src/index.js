// Check Connexion

$.ajax({type:"POST", url:"../api/connexion/checkLog.php", data:"", dataType: "json", success: function(data) {
    if (data.response) {
        if (parseInt(data.admin)) {
            window.location = "../admin/advertisements"; // Admin -> Admin
        } else {
            manageUser(data.message);
        }
    } else {
        logIn();
    }
}, error: function(data) {

}});

// LogIn button

function logIn() {
    $("header").find("span").unbind("click");
    $("header").find("span").click(function() {
        window.location = "../connexion"; // Not connected -> Connexion
    });
}

// Manage user button

function manageUser(data) {
    $("header").find("span").unbind("click");
    $("header").find("span").click(function() {
        displayPopupLog(data);
    });
}

// Init page

getAdvertisements();

// Get advertisements
function getAdvertisements() {
    $(".LeftSide").find(".Container").find(".Scroll").empty(); // Delete all current advertisement's data
    $.ajax({type:"GET", url:"../api/advertisement/read.php", data:"", dataType: "json", success: function(data) {
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

function applyAdvertisement(event) {
    let id_advertisement = event.currentTarget.param.id_advertisement;
    $.ajax({type:"POST", url:"../api/connexion/checkLog.php", data:"", dataType: "json", success: function(data) {
        if (data.response) {
            $.ajax({type:"POST", url:"../api/application/create.php", data:`id_advertisement=${id_advertisement}`, dataType: "json", success: function(data) {
                getAdvertisements();
            }, error: function(data) {
            
            }});
        } else {
            displayPopupApplication(id_advertisement);
        }
    }, error: function(data) {
    
    }});
}

// Get applicants

function getApplicants(id_advertisement, callback) {
    $.ajax({type:"GET", url:"../api/application/read.php", data:`id_advertisement=${id_advertisement}`, dataType: "json", success: function(data) {
        callback(data.message, data.applicant);
    }, error: function(data) {
    
    }});
}

// Display popup -> Application

function displayPopupApplication(id_advertisement) {
    // PopUp
    const PopUp = document.createElement("div");
    PopUp.setAttribute("class", "PopUp");
    $("body").append(PopUp);
    // Panel
    const Panel = document.createElement("div");
    Panel.classList.add("Panel");
    PopUp.appendChild(Panel);
    // Form
    const Form = document.createElement("form");
    Form.setAttribute("class", "Form");
    Form.setAttribute("id", "Form");
    Panel.appendChild(Form);
    // Form -> Firstname
    const Firstname = document.createElement("div");
    Firstname.setAttribute("class", "FormElement");
    Form.appendChild(Firstname);
    // Form -> Firstname -> Label
    const FirstnameLabel = document.createElement("label");
    FirstnameLabel.setAttribute("for", "FirstName");
    FirstnameLabel.innerHTML = "Firstname";
    Firstname.appendChild(FirstnameLabel);
    // Form -> Firstname -> Input
    const FirstnameInput = document.createElement("input");
    FirstnameInput.setAttribute("type", "text");
    FirstnameInput.setAttribute("name", "Firstname");
    FirstnameInput.setAttribute("id", "FirstName");
    FirstnameInput.required = true;
    Firstname.appendChild(FirstnameInput);
    // Form -> Name
    const Name = document.createElement("div");
    Name.setAttribute("class", "FormElement");
    Form.appendChild(Name);
    // Form -> Name -> Label
    const NameLabel = document.createElement("label");
    NameLabel.setAttribute("for", "Name");
    NameLabel.innerHTML = "Name";
    Name.appendChild(NameLabel);
    // Form -> Name -> Input
    const NameInput = document.createElement("input");
    NameInput.setAttribute("type", "text");
    NameInput.setAttribute("name", "Name");
    NameInput.setAttribute("id", "Name");
    NameInput.required = true;
    Name.appendChild(NameInput);
    // Form -> Email
    const Email = document.createElement("div");
    Email.setAttribute("class", "FormElement");
    Form.appendChild(Email);
    // Form -> Email -> Label
    const EmailLabel = document.createElement("label");
    EmailLabel.setAttribute("for", "Email");
    EmailLabel.innerHTML = "Email";
    Email.appendChild(EmailLabel);
    // Form -> Email -> Input
    const EmailInput = document.createElement("input");
    EmailInput.setAttribute("type", "email");
    EmailInput.setAttribute("name", "Email");
    EmailInput.setAttribute("id", "Email");
    EmailInput.required = true;
    Email.appendChild(EmailInput);
    // Form -> Phone
    const Phone = document.createElement("div");
    Phone.setAttribute("class", "FormElement");
    Form.appendChild(Phone);
    // Form -> Phone -> Label
    const PhoneLabel = document.createElement("label");
    PhoneLabel.setAttribute("for", "Phone");
    PhoneLabel.innerHTML = "Phone";
    Phone.appendChild(PhoneLabel);
    // Form -> Phone -> Input
    const PhoneInput = document.createElement("input");
    PhoneInput.setAttribute("type", "tel");
    PhoneInput.setAttribute("name", "Phone");
    PhoneInput.setAttribute("id", "Phone");
    PhoneInput.required = true;
    Phone.appendChild(PhoneInput);
    // Footer
    const Footer = document.createElement("div");
    Footer.setAttribute("class", "Footer");
    Panel.appendChild(Footer);
    // Footer -> Send button
    const Send = document.createElement("button");
    Send.setAttribute("form", "Form");
    Send.setAttribute("type", "submit");
    Send.innerHTML = "Send";
    Footer.appendChild(Send);
    $(".Form").submit(function() {
        const Data = $(".Form").serializeArray();
        $.ajax({type:"POST", url:"../api/application/create.php", data:`id_advertisement=${id_advertisement}&user_firstname=${Data[0].value}&user_name=${Data[1].value}&user_email=${Data[2].value}&user_phone=${Data[3].value}`, dataType: "json", success: function(data) {
            getAdvertisements();
            $("body").find(".PopUp").remove();
            $(".Form").unbind("submit");
        }, error: function(data) {
        
        }});
        return false;
    });
    // Footer -> Cancel button
    const Cancel = document.createElement("button");
    Cancel.innerHTML = "Cancel";
    Footer.appendChild(Cancel);
    Cancel.addEventListener("click", function() {
        $("body").find(".PopUp").remove();
        $(".Form").unbind("submit");
    });
}

// Display popup -> Application

function displayPopupLog(data) {
    // PopUp
    const PopUp = document.createElement("div");
    PopUp.setAttribute("class", "PopUp");
    $("body").append(PopUp);
    // Panel
    const Panel = document.createElement("div");
    Panel.classList.add("Panel");
    PopUp.appendChild(Panel);
    // Form
    const Form = document.createElement("form");
    Form.setAttribute("class", "Form");
    Form.setAttribute("id", "Form");
    Panel.appendChild(Form);
    // Form -> Firstname
    const Firstname = document.createElement("div");
    Firstname.setAttribute("class", "FormElement");
    Form.appendChild(Firstname);
    // Form -> Firstname -> Label
    const FirstnameLabel = document.createElement("label");
    FirstnameLabel.setAttribute("for", "FirstName");
    FirstnameLabel.innerHTML = "Firstname";
    Firstname.appendChild(FirstnameLabel);
    // Form -> Firstname -> Input
    const FirstnameInput = document.createElement("input");
    FirstnameInput.setAttribute("type", "text");
    FirstnameInput.setAttribute("name", "Firstname");
    FirstnameInput.setAttribute("id", "FirstName");
    FirstnameInput.required = true;
    FirstnameInput.value = data.user_firstname;
    Firstname.appendChild(FirstnameInput);
    // Form -> Name
    const Name = document.createElement("div");
    Name.setAttribute("class", "FormElement");
    Form.appendChild(Name);
    // Form -> Name -> Label
    const NameLabel = document.createElement("label");
    NameLabel.setAttribute("for", "Name");
    NameLabel.innerHTML = "Name";
    Name.appendChild(NameLabel);
    // Form -> Name -> Input
    const NameInput = document.createElement("input");
    NameInput.setAttribute("type", "text");
    NameInput.setAttribute("name", "Name");
    NameInput.setAttribute("id", "Name");
    NameInput.required = true;
    NameInput.value = data.user_name;
    Name.appendChild(NameInput);
    // Form -> Phone
    const Phone = document.createElement("div");
    Phone.setAttribute("class", "FormElement");
    Form.appendChild(Phone);
    // Form -> Phone -> Label
    const PhoneLabel = document.createElement("label");
    PhoneLabel.setAttribute("for", "Phone");
    PhoneLabel.innerHTML = "Phone";
    Phone.appendChild(PhoneLabel);
    // Form -> Phone -> Input
    const PhoneInput = document.createElement("input");
    PhoneInput.setAttribute("type", "tel");
    PhoneInput.setAttribute("name", "Phone");
    PhoneInput.setAttribute("id", "Phone");
    PhoneInput.required = true;
    PhoneInput.value = data.user_phone;
    Phone.appendChild(PhoneInput);
    // Footer
    const Footer = document.createElement("div");
    Footer.setAttribute("class", "Footer");
    Panel.appendChild(Footer);
    // Footer -> Update button
    const Update = document.createElement("button");
    Update.setAttribute("form", "Form");
    Update.setAttribute("type", "submit");
    Update.innerHTML = "Update";
    Footer.appendChild(Update);
    $(".Form").submit(function() {
        const Data = $(".Form").serializeArray();
        $.ajax({type:"POST", url:"../api/user/update.php", data:`user_firstname=${Data[0].value}&user_name=${Data[1].value}&user_phone=${Data[2].value}`, dataType: "json", success: function(data) {
            if (data.response) {
                $("body").find(".PopUp").remove();
                $(".Form").unbind("submit");
                manageUser({user_firstname: Data[0].value, user_name: Data[1].value, user_phone: Data[2].value});
            }
        }, error: function(data) {
        
        }});
        console.log(Data);
        return false;
    });
    // Footer -> Cancel button
    const Cancel = document.createElement("button");
    Cancel.innerHTML = "Cancel";
    Footer.appendChild(Cancel);
    Cancel.addEventListener("click", function() {
        $("body").find(".PopUp").remove();
        $(".Form").unbind("submit");
    });
    // Footer -> Logout button
    const Logout = document.createElement("button");
    Logout.innerHTML = "Logout";
    Footer.appendChild(Logout);
    Logout.addEventListener("click", function() {
        $.ajax({type:"POST", url:"../api/connexion/logOut.php", data:"", dataType: "json", success: function(data) {
            if (data.response) {
                $("body").find(".PopUp").remove();
                $(".Form").unbind("submit");
                logIn();
                getAdvertisements();
            }
        }, error: function(data) {
        
        }});
    });
}