<?php

require_once __DIR__ . "/../../config/EmployerAuth.php";
require_once __DIR__ . "/../../model/EmployerModel.php";

requireEmployer();

$applicationId = isset($_GET["application_id"]) ? (int)$_GET["application_id"] : 0;

if($applicationId <= 0)
{
    header("location:dashboard.php");
    exit();
}

$m = new EmployerModel();
$userId = (int)$_SESSION["user_id"];
$detail = $m->getApplicationDetail($applicationId, $userId);

if(!$detail)
{
    header("location:dashboard.php");
    exit();
}

$thread = $m->listMessagesForApplication($applicationId, $userId);

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="utf-8">
<title>
Messages
</title>

<link rel="stylesheet" href="../../assets/css/style.css">

</head>

<body class="employer-body">

<div class="employer-shell">

<?php include __DIR__ . "/employer_nav.php"; ?>

<div class="employer-main wide">

<h1>
Messages
</h1>

<p class="sub">
To:
<?php echo htmlspecialchars($detail["seeker_name"]); ?>

· Application #
<?php echo (int)$applicationId; ?>

·
<a href="applicant.php?id=<?php echo (int)$applicationId; ?>">
Applicant profile
</a>

</p>

<?php

if(!empty($_GET["sent"]))
{
    echo "<p class=\"msg ok\">Message sent.</p>";
}

if(!empty($_GET["err"]))
{
    echo "<p class=\"msg err\">Enter a message.</p>";
}

?>

<div class="message-thread">

<?php

if($thread)
{

    while($msg = $thread->fetch_assoc())
    {

        $mine = (int)$msg["sender_id"] === $userId;

?>

<div class="message-bubble<?php echo $mine ? " mine" : ""; ?>">

<div class="meta">
<?php echo htmlspecialchars($msg["sender_name"]); ?>

·
<?php echo htmlspecialchars($msg["sent_at"]); ?>

</div>

<div class="body">
<?php echo nl2br(htmlspecialchars($msg["body"])); ?>
</div>

</div>

<?php

    }

}

?>

</div>

<form method="post" action="../../controller/employee/EmployerMessageController.php" class="message-compose">

<input type="hidden" name="application_id" value="<?php echo (int)$applicationId; ?>">

<label>
New message
</label>
<textarea name="body" rows="4" required placeholder="Interview invitation, update, etc."></textarea>

<input type="submit" value="Send">

</form>

<p>
<a href="applications.php?job_id=<?php echo (int)$detail["job_id"]; ?>">
Back to applications
</a>
</p>

</div>

</div>

</body>
</html>
