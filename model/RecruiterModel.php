<?php

require_once __DIR__ . "/../config/db.php";

function emailExists($email){
    global $conn;

    $sql = "SELECT id FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    return mysqli_num_rows($result) > 0;
}

function registerRecruiter($name, $email, $password, $phone, $agencyName){
    global $conn;

    $sql = "INSERT INTO users (name,email,password_hash,phone,role,profile_pic,is_active,is_verified) VALUES ('$name','$email','$password','$phone','recruiter','',1,1)";
    $result = mysqli_query($conn, $sql);

    if(!$result){
        return false;
    }

    $userId = mysqli_insert_id($conn);

    $sql2 = "INSERT INTO recruiter_profiles (user_id,agency_name,specialization,description,website) VALUES ('$userId','$agencyName','','','')";
    mysqli_query($conn, $sql2);

    return $userId;
}

function loginRecruiter($email, $password){
    global $conn;

    $sql = "SELECT id,name,email,is_active FROM users WHERE email='$email' AND password_hash='$password' AND role='recruiter' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    return mysqli_fetch_assoc($result);
}

function searchSeekers($keyword){
    global $conn;

    $sql = "SELECT u.id,u.name,u.email,u.phone,sp.headline,sp.skills,sp.years_experience,sp.education_level,sp.preferred_location 
    FROM users u LEFT JOIN seeker_profiles sp 
    ON sp.user_id=u.id WHERE u.role='seeker' AND u.is_active=1 AND (u.name LIKE '%$keyword%' OR sp.headline LIKE '%$keyword%' OR
    sp.skills LIKE '%$keyword%' OR sp.preferred_location LIKE '%$keyword%') ORDER BY u.name ASC";

    return mysqli_query($conn, $sql);
}

function getSeekerProfile($seekerId){
    global $conn;

    $sql = "SELECT u.id,u.name,u.email,u.phone,sp.headline,sp.summary,sp.skills,sp.years_experience,sp.education_level,sp.current_salary,
    sp.expected_salary,sp.preferred_location,sp.resume_path 
    FROM users u LEFT JOIN seeker_profiles sp ON sp.user_id=u.id WHERE u.id='$seekerId' AND u.role='seeker' LIMIT 1";

    $result = mysqli_query($conn, $sql);

    return mysqli_fetch_assoc($result);
}

function sendOutreach($recruiterId, $seekerId, $subject, $message){
    global $conn;

    $fullMessage = $subject . "\n\n" . $message;

    $sql = "INSERT INTO recruiter_outreach (recruiter_id,seeker_id,job_id,message,status) VALUES ('$recruiterId','$seekerId','','$fullMessage','sent')";

    return mysqli_query($conn, $sql);
}

function listClients($recruiterId){
    global $conn;

    $sql = "SELECT rc.*,u.name AS employer_name,u.email AS employer_email,ep.company_name 
    FROM recruiter_clients rc JOIN users u ON u.id=rc.employer_id LEFT JOIN employer_profiles ep ON ep.user_id=rc.employer_id 
    WHERE rc.recruiter_id='$recruiterId' ORDER BY rc.added_at DESC";

    return mysqli_query($conn, $sql);
}

function listAvailableEmployers($recruiterId){
    global $conn;

    $sql = "SELECT u.id,u.name,u.email,ep.company_name FROM users u LEFT JOIN employer_profiles ep ON ep.user_id=u.id 
    WHERE u.role='employer' AND u.is_active=1 AND u.id NOT IN (SELECT employer_id FROM recruiter_clients WHERE recruiter_id='$recruiterId') 
    ORDER BY ep.company_name ASC,u.name ASC";

    return mysqli_query($conn, $sql);
}

function clientBelongsToRecruiter($recruiterId, $employerId){
    global $conn;

    $sql = "SELECT id FROM recruiter_clients WHERE recruiter_id='$recruiterId' AND employer_id='$employerId' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    return mysqli_num_rows($result);
}

function addClient($recruiterId, $employerId, $companyNameOverride){
    global $conn;

    if(clientBelongsToRecruiter($recruiterId, $employerId)){
        return false;
    }

    $sql = "INSERT INTO recruiter_clients (recruiter_id,employer_id,company_name_override) VALUES ('$recruiterId','$employerId','$companyNameOverride')";

    return mysqli_query($conn, $sql);
}

function listCategories(){
    global $conn;

    $sql = "SELECT id,name FROM categories ORDER BY name ASC";

    return mysqli_query($conn, $sql);
}

function createJobForClient($recruiterId, $employerId, $categoryId, $title, $description, $requirements, $benefits, $salaryMin, $salaryMax, $location, $jobType, $experienceLevel, $deadline, $status){
    global $conn;

    if(!clientBelongsToRecruiter($recruiterId, $employerId)){
        return false;
    }

    $sql = "INSERT INTO jobs (employer_id,recruiter_id,category_id,title,description,requirements,benefits,salary_min,salary_max,location,job_type,experience_level,deadline,status,is_featured) VALUES ('$employerId','$recruiterId','$categoryId','$title','$description','$requirements','$benefits','$salaryMin','$salaryMax','$location','$jobType','$experienceLevel','$deadline','$status',0)";

    return mysqli_query($conn, $sql);
}

function listPostedJobs($recruiterId){
    global $conn;

    $sql = "SELECT j.*,u.name AS employer_name,ep.company_name FROM jobs j JOIN users u ON u.id=j.employer_id LEFT JOIN employer_profiles ep ON ep.user_id=j.employer_id WHERE j.recruiter_id='$recruiterId' ORDER BY j.created_at DESC";

    return mysqli_query($conn, $sql);
}

?>