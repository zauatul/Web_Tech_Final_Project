function seekerSaveJob(jobId)
{

var xhr = new XMLHttpRequest();
xhr.open("POST", "../../controller/seeker/SeekerAjaxController.php", true);
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
    var box = document.getElementById("save-job-" + jobId);

    if(data.ok && box)
    {
        box.textContent = data.saved ? "Saved" : "Save job";
    }
    else
    {
        alert(data.error || "Could not save job.");
    }

}
catch(e)
{
    alert("Server error.");
}

};

xhr.send(
"action=save_job"
+ "&job_id=" + encodeURIComponent(jobId)
);

}

function seekerRegisterValidate()
{

var name = document.getElementById("name").value;
var email = document.getElementById("email").value;
var password = document.getElementById("password").value;

if(name.trim() === "" || email.trim() === "" || password.trim() === "")
{
    alert("Please fill required fields.");
    return false;
}

return true;

}
