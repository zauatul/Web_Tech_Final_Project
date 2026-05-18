<?php

include_once __DIR__ .
"/../config/db.php";

     function emailExists($email)
    {

        global $conn;

        $sql =
        "SELECT id FROM users WHERE email=? LIMIT 1";

        $stmt =
        $conn->prepare($sql);

        $stmt->bind_param(
        "s",
        $email
        );

        $stmt->execute();

        $ok =
        $stmt->get_result()->num_rows > 0;

        $stmt->close();

        return $ok;

    }

     function registerSeeker(
        $name,
        $email,
        $password,
        $phone,
        $headline
    )
    {

        global $conn;

        $conn->begin_transaction();

        $role =
        "seeker";

        $profilePic =
        null;

        $isActive =
        1;

        $isVerified =
        1;

        $sql =
        "INSERT INTO users
        (name,email,password_hash,phone,role,profile_pic,is_active,is_verified)
        VALUES (?,?,?,?,?,?,?,?)";

        $stmt =
        $conn->prepare($sql);

        $stmt->bind_param(
        "ssssssii",
        $name,
        $email,
        $password,
        $phone,
        $role,
        $profilePic,
        $isActive,
        $isVerified
        );

        if(!$stmt->execute())
        {
            $stmt->close();
            $conn->rollback();
            return false;
        }

        $userId =
        (int)$conn->insert_id;

        $stmt->close();

        $summary =
        "";

        $skills =
        "";

        $yearsExperience =
        0;

        $educationLevel =
        "";

        $currentSalary =
        0;

        $expectedSalary =
        0;

        $preferredLocation =
        "";

        $resumePath =
        "";

        $sql2 =
        "INSERT INTO seeker_profiles
        (user_id,headline,summary,skills,years_experience,education_level,
        current_salary,expected_salary,preferred_location,resume_path)
        VALUES (?,?,?,?,?,?,?,?,?,?)";

        $stmt2 =
        $conn->prepare($sql2);

        $stmt2->bind_param(
        "isssisddss",
        $userId,
        $headline,
        $summary,
        $skills,
        $yearsExperience,
        $educationLevel,
        $currentSalary,
        $expectedSalary,
        $preferredLocation,
        $resumePath
        );

        if(!$stmt2->execute())
        {
            $stmt2->close();
            $conn->rollback();
            return false;
        }

        $stmt2->close();
        $conn->commit();

        return $userId;

    }

     function loginSeeker(
        $email,
        $password
    )
    {

        global $conn;

        $role =
        "seeker";

        $sql =
        "SELECT id,name,email,is_active
        FROM users
        WHERE email=? AND password_hash=? AND role=?
        LIMIT 1";

        $stmt =
        $conn->prepare($sql);

        $stmt->bind_param(
        "sss",
        $email,
        $password,
        $role
        );

        $stmt->execute();

        $row =
        $stmt->get_result()->fetch_assoc();

        $stmt->close();

        return $row ?: null;

    }

     function getProfile($userId)
    {

        global $conn;

        $sql =
        "SELECT sp.*, u.name, u.email, u.phone
        FROM seeker_profiles sp
        JOIN users u ON u.id = sp.user_id
        WHERE sp.user_id=?
        LIMIT 1";

        $stmt =
        $conn->prepare($sql);

        $stmt->bind_param(
        "i",
        $userId
        );

        $stmt->execute();

        $row =
        $stmt->get_result()->fetch_assoc();

        $stmt->close();

        return $row;

    }

     function updateProfile(
        $userId,
        $name,
        $phone,
        $headline,
        $summary,
        $skills,
        $yearsExperience,
        $educationLevel,
        $currentSalary,
        $expectedSalary,
        $preferredLocation,
        $resumePath
    )
    {

        global $conn;

        $sqlUser =
        "UPDATE users SET name=?, phone=? WHERE id=?";

        $stmtUser =
        $conn->prepare($sqlUser);

        $stmtUser->bind_param(
        "ssi",
        $name,
        $phone,
        $userId
        );

        $okUser =
        $stmtUser->execute();

        $stmtUser->close();

        if($resumePath !== "")
        {

            $sql =
            "UPDATE seeker_profiles
            SET headline=?, summary=?, skills=?, years_experience=?,
            education_level=?, current_salary=?, expected_salary=?,
            preferred_location=?, resume_path=?
            WHERE user_id=?";

            $stmt =
            $conn->prepare($sql);

            $stmt->bind_param(
            "sssisddssi",
            $headline,
            $summary,
            $skills,
            $yearsExperience,
            $educationLevel,
            $currentSalary,
            $expectedSalary,
            $preferredLocation,
            $resumePath,
            $userId
            );

        }
        else
        {

            $sql =
            "UPDATE seeker_profiles
            SET headline=?, summary=?, skills=?, years_experience=?,
            education_level=?, current_salary=?, expected_salary=?,
            preferred_location=?
            WHERE user_id=?";

            $stmt =
            $conn->prepare($sql);

            $stmt->bind_param(
            "sssisddsi",
            $headline,
            $summary,
            $skills,
            $yearsExperience,
            $educationLevel,
            $currentSalary,
            $expectedSalary,
            $preferredLocation,
            $userId
            );

        }

        $okProfile =
        $stmt->execute();

        $stmt->close();

        return $okUser && $okProfile;

    }

     function listActiveJobs($keyword)
    {

        global $conn;

        $keywordLike =
        "%" . $keyword . "%";

        $sql =
        "SELECT j.*, u.name AS employer_name
        FROM jobs j
        JOIN users u ON u.id = j.employer_id
        WHERE j.status='active'
        AND (j.title LIKE ? OR j.description LIKE ? OR j.location LIKE ?)
        ORDER BY j.created_at DESC";

        $stmt =
        $conn->prepare($sql);

        $stmt->bind_param(
        "sss",
        $keywordLike,
        $keywordLike,
        $keywordLike
        );

        $stmt->execute();

        return $stmt->get_result();

    }

     function hasApplied(
        $seekerId,
        $jobId
    )
    {

        global $conn;

        $sql =
        "SELECT id FROM applications WHERE seeker_id=? AND job_id=? LIMIT 1";

        $stmt =
        $conn->prepare($sql);

        $stmt->bind_param(
        "ii",
        $seekerId,
        $jobId
        );

        $stmt->execute();

        $ok =
        $stmt->get_result()->num_rows > 0;

        $stmt->close();

        return $ok;

    }

     function applyJob(
        $seekerId,
        $jobId,
        $coverLetter,
        $resumePath
    )
    {

        global $conn;

        if(hasApplied(
        $seekerId,
        $jobId
        ))
        {
            return false;
        }

        $status =
        "submitted";

        $sql =
        "INSERT INTO applications
        (job_id,seeker_id,cover_letter,resume_path,status)
        VALUES (?,?,?,?,?)";

        $stmt =
        $conn->prepare($sql);

        $stmt->bind_param(
        "iisss",
        $jobId,
        $seekerId,
        $coverLetter,
        $resumePath,
        $status
        );

        $ok =
        $stmt->execute();

        $stmt->close();

        return $ok;

    }

     function isSaved(
        $seekerId,
        $jobId
    )
    {

        global $conn;

        $sql =
        "SELECT id FROM saved_jobs WHERE user_id=? AND job_id=? LIMIT 1";

        $stmt =
        $conn->prepare($sql);

        $stmt->bind_param(
        "ii",
        $seekerId,
        $jobId
        );

        $stmt->execute();

        $ok =
        $stmt->get_result()->num_rows > 0;

        $stmt->close();

        return $ok;

    }

     function toggleSavedJob(
        $seekerId,
        $jobId
    )
    {

        global $conn;

        if(isSaved(
        $seekerId,
        $jobId
        ))
        {
            $sql =
            "DELETE FROM saved_jobs WHERE user_id=? AND job_id=?";

            $stmt =
            $conn->prepare($sql);

            $stmt->bind_param(
            "ii",
            $seekerId,
            $jobId
            );

            $ok =
            $stmt->execute();

            $stmt->close();

            return [$ok, false];
        }

        $sql =
        "INSERT INTO saved_jobs
        (user_id,job_id)
        VALUES (?,?)";

        $stmt =
        $conn->prepare($sql);

        $stmt->bind_param(
        "ii",
        $seekerId,
        $jobId
        );

        $ok =
        $stmt->execute();

        $stmt->close();

        return [$ok, true];

    }

     function listAppliedJobs($seekerId)
    {

        global $conn;

        $sql =
        "SELECT a.*, j.title, j.location, j.job_type, u.name AS employer_name
        FROM applications a
        JOIN jobs j ON j.id = a.job_id
        JOIN users u ON u.id = j.employer_id
        WHERE a.seeker_id=?
        ORDER BY a.applied_at DESC";

        $stmt =
        $conn->prepare($sql);

        $stmt->bind_param(
        "i",
        $seekerId
        );

        $stmt->execute();

        return $stmt->get_result();

    }

     function listSavedJobs($seekerId)
    {

        global $conn;

        $sql =
        "SELECT s.*, j.title, j.location, j.job_type, j.status, u.name AS employer_name
        FROM saved_jobs s
        JOIN jobs j ON j.id = s.job_id
        JOIN users u ON u.id = j.employer_id
        WHERE s.user_id=?
        ORDER BY s.saved_at DESC";

        $stmt =
        $conn->prepare($sql);

        $stmt->bind_param(
        "i",
        $seekerId
        );

        $stmt->execute();

        return $stmt->get_result();

    }

     function getJob($jobId)
    {

        global $conn;

        $sql =
        "SELECT j.*, u.name AS employer_name
        FROM jobs j
        JOIN users u ON u.id = j.employer_id
        WHERE j.id=? AND j.status='active'
        LIMIT 1";

        $stmt =
        $conn->prepare($sql);

        $stmt->bind_param(
        "i",
        $jobId
        );

        $stmt->execute();

        $row =
        $stmt->get_result()->fetch_assoc();

        $stmt->close();

        return $row;

    }


?>
