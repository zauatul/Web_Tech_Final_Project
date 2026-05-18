<?php

include_once __DIR__ . "/../config/db.php";

class EmployerModel
{

    private $conn;

    public function __construct()
    {

        global $conn;
        $this->conn = $conn;

    }

    private function bindDynamicParams($stmt, $types, array $params)
    {

        $refs = [];
        $refs[] = &$types;

        for($i = 0; $i < count($params); $i++)
        {
            $refs[] = &$params[$i];
        }

        call_user_func_array([$stmt, "bind_param"], $refs);

    }

    public function registerEmployer(
        $name,
        $email,
        $passwordPlain,
        $phone,
        $companyName,
        $industry,
        $companySize,
        $description,
        $website,
        $address
    )
    {

        $this->conn->begin_transaction();

        $role = "employer";
        $isActive = 0;
        $isVerified = 1;
        $profilePic = null;

        $sql =
        "INSERT INTO users
        (name,email,password_hash,phone,role,profile_pic,is_active,is_verified)
        VALUES (?,?,?,?,?,?,?,?)";

        $stmt = $this->conn->prepare($sql);

        if(!$stmt)
        {
            $this->conn->rollback();
            return false;
        }

        $stmt->bind_param(
            "ssssssii",
            $name,
            $email,
            $passwordPlain,
            $phone,
            $role,
            $profilePic,
            $isActive,
            $isVerified
        );

        if(!$stmt->execute())
        {
            $stmt->close();
            $this->conn->rollback();
            return false;
        }

        $userId = (int)$this->conn->insert_id;
        $stmt->close();

        $sql2 =
        "INSERT INTO employer_profiles
        (user_id,company_name,industry,company_size,description,website,address,logo_path)
        VALUES (?,?,?,?,?,?,?,?)";

        $logoPath = null;
        $stmt2 = $this->conn->prepare($sql2);

        if(!$stmt2)
        {
            $this->conn->rollback();
            return false;
        }

        $stmt2->bind_param(
            "isssssss",
            $userId,
            $companyName,
            $industry,
            $companySize,
            $description,
            $website,
            $address,
            $logoPath
        );

        if(!$stmt2->execute())
        {
            $stmt2->close();
            $this->conn->rollback();
            return false;
        }

        $stmt2->close();
        $this->conn->commit();
        return $userId;

    }

    public function emailExists($email)
    {

        $sql = "SELECT id FROM users WHERE email = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result();
        $ok = $res->num_rows > 0;
        $stmt->close();
        return $ok;

    }

