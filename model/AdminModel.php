<?php

require_once __DIR__ .
"/../config/db.php";

    function adminLogin($email,$password)
    {

        global $conn;

        $sql =
        "SELECT * FROM users
        WHERE email=?
        AND password_hash=?
        AND role='admin'";

        $stmt =
        $conn->prepare($sql);

        $stmt->bind_param(
        "ss",
        $email,
        $password
        );

        $stmt->execute();

        return $stmt->get_result();

    }

    function getAllUsers()
    {

        global $conn;

        $sql =
        "SELECT * FROM users";

        return $conn->query($sql);

    }

    function updateUserStatus(
    $id,
    $status
    )
    {

        global $conn;

        $sql =
        "UPDATE users
        SET is_active=?
        WHERE id=?";

        $stmt =
        $conn->prepare($sql);

        $stmt->bind_param(
        "ii",
        $status,
        $id
        );

        return $stmt->execute();

    }

    function getCategories()
    {

        global $conn;

        $sql =
        "SELECT * FROM categories";

        return $conn->query($sql);

    }

    function addCategory(
    $name,
    $description
    )
    {

        global $conn;

        $sql =
        "INSERT INTO categories
        (name,description)
        VALUES(?,?)";

        $stmt =
        $conn->prepare($sql);

        $stmt->bind_param(
        "ss",
        $name,
        $description
        );

        return $stmt->execute();

    }

    function deleteCategory(
    $id
    )
    {

        global $conn;

        $sql =
        "DELETE FROM categories
        WHERE id=?";

        $stmt =
        $conn->prepare($sql);

        $stmt->bind_param(
        "i",
        $id
        );

        return $stmt->execute();

    }

    function getComplaints()
    {

        global $conn;

        $sql =
        "SELECT * FROM complaints";

        return $conn->query($sql);

    }

    function resolveComplaint(
    $id
    )
    {

        global $conn;

        $sql =
        "UPDATE complaints
        SET status='resolved'
        WHERE id=?";

        $stmt =
        $conn->prepare($sql);

        $stmt->bind_param(
        "i",
        $id
        );

        return $stmt->execute();

    }

    function totalUsers()
    {

        global $conn;

        $sql =
        "SELECT COUNT(*) as total
        FROM users";

        $result =
        $conn->query($sql);

        $row =
        $result->fetch_assoc();

        return $row['total'];

    }

    function totalJobs()
    {

        global $conn;

        $sql =
        "SELECT COUNT(*) as total
        FROM jobs";

        $result =
        $conn->query($sql);

        $row =
        $result->fetch_assoc();

        return $row['total'];

    }

    function totalApplications()
    {

        global $conn;

        $sql =
        "SELECT COUNT(*) as total
        FROM applications";

        $result =
        $conn->query($sql);

        $row =
        $result->fetch_assoc();

        return $row['total'];

    }


?>
