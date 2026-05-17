function updateStatus(id,status)
{

var xhttp =
new XMLHttpRequest();

xhttp.onreadystatechange =
function()
{

if(this.readyState == 4
&& this.status == 200)
{

var data =
JSON.parse(this.responseText);

if(data.status == 1)
{

    document.getElementById(
    "status"+id
    ).innerHTML = "Active";

}
else
{

    document.getElementById(
    "status"+id
    ).innerHTML = "Disabled";

}

}

};

xhttp.open(
"POST",
"../../controller/admin/AdminController.php",
true
);

xhttp.setRequestHeader(
"Content-type",
"application/x-www-form-urlencoded"
);

xhttp.send(
"ajax=1&id="+id+
"&status="+status
);

}
