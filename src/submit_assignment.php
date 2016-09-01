<html>
<body>
<?php
session_start();
if ($_SESSION['session_user'] ==  null) header("Location: logout.php");


require('dbconnect.php');
require('user_req.php');
require('header.php');


$classid = $_GET['class_id'];
$fileid = $_GET['file_id'];
//$type=$_GET['type'];
//"http://localhost/main.php?email=" . $email_address . "&event_id=" . $event_id;
$form = "upload_submissions.php?classid=" . $classid . "&fileid=" . $fileid;
echo '<form action="' .$form . '" method="POST" enctype="multipart/form-data">';

$submission_date = `date +'%Y-%m-%d'`;
//echo "Submitted on: " . $submission_date . "<br />";
?>
<label for="file">Filename:</label>
<input type="file" name="file" id="file"><br>
<input type="hidden" name="submit_date" value="<?php echo $submission_date; ?>">
<input type="submit" name="submit" value="Submit">
</form>
</body>
</html>
