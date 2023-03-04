
var fld_password = document.getElementById('password')
var fld_username = document.getElementById('username')
var btn_login_submit = document.getElementById('btn_login_submit')
var state = '<?php echo $state; ?>'
var message = '<?php echo $message; ?>'
function validate_username() {
    if (fld_username == null)
        return true
    const min = 3, max = 25;
    const isRequired = value => value !== '';
    const isBetween = (length, min, max) => !(length < min || length > max);
    const username = fld_username.value
    if (!isRequired(username))
        return false
    if (!isBetween(username.length, min, max))
        return false
    if (/\s/.test(username))
        return false
    return !/\t/.test(username);
}


function password_complex() {
    if (fld_password == null)
        return true
    if (!fld_password.value.match(/[a-z]/g))
        return false
    if (!fld_password.value.match(/[A-Z]/g))
        return false
    if (!fld_password.value.match(/[0-9]/g))
        return false
    if (!fld_password.value.match(/[\\@#$-/:-?{-~!"^_`\[\]]/g))
        return false
    if (fld_password.value.length < 8)
        return false
    if (fld_password.value.length > 100)
        return false
    return !/\s/.test(fld_password.value);

}

function login_alert(message) {
    alert(message);
}

function validate_form() {
    if (!validate_username())
        return false;
    btn_login_submit.disabled = !validate_username()
}

if (fld_username != null)
    if (fld_password !== null)
        if (btn_login_submit !== null) {
            console.log("GOT")
            fld_password.onchange = validate_form
            fld_username.onchange = validate_form
            fld_username.onkeyup = fld_password.onkeyup = validate_form
            btn_login_submit.disabled = true
        }
console.log(state);
if (state === 'state_error') {
    alert(message)
   // window.location.href = 'http://camagru.sg'
}
