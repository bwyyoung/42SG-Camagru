

var btn_login_submit = document.getElementById('btn_login_submit')
var state = '<?php echo $state; ?>'
var message = '<?php echo $message; ?>'

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
if (state === 'state_error') {
    alert(message)
   // window.location.href = 'http://camagru.sg'
}