    public function loginEmployer($email, $passwordPlain)
    {

        $role = "employer";
        $sql =
        "SELECT u.id,u.name,u.email,u.password_hash,u.is_active,u.is_verified
        FROM users u
        WHERE u.email = ?
        AND u.password_hash = ?
        AND u.role = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $email, $passwordPlain, $role);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row ?: null;

    }

    public function getProfileByUserId($userId)
    {

        $sql =
        "SELECT ep.*, u.name AS contact_name, u.email, u.phone
        FROM employer_profiles ep
        JOIN users u ON u.id = ep.user_id
        WHERE ep.user_id = ?
        LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $row;

    }

    public function updateEmployerProfile(
        $userId,
        $companyName,
        $industry,
        $companySize,
        $description,
        $website,
        $address,
        $logoPathOrNull
    )
    {

        if($logoPathOrNull !== null)
        {

            $sql =
            "UPDATE employer_profiles
            SET company_name=?, industry=?, company_size=?, description=?,
            website=?, address=?, logo_path=?
            WHERE user_id=?";

            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param(
                "sssssssi",
                $companyName,
                $industry,
                $companySize,
                $description,
                $website,
                $address,
                $logoPathOrNull,
                $userId
            );

        }
        else
        {

            $sql =
            "UPDATE employer_profiles
            SET company_name=?, industry=?, company_size=?, description=?,
            website=?, address=?
            WHERE user_id=?";

            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param(
                "ssssssi",
                $companyName,
                $industry,
                $companySize,
                $description,
                $website,
                $address,
                $userId
            );

        }

        $ok = $stmt->execute();
        $stmt->close();
        return $ok;

    }

    public function listCategories()
    {

        $sql = "SELECT id, name, description FROM categories ORDER BY name ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->get_result();

    }

    public function createJob(
        $employerUserId,
        $categoryId,
        $title,
        $description,
        $requirements,
        $benefits,
        $salaryMin,
        $salaryMax,
        $location,
        $jobType,
        $experienceLevel,
        $deadline,
        $status
    )
    {

        $sql =
        "INSERT INTO jobs
        (employer_id,category_id,title,description,requirements,benefits,
        salary_min,salary_max,location,job_type,experience_level,deadline,status,is_featured)
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,0)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "iissssiisssss",
            $employerUserId,
            $categoryId,
            $title,
            $description,
            $requirements,
            $benefits,
            $salaryMin,
            $salaryMax,
            $location,
            $jobType,
            $experienceLevel,
            $deadline,
            $status
        );
        $ok = $stmt->execute();
        $id = $ok ? $this->conn->insert_id : 0;
        $stmt->close();
        return $id;

    }

    public function updateJob(
        $jobId,
        $employerUserId,
        $categoryId,
        $title,
        $description,
        $requirements,
        $benefits,
        $salaryMin,
        $salaryMax,
        $location,
        $jobType,
        $experienceLevel,
        $deadline,
        $status
    )
    {

        $sql =
        "UPDATE jobs SET category_id=?, title=?, description=?, requirements=?,
        benefits=?, salary_min=?, salary_max=?, location=?, job_type=?,
        experience_level=?, deadline=?, status=?
        WHERE id=? AND employer_id=?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "issssiisssssii",
            $categoryId,
            $title,
            $description,
            $requirements,
            $benefits,
            $salaryMin,
            $salaryMax,
            $location,
            $jobType,
            $experienceLevel,
            $deadline,
            $status,
            $jobId,
            $employerUserId
        );
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;

    }

    public function deleteJob($jobId, $employerUserId)
    {

        $sql = "DELETE FROM jobs WHERE id=? AND employer_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $jobId, $employerUserId);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;

    }

    public function setJobStatus($jobId, $employerUserId, $status)
    {

        $sql = "UPDATE jobs SET status=? WHERE id=? AND employer_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sii", $status, $jobId, $employerUserId);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;

    }

    public function getJobForEmployer($jobId, $employerUserId)
    {

        $sql = "SELECT * FROM jobs WHERE id=? AND employer_id=? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $jobId, $employerUserId);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $row;

    }

    public function listJobsDashboard($employerUserId)
    {

        $sql =
        "SELECT j.id, j.title, j.status, j.deadline, j.created_at,
        (SELECT COUNT(*) FROM applications a WHERE a.job_id = j.id) AS app_count
        FROM jobs j
        WHERE j.employer_id = ?
        ORDER BY j.created_at DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $employerUserId);
        $stmt->execute();
        return $stmt->get_result();

    }

    public function getApplicationsForJob(
        $jobId,
        $employerUserId,
        $filterStatus,
        $filterExpBand,
        $filterDateFrom,
        $filterDateTo
    )
    {

        $sql =
        "SELECT a.*,
        u.name AS seeker_name, u.email AS seeker_email,
        IFNULL(sp.years_experience, 0) AS years_experience,
        sp.headline, sp.education_level
        FROM applications a
        JOIN jobs j ON j.id = a.job_id
        JOIN users u ON u.id = a.seeker_id
        LEFT JOIN seeker_profiles sp ON sp.user_id = a.seeker_id
        WHERE j.id = ? AND j.employer_id = ?";

        $types = "ii";
        $params = [$jobId, $employerUserId];

        if($filterStatus !== "" && $filterStatus !== null)
        {
            $sql .= " AND a.status = ?";
            $types .= "s";
            $params[] = $filterStatus;
        }

        if($filterExpBand === "entry")
        {
            $sql .= " AND IFNULL(sp.years_experience,0) <= 2";
        }
        elseif($filterExpBand === "mid")
        {
            $sql .= " AND IFNULL(sp.years_experience,0) BETWEEN 3 AND 5";
        }
        elseif($filterExpBand === "senior")
        {
            $sql .= " AND IFNULL(sp.years_experience,0) >= 6";
        }

        if($filterDateFrom !== "" && $filterDateFrom !== null)
        {
            $sql .= " AND DATE(a.applied_at) >= ?";
            $types .= "s";
            $params[] = $filterDateFrom;
        }

        if($filterDateTo !== "" && $filterDateTo !== null)
        {
            $sql .= " AND DATE(a.applied_at) <= ?";
            $types .= "s";
            $params[] = $filterDateTo;
        }

        $sql .= " ORDER BY a.applied_at DESC";

        $stmt = $this->conn->prepare($sql);
        $this->bindDynamicParams($stmt, $types, $params);
        $stmt->execute();
        return $stmt->get_result();

    }

    public function getSeekerIdForApplication($applicationId, $employerUserId)
    {

        $sql =
        "SELECT a.seeker_id
        FROM applications a
        JOIN jobs j ON j.id = a.job_id
        WHERE a.id = ? AND j.employer_id = ?
        LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $applicationId, $employerUserId);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if(!$row)
        {
            return null;
        }

        return (int)$row["seeker_id"];

    }

    public function toggleActiveClosed($jobId, $employerUserId)
    {

        $row = $this->getJobForEmployer($jobId, $employerUserId);

        if(!$row)
        {
            return [false, null];
        }

        if($row["status"] === "draft")
        {
            return [false, "draft"];
        }

        $next = $row["status"] === "active" ? "closed" : "active";

        if($this->setJobStatus($jobId, $employerUserId, $next))
        {
            return [true, $next];
        }

        return [false, $row["status"]];

    }

    public function getApplicationDetail($applicationId, $employerUserId)
    {

        $sql =
        "SELECT a.*, j.title AS job_title, j.id AS job_id,
        u.name AS seeker_name, u.email AS seeker_email, u.phone AS seeker_phone,
        sp.headline, sp.summary, sp.skills, sp.years_experience, sp.education_level,
        sp.current_salary, sp.expected_salary, sp.preferred_location,
        sp.resume_path AS seeker_resume_path
        FROM applications a
        JOIN jobs j ON j.id = a.job_id
        JOIN users u ON u.id = a.seeker_id
        LEFT JOIN seeker_profiles sp ON sp.user_id = a.seeker_id
        WHERE a.id = ? AND j.employer_id = ?
        LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $applicationId, $employerUserId);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $row;

    }

    public function updateApplicationStatus(
        $applicationId,
        $employerUserId,
        $status
    )
    {

        $allowed =
        [
            "submitted",
            "reviewed",
            "shortlisted",
            "interview",
            "rejected",
            "withdrawn"
        ];

        if(!in_array($status, $allowed, true))
        {
            return false;
        }

        $sql =
        "UPDATE applications a
        JOIN jobs j ON j.id = a.job_id
        SET a.status = ?
        WHERE a.id = ? AND j.employer_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sii", $status, $applicationId, $employerUserId);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;

    }

    public function insertMessage(
        $senderId,
        $recipientId,
        $applicationId,
        $body
    )
    {

        $sql =
        "INSERT INTO messages (sender_id,recipient_id,application_id,body,is_read)
        VALUES (?,?,?,?,0)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iiis", $senderId, $recipientId, $applicationId, $body);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;

    }

    public function applicationBelongsToEmployer($applicationId, $employerUserId)
    {

        $sql =
        "SELECT a.id FROM applications a
        JOIN jobs j ON j.id = a.job_id
        WHERE a.id = ? AND j.employer_id = ?
        LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $applicationId, $employerUserId);
        $stmt->execute();
        $ok = $stmt->get_result()->num_rows > 0;
        $stmt->close();
        return $ok;

    }

    public function listMessagesForApplication($applicationId, $employerUserId)
    {

        if(!$this->applicationBelongsToEmployer($applicationId, $employerUserId))
        {
            return null;
        }

        $sql =
        "SELECT m.*, us.name AS sender_name
        FROM messages m
        JOIN users us ON us.id = m.sender_id
        WHERE m.application_id = ?
        ORDER BY m.sent_at ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $applicationId);
        $stmt->execute();
        return $stmt->get_result();

    }

    public function listShortlistedAllJobs($employerUserId)
    {

        $sql =
        "SELECT a.id AS application_id, a.status, a.applied_at,
        j.id AS job_id, j.title AS job_title,
        u.id AS seeker_id, u.name AS seeker_name, u.email AS seeker_email,
        sp.headline
        FROM applications a
        JOIN jobs j ON j.id = a.job_id
        JOIN users u ON u.id = a.seeker_id
        LEFT JOIN seeker_profiles sp ON sp.user_id = a.seeker_id
        WHERE j.employer_id = ? AND a.status IN ('shortlisted','interview')
        ORDER BY a.applied_at DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $employerUserId);
        $stmt->execute();
        return $stmt->get_result();

    }

    public function funnelCountsForJob($jobId, $employerUserId)
    {

        $sql =
        "SELECT a.status, COUNT(*) AS c
        FROM applications a
        JOIN jobs j ON j.id = a.job_id
        WHERE a.job_id = ? AND j.employer_id = ?
        GROUP BY a.status";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $jobId, $employerUserId);
        $stmt->execute();
        $res = $stmt->get_result();
        $out = [];
        while($row = $res->fetch_assoc())
        {
            $out[$row['status']] = (int)$row['c'];
        }
        $stmt->close();
        return $out;

    }

    public function applicationsOverTimeForJob($jobId, $employerUserId)
    {

        $sql =
        "SELECT DATE(a.applied_at) AS d, COUNT(*) AS c
        FROM applications a
        JOIN jobs j ON j.id = a.job_id
        WHERE a.job_id = ? AND j.employer_id = ?
        GROUP BY DATE(a.applied_at)
        ORDER BY d ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $jobId, $employerUserId);
        $stmt->execute();
        return $stmt->get_result();

    }

    public function companyAnalytics($employerUserId)
    {

        $sql =
        "SELECT COUNT(*) AS total_jobs FROM jobs WHERE employer_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $employerUserId);
        $stmt->execute();
        $totalJobs = (int)$stmt->get_result()->fetch_assoc()['total_jobs'];
        $stmt->close();

        $sql2 =
        "SELECT COUNT(*) AS total_apps
        FROM applications a
        JOIN jobs j ON j.id = a.job_id
        WHERE j.employer_id = ?";

        $stmt2 = $this->conn->prepare($sql2);
        $stmt2->bind_param("i", $employerUserId);
        $stmt2->execute();
        $totalApps = (int)$stmt2->get_result()->fetch_assoc()['total_apps'];
        $stmt2->close();

        $sql3 =
        "SELECT AVG(DATEDIFF(CURDATE(), DATE(a.applied_at))) AS avg_days
        FROM applications a
        JOIN jobs j ON j.id = a.job_id
        WHERE j.employer_id = ? AND a.status = 'shortlisted'";

        $stmt3 = $this->conn->prepare($sql3);
        $stmt3->bind_param("i", $employerUserId);
        $stmt3->execute();
        $avgRow = $stmt3->get_result()->fetch_assoc();
        $stmt3->close();

        $avgDaysShortlist = $avgRow['avg_days'] !== null
            ? round((float)$avgRow['avg_days'], 1)
            : null;

        return
        [
            "total_jobs" => $totalJobs,
            "total_applications" => $totalApps,
            "avg_days_to_shortlist" => $avgDaysShortlist
        ];

    }

    public function listRecruitersForCompany($employerUserId)
    {

        $sql =
        "SELECT DISTINCT u.id, u.name, u.email, rp.agency_name,
        rc.company_name_override, rc.added_at
        FROM recruiter_clients rc
        JOIN users u ON u.id = rc.recruiter_id
        LEFT JOIN recruiter_profiles rp ON rp.user_id = rc.recruiter_id
        WHERE rc.employer_id = ?
        ORDER BY rc.added_at DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $employerUserId);
        $stmt->execute();
        return $stmt->get_result();

    }

    public function listJobsPostedByRecruiters($employerUserId)
    {

        $sql =
        "SELECT j.id, j.title, j.status, j.created_at, j.recruiter_id,
        u.name AS recruiter_name, rp.agency_name
        FROM jobs j
        JOIN users u ON u.id = j.recruiter_id
        LEFT JOIN recruiter_profiles rp ON rp.user_id = j.recruiter_id
        WHERE j.employer_id = ? AND j.recruiter_id IS NOT NULL
        ORDER BY j.created_at DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $employerUserId);
        $stmt->execute();
        return $stmt->get_result();

    }

public function insertComplaint($submitterId, $subjectId, $description)
{
    $status = "open";
    $adminNote = "";

    // check subject user exists
    $check = $this->conn->prepare(
        "SELECT id FROM users WHERE id=?"
    );

    $check->bind_param("i", $subjectId);
    $check->execute();

    $result = $check->get_result();

    if($result->num_rows == 0)
    {
        return false;
    }

    $check->close();

    $sql =
    "INSERT INTO complaints
    (submitter_id,subject_id,description,status,admin_note)
    VALUES (?,?,?,?,?)";

    $stmt = $this->conn->prepare($sql);

    $stmt->bind_param(
        "iisss",
        $submitterId,
        $subjectId,
        $description,
        $status,
        $adminNote
    );

    $ok = $stmt->execute();

    $stmt->close();

    return $ok;
}

}

?>
