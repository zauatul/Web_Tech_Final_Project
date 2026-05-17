function recruiterSearchSeekers()
{
    var keyword = document.getElementById("keyword").value;

    var xhr = new XMLHttpRequest();

    xhr.open(
        "POST",
        "../../controller/recruiter/RecruiterAjaxController.php",
        true
    );

    xhr.setRequestHeader(
        "Content-type",
        "application/x-www-form-urlencoded"
    );

    xhr.onreadystatechange = function()
    {
        if(xhr.readyState == 4 && xhr.status == 200)
        {
            var data = JSON.parse(xhr.responseText);

            var box = document.getElementById("search-results");

            var html = "";

            if(data.ok == false)
            {
                html = "Search failed";
            }
            else
            {
                html += "<table class='employer-table'>";

                html += "<tr>";
                html += "<th>Name</th>";
                html += "<th>Headline</th>";
                html += "<th>Skills</th>";
                html += "<th>Experience</th>";
                html += "<th>Action</th>";
                html += "</tr>";

                for(var i = 0; i < data.rows.length; i++)
                {
                    html += "<tr>";

                    html += "<td>" + data.rows[i].name + "</td>";

                    html += "<td>" + data.rows[i].headline + "</td>";

                    html += "<td>" + data.rows[i].skills + "</td>";

                    html += "<td>" + data.rows[i].years_experience + "</td>";

                    html += "<td>";
                    html += "<a href='seeker_profile.php?id=" + data.rows[i].id + "'>";
                    html += "View";
                    html += "</a>";
                    html += "</td>";

                    html += "</tr>";
                }

                html += "</table>";
            }

            box.innerHTML = html;
        }
    };

    xhr.send(
        "action=search_seekers&keyword="
        + encodeURIComponent(keyword)
    );
}