function validate() {
    let valid = true;

    if (!validateFullName()) valid = false;
    if (!validateEmail()) valid = false;
    if (!validatePassword()) valid = false;
    if (!validateConfirmPassword()) valid = false;
    if (!validateLoaction()) valid = false;
    if (!validateZipcode()) valid = false;
    if (!validateCountry()) valid = false;
    if (!validateTerms()) valid = false;

    return valid;
  }

  function validateFullName() {
    let x = document.getElementById('fullname').value;
    let errorField = document.getElementById('nameError');

    if (x === "") {
      errorField.innerHTML = "Please enter your name";
      return false;
    } else if (!isNaN(x) || /\d/.test(x)) {
      errorField.innerHTML = "Please enter a valid name";
      return false;
    } else {
      errorField.innerHTML = `Full Name: ${x}`;
      return true;
    }
  }

  function validateEmail() {
    let email = document.getElementById('email').value;
    const regex = /^\d{2}-\d{5}-\d@student\.aiub\.edu$/;
    let errorField = document.getElementById('emailError');

    if (email === "") {
      errorField.innerHTML = "Please enter your email";
      return false;
    } else if (!regex.test(email)) {
      errorField.innerHTML = "Please enter a valid email in the format XX-XXXXX-X@student.aiub.edu";
      return false;
    } else {
      errorField.innerHTML = `Valid Email: ${email}`;
      return true;
    }
  }

  function validatePassword() {
    let password = document.getElementById('password').value;
    const regex1 = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()])[A-Za-z\d!@#$%^&*()]{8,}$/;
    let errorField = document.getElementById('passwordError');

    if (password === "") {
      errorField.innerHTML = "Please enter your password";
      return false;
    } else if (!regex1.test(password)) {
      errorField.innerHTML = "Password must be at least 8 characters long and include uppercase, lowercase, number, and special character.";
      return false;
    } else {
      errorField.innerHTML = `Valid Password : ${password}`;
      return true;
    }
  }

  function validateConfirmPassword() {
    let password = document.getElementById('password').value;
    let confirmPassword = document.getElementById('confirm-password').value;
    let errorField = document.getElementById('confimpasswordError');

    if (confirmPassword === "") {
      errorField.innerHTML = "Please enter the password again";
      return false;
    } else if (password !== confirmPassword) {
      errorField.innerHTML = "Password does not match, please try again!";
      return false;
    } else {
      errorField.innerHTML = `Password Confirmed : ${confirmPassword}`;
      return true;
    }
  }

  function validateLoaction() {
    let location = document.getElementById('location').value;
    let errorField = document.getElementById('locationError');

    if (location === "") {
      errorField.innerHTML = "Please enter your location";
      return false;
    } else {
      errorField.innerHTML = `Location: ${location}`;
      return true;
    }
  }

  function validateZipcode() {
    let zipcode = document.getElementById('zipcode').value;
    const regex = /^\d{4}$/;
    let errorField = document.getElementById('zipcodeError');

    if (zipcode === "") {
      errorField.innerHTML = "Please enter your zipcode";
      return false;
    } else if (!regex.test(zipcode)) {
      errorField.innerHTML = "Please enter a valid 4-digit zipcode";
      return false;
    } else {
      errorField.innerHTML = `Zipcode: ${zipcode}`;
      return true;
    }
  }

  function validateCountry() {
    let country = document.getElementById('country').value;
    let errorField = document.getElementById('countryError');
  
    if (country === "") {
      errorField.innerHTML = "Please select your country";
      return false;
    } else {
      errorField.innerHTML = `Country Selected: ${country}`;
      return true;
    }
  }

  function validateTerms() {
  let checkbox = document.getElementById('terms');
  let errorField = document.getElementById('termsError');

  if (!checkbox.checked) {
    errorField.innerHTML = "You must agree to the terms and conditions.";
    return false;
  } else {
    errorField.innerHTML = `Thank you for agreeing!`;
    return true;
  }
}


function validateTerms() {
  let checkbox = document.getElementById('terms');
  let errorField = document.getElementById('termsError');

  if (!checkbox.checked) {
    errorField.innerHTML = "You must agree to the terms and conditions.";
    return false;
  } else {
    errorField.innerHTML = `<span class="success-message">Thank you for agreeing!</span>`;
    return true;
  }
}

  