
var fld_password = document.getElementById('password')
var fld_cfmpassword = document.getElementById('password-repeat')
var fld_username = document.getElementById('username')
var fld_email = document.getElementById('email')
var msg_error = document.getElementById('message_error')
function password_complex() {
    if (!fld_password.value.match(/[a-z]/g)) {
        if (msg_error !== null)
            msg_error.innerText  += 'Password requires lowercase letters.\n'
        return false
    }
    if (!fld_password.value.match(/[A-Z]/g)) {
        if (msg_error !== null)
            msg_error.innerText  += 'Password requires UPPERCASE letters.\n'
        return false
    }
    if (!fld_password.value.match(/[0-9]/g)) {
        if (msg_error !== null)
            msg_error.innerText  += 'Password requires numbers.\n'
        return false
    }
    if (!fld_password.value.match(/[\\@#$-/:-?{-~!"^_`\[\]]/g)) {
        if (msg_error !== null)
            msg_error.innerText  += 'Password requires symbols.\n'
        return false
    }
    if (fld_password.value.length < 8) {
        if (msg_error !== null)
            msg_error.innerText  += 'Password must have minimum 8 characters.\n'
        return false
    }
    if (fld_password.value.length > 100) {
        if (msg_error !== null)
            msg_error.innerText  += 'Password must have maximum 100 characters.\n'
        return false
    }
    if (/\s/.test(fld_password.value)) {
        if (msg_error !== null)
            msg_error.innerText += 'password must not have spaces.\n'
        return false
    }
    return true;
}


function validate_email() {
    var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    if (!fld_email.value.match(validRegex)) {
        if (msg_error !== null)
            msg_error.innerText += 'Email is invalid.\n'
        return false
    }
    if (/\s/.test(fld_email.value)) {
        if (msg_error !== null)
            msg_error.innerText += 'Email must not have spaces.\n'
        return false
    }
    if (/\t/.test(fld_email.value)) {
        if (msg_error !== null)
            msg_error.innerText += 'Email must not have tabs.\n'
        return false
    }
    return true
}

function password_match() {
    if (fld_password.value !== fld_cfmpassword.value) {
        if (msg_error !== null)
            msg_error.innerText  += 'Password and Confirm Password fields do not match.\n'
        return false
    }
    return true
}

function validate_username() {
    if (fld_username == null)
        return true
    const min = 3, max = 25;
    const isRequired = value => value !== '';
    const isBetween = (length, min, max) => !(length < min || length > max);
    const username = fld_username.value
    if (!isRequired(username)) {
        if (msg_error !== null)
            msg_error.innerText  += 'Username cannot be blank.\n'
        return false
    }
    if (!isBetween(username.length, min, max)) {
        if (msg_error !== null)
            msg_error.innerText  += 'Username must be between ' + min + ' and '
                + max +' characters.\n'
        return false
    }
    if (/\s/.test(username)) {
        if (msg_error !== null)
            msg_error.innerText += 'Username must not have spaces.\n'
        return false
    }
    if (/\t/.test(username)) {
        if (msg_error !== null)
            msg_error.innerText += 'Username must not have tabs.\n'
        return false
    }
    return true
}


function validate_password() {
    if (!password_complex())
        return false
    return password_match();
}