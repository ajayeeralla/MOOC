<html>
<body>
<?php
$classid = $_GET['classid'];
//$type=$_GET['type'];
//"http://localhost/main.php?email=" . $email_address . "&event_id=" . $event_id;
$form = "upload_file.php?classid=" . $classid;
echo '<form action="' .$form . '" method="POST" enctype="multipart/form-data">';
?>
<label for="file">Filename:</label>
<input type="file" name="file" id="file"><br>
File type:
Assignment Name<input type="text" name="assignment_name" required/><br>
Due Date<input type="date" name="due_date" required/><br>
<select name="file_type">
	<option value="Test">Test</option>
	<option value="Quiz">Quiz</option>
	<option value="Homework">Homework</option>
	<option value="Project">Project</option>
	<option value="Materials">Materials</option>
</select>
<input type="submit" name="submit" value="Submit">
</form>
</body>
</html> 