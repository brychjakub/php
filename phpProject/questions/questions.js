function copyChildAddress() {
    if (document.getElementById("sameAddress").checked) {
        // Copy child's address to representative's address
        document.getElementById("legalRepresentativeHomeAddressStreet").value = document.getElementById("childHomeAddressStreet").value;

        // Copy child's city to representative's city
        document.getElementById("legalRepresentativeHomeAddressCity").value = document.getElementById("childHomeAddressCity").value;

        // Copy child's postcode to representative's postcode
        document.getElementById("legalRepresentativeHomeAddressPostcode").value = document.getElementById("childHomeAddressPostcode").value;

        // Copy child's postcode to representative's postcode
        document.getElementById("legalRepresentativeHomeAddressNumber").value = document.getElementById("childHomeAddressNumber").value;
    }
}

function validateForm() {
var firstname = document.getElementById("firstname").value;
var lastname = document.getElementById("lastname").value;
var childBirthDay = document.getElementById("childBirthDay").value;
var childHomeAddressStreet = document.getElementById("childHomeAddressStreet").value;
var childHomeAddressNumber = document.getElementById("childHomeAddressNumber").value;
var childHomeAddressCity = document.getElementById("childHomeAddressCity").value;
var childHomeAddressPostcode = document.getElementById("childHomeAddressPostcode").value;
var legalRepresentativeFirstname = document.getElementById("legalRepresentativeFirstname").value;
var legalRepresentativeSurname = document.getElementById("legalRepresentativeSurname").value;
var legalRepresentativeEmail = document.getElementById("legalRepresentativeEmail").value;
var legalRepresentativePhone = document.getElementById("legalRepresentativePhone").value;
var legalRepresentativeHomeAddressStreet = document.getElementById("legalRepresentativeHomeAddressStreet").value;
var legalRepresentativeHomeAddressNumber = document.getElementById("legalRepresentativeHomeAddressNumber").value;
var legalRepresentativeHomeAddressCity = document.getElementById("legalRepresentativeHomeAddressCity").value;
var legalRepresentativeHomeAddressPostcode = document.getElementById("legalRepresentativeHomeAddressPostcode").value;
var note = document.getElementById("note").value;

// Regular expressions for validation
var dateRegex = /^\d{2}\.\d{2}\.\d{4}$/;
var postcodeRegex = /^[\d+]+$/;
var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
var letterRegex = /^[A-Za-z]+$/;

// Perform validation


if (!dateRegex.test(childBirthDay)) {
alert("Invalid child's birth date format. Please use dd.mm.yyyy format.");
return false;
}


if (!emailRegex.test(legalRepresentativeEmail)) {
alert("Invalid email address format. Please enter a valid email address.");
return false;
}

// phone
if (!postcodeRegex.test(legalRepresentativePhone)) {
alert("Invalid phone number format. Please enter a valid phone number.");
return false;
}
// If all fields pass validation, the form can be submitted
return true;
}