<head><link rel="stylesheet" type="text/css" href="cssproperties.css"></head>
<div id="header">
   <!-- Add in code for a nav bar and put in new logo -->
         <div id="logo">
      <!-- This is just a blank link now, this link should be changed to go to our imediate home page or if when the person is logged in their homepage -->
        <!-- Later versions of this header will include (logout/login links, search bar, etc. )-->
      <a href = "#" ><img src="images/MoocLogo.png" height = "75px" width:"auto"/></a>
        </div>
        <div id="socialNav">
            <h3>"The future of online learning"</h3>
        </div>
        <ul id="globalNavBar">
            <li><a href="#" ></a></li>
            <li><a href="all_grades.php" ></a></li>
            <li><a href="#" ></a></li>
            <li><a href="#" ></a></li>
            <li><a href="#" ></a></li>
            <li><a href="http://en.wikipedia.org/wiki/Massive_open_online_course" >About MOOC</a></li>
             <li><a href="#"></a></li>
       </ul>
</div>
<body>

</body>

<?php
session_start();
if($_SESSION['login'] == 1)
{	
	$br = "<br />";
	echo $br . $br;
	require('dbconnect.php');


	if (isset($_GET['t']))
	{
		if ($_GET['t'] == "n")
		{
			
				echo "Looks like you forgot to fill this out! Before you can log in, you must enter in your information.";
			
		}
	}
	else
	{
		echo $br . "Registration complete.  Now that you're registered, why don't you tell us a little bit about yourself." . $br;
	 } 
	 ?>
		<form method="POST" action="updateuserinfo.php">
		First Name: <input type="text" name="FirstName" required/><br>
		Last Name: <input type="text" name="LastName" required/><br>
		Age: <input type="text" name="Age" required/><br>
		<input type="Submit" name="FirstUpdate" value="Update"/>
		</form>
<?php
	
}
else
{
	echo "session: " . $_SESSION['login'] . "<br />";
	echo "no";
}
