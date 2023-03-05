var tc = new Map()
var tabcontent = document.getElementsByClassName("tabcontent");
for (i = 0; i < tabcontent.length; i++)
{
    tc.set(tabcontent[i].id, tabcontent[i].innerHTML)
    tabcontent[i].innerHTML = '';
}

tabcontent[0].innerHTML = tc.get(tabcontent[0].id);

function openTab(evt, tabname) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
        tabcontent[i].innerHTML = '';
    }

    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tabname).innerHTML = tc.get(tabname)
    document.getElementById(tabname).style.display = "block";
    evt.currentTarget.className += " active";
    reload_form()
}
document.getElementById('Edit Username').style.display = "block";

function load_form()
{
    var head= document.getElementsByTagName('head')[0];
    var script= document.createElement('script');
    script.src= '/app/view/js/form.js';
    head.appendChild(script);
}
