
var btn_submit = document.getElementById('btn_submit')
var form_register = document.getElementById('form_register')
var state = '<?php echo $state; ?>'
var username_check = document.getElementById('username_check')
var email_check = document.getElementById('email_check')

window.onload = function () {
    if (btn_submit != null)
        btn_submit.disabled = true
    if (form_register != null)
        form_register.addEventListener('submit', function (e) {
            // prevent the form from submitting
            //e.preventDefault();
        });
}

function check_param_exists(id) {
    if (username_check == null && email_check == null)
        return;
    //if (username_check == null || email_check == null)
     //   return;
    var status_text
    var fld
    if (username_check !== null)
        if (id === 'username') {
            status_text = username_check
            fld = fld_username
            if (!validate_username()) {
                status_text.innerText = ''
                return;
            }
        }
    if (email_check !== null)
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
        console.log('DEBUG |'+ request.responseText + '|')
        if (request.responseText === 'found') {
            status_text.style.color = 'Red'
            status_text.innerText = id + ' already exists'
            if (btn_submit != null)
                btn_submit.disabled = true;
            return
        }
        if (request.responseText === 'not found') {
            status_text.style.color = 'Green'
            status_text.innerText =  id + ' is available'
            validate_form();
            return
        }

        if (request.responseText === 'invalid') {
            status_text.style.color = 'Red'
            status_text.innerText =  id + ' is invalid. Please choose another.'
            if (btn_submit != null)
                btn_submit.disabled = true;
            return
        }
        status_text.style.color = 'Red'
        status_text.innerText = 'Unknown Error'
    }
    request.open("POST","register/check_user_credential" , true)
    var data = {id: id, value: fld.value}
    request.send(JSON.stringify(data))
}
function validate_form() {
    btn_submit.disabled = true
    if (msg_error != null)
        msg_error.innerText = '';

    //FOR Email Reset Password and Email Verification Only.
    if (fld_email !== null && fld_password == null)
        if (username_check == null || email_check == null) {
            if (!validate_email())
                return false
            btn_submit.disabled = false
            return;
        }

    if (!validate_username())
        return false

    if  (username_check !== null && username_check.style.color === "red")
        return false

    if (!validate_email())
        return false

    if  (email_check !== null && email_check.style.color === "red")
        return false

    btn_submit.disabled = !validate_password()
}

function reload_form() {
    fld_password = document.getElementById('password')
    fld_cfmpassword = document.getElementById('password-repeat')
    fld_username = document.getElementById('username')
    fld_email = document.getElementById('email')
    msg_error = document.getElementById('message_error')
    btn_submit = document.getElementById('btn_submit')
    form_register = document.getElementById('form_register')
    state = '<?php echo $state; ?>'
    username_check = document.getElementById('username_check')
    email_check = document.getElementById('email_check')

    if (email_check !== null)
        email_check.innerText = ''
    if (msg_error !== null)
        msg_error.innerText = ''
    if (username_check !== null)
        username_check.innerText = ''

    if (fld_email !== null )
    {
        if (state === 'state_registration' || state === 'state_settings')
            if (email_check !== null)
                fld_email.onchange = function ()
                {
                    check_param_exists(fld_email.id);
                    if (email_check.style.color === "green")
                        validate_form();
                }
        fld_email.onkeyup = validate_form;
    }

    if (state === 'state_registration' || state === 'state_settings')
        if (fld_username !== null && username_check !== null) {
            fld_username.onchange = function () {

                check_param_exists(fld_username.id);
                if (username_check.style.color === "green")
                    validate_form();
            }
            fld_username.onkeyup = validate_form;
        }
    if (fld_password !== null) {
        fld_password.onkeyup = validate_form;
        fld_password.onchange = validate_form;
    }
    if ( fld_cfmpassword !== null) {
        fld_cfmpassword.onkeyup = validate_form;
        fld_cfmpassword.onchange = validate_form;
    }
    if (btn_submit != null)
        btn_submit.disabled = true
}

reload_form()