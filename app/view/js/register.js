

var btn_register_submit = document.getElementById('btn_register_submit')
var fld_password = document.getElementById('psw')
var fld_cfmpassword = document.getElementById('psw-repeat')
var fld_username = document.getElementById('username')
var fld_email = document.getElementById('email')
var msg_error = document.getElementById('message_error')
var username_check = document.getElementById('username_check')
var email_check = document.getElementById('email_check')
var form_register = document.getElementById('form_register')
btn_register_submit.disabled = true


function password_complex() {
    if (!fld_password.value.match(/[a-z]/g)) {
        msg_error.innerText  += 'Password requires lowercase letters.\n'
        return false
    }
    if (!fld_password.value.match(/[A-Z]/g)) {
        msg_error.innerText  += 'Password requires UPPERCASE letters.\n'
        return false
    }
    if (!fld_password.value.match(/[0-9]/g)) {
        msg_error.innerText  += 'Password requires numbers.\n'
        return false
    }
    if (fld_password.value.length < 8) {
        msg_error.innerText  += 'Password must have minimum 8 characters.\n'
        return false
    }
    if (/\s/.test(fld_password.value)) {
        msg_error.innerText += 'password must not have spaces.\n'
        return false
    }
    return true;
}

function password_match() {
    if (fld_password.value !== fld_cfmpassword.value) {
        msg_error.innerText  += 'Password and Confirm Password fields do not match.\n'
        return false
    }
    return true
}

function validate_username() {
    const min = 3, max = 25;
    const isRequired = value => value !== '';
    const isBetween = (length, min, max) => !(length < min || length > max);
    const username = fld_username.value
    if (!isRequired(username)) {
        msg_error.innerText  += 'Username cannot be blank.\n'
        return false
    }
    if (!isBetween(username.length, min, max)) {
        msg_error.innerText  += 'Username must be between ' + min + ' and '
            + max +' characters.\n'
        return false
    }
    if (/\s/.test(username)) {
        msg_error.innerText += 'Username must not have spaces.\n'
        return false
    }
    if (/\t/.test(username)) {
        msg_error.innerText += 'Username must not have tabs.\n'
        return false
    }
    return true
}

function validate_email() {
    var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    if (!fld_email.value.match(validRegex)) {
        msg_error.innerText += 'Email is invalid.\n'
        return false
    }
    if (/\s/.test(fld_email.value)) {
        msg_error.innerText += 'Email must not have spaces.\n'
        return false
    }
    if (/\t/.test(fld_email.value)) {
        msg_error.innerText += 'Email must not have tabs.\n'
        return false
    }
    return true
}

function validate_password() {
    if (!password_complex())
        return false
    return password_match();
}
function validate_form() {
    var span_message =
    msg_error.innerText = '';
    btn_register_submit.disabled = true
    if (!validate_username() || username_check.style.color === "red")
        return false
    if (!validate_email()|| email_check.style.color === "red")
        return false
    btn_register_submit.disabled = !validate_password()
}

window.onload = function () {
    btn_register_submit.disabled = true
    form_register.addEventListener('submit', function (e) {
        // prevent the form from submitting
        //e.preventDefault();
    });
}

function check_param_exists(id) {
    //msg_error.innerText = ''
    var status_text
    var fld
    if (id === 'username') {
        status_text = username_check
        fld = fld_username
        if (!validate_username()) {
            status_text.innerText = ''
            return;
        }
    }
    if (id === 'email') {
        status_text = email_check
        fld = fld_email
        if (!validate_email()) {
            status_text.innerText = ''
            return;
        }
    }

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if(request.readyState !== 4)
            return
        console.log(request.responseText)
        if (request.responseText === 'found') {
            status_text.style.color = 'Red'
            status_text.innerText = id + ' already exists'
            return
        }
        if (request.responseText === 'not found') {
            status_text.style.color = 'Green'
            status_text.innerText =  id + ' is available'
            return
        }
        status_text.style.color = 'Red'
        status_text.innerText = 'Unknown Error'
    }
    request.open("POST","register/check_user_credential" , true)
    var data = {id: id, value: fld.value}
    request.send(JSON.stringify(data))
}


fld_username.onchange = function () {
    check_param_exists(fld_username.id);
    if (username_check.style.color === "green")
        validate_form();
}

fld_email.onchange = function () {
    check_param_exists(fld_email.id);
    if (email_check.style.color === "green")
        validate_form();
}

fld_password.onchange = validate_form;
fld_username.onkeyup = fld_email.onkeyup = fld_password.onkeyup = fld_cfmpassword.onkeyup = validate_form;