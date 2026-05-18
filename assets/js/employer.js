function employerToggleJob(jobId)
{

var xhr = new XMLHttpRequest();
xhr.open("POST", "../../controller/employee/EmployerAjaxController.php", true);
xhr.setRequestHeader(
"Content-type",
"application/x-www-form-urlencoded"
);

xhr.onreadystatechange = function()
{

if(xhr.readyState !== 4)
{
    return;
}

var box = document.getElementById("job-status-" + jobId);

try
{

    var data = JSON.parse(xhr.responseText);

    if(data.ok && box)
    {
        box.textContent = data.status;
    }
    else
    {
        alert(data.error || "Could not toggle job.");
    }

}
catch(e)
{

    alert("Server error.");

}

};

xhr.send(
"action=toggle_job"
+ "&job_id=" + encodeURIComponent(jobId)
);

}

function employerApplicationStatus(applicationId, status)
{

var xhr = new XMLHttpRequest();
xhr.open("POST", "../../controller/employee/EmployerAjaxController.php", true);
xhr.setRequestHeader(
"Content-type",
"application/x-www-form-urlencoded"
);

xhr.onreadystatechange = function()
{

if(xhr.readyState !== 4)
{
    return;
}

try
{

    var data = JSON.parse(xhr.responseText);

    if(!data.ok)
    {
        alert("Could not update status.");
    }

}
catch(e)
{

    alert("Server error.");

}

};

xhr.send(
"action=application_status"
+ "&application_id=" + encodeURIComponent(applicationId)
+ "&status=" + encodeURIComponent(status)
);

}
