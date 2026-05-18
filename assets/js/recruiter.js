function recruiterSearchSeekers()
{

var keyword = document.getElementById("keyword").value;
var xhr = new XMLHttpRequest();

xhr.open("POST", "../../controller/recruiter/RecruiterAjaxController.php", true);
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
    var box = document.getElementById("search-results");
    var html = "";

    if(!data.ok)
    {
        alert(data.error || "Search failed.");
        return;
    }

    html += "<table class=\"employer-table\">";
    html += "<tr><th>Name</th><th>Headline</th><th>Skills</th><th>Experience</th><th></th></tr>";

    for(var i = 0; i < data.rows.length; i++)
    {
        html += "<tr>";
        html += "<td>" + escapeHtml(data.rows[i].name || "") + "</td>";
        html += "<td>" + escapeHtml(data.rows[i].headline || "") + "</td>";
        html += "<td>" + escapeHtml(data.rows[i].skills || "") + "</td>";
        html += "<td>" + escapeHtml(data.rows[i].years_experience || "0") + "</td>";
        html += "<td><a href=\"seeker_profile.php?id=" + encodeURIComponent(data.rows[i].id) + "\">View</a></td>";
        html += "</tr>";
    }

    html += "</table>";
    box.innerHTML = html;

}
catch(e)
{
    alert("Server error.");
}

};

xhr.send(
"action=search_seekers"
+ "&keyword=" + encodeURIComponent(keyword)
);

}

function escapeHtml(text)
{

return String(text)
.replace(/&/g, "&amp;")
.replace(/</g, "&lt;")
.replace(/>/g, "&gt;")
.replace(/"/g, "&quot;")
.replace(/'/g, "&#039;");

}
