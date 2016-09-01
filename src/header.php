<?php
	require('dbconnect.php');
    require('user_req.php');

?>
<html>
<head><link rel="stylesheet" type="text/css" href="cssproperties.css"></head>
<div id="header">
	<!-- Add in code for a nav bar and put in new logo -->
   		<div id="logo">
    	<!-- This is just a blank link now, this link should be changed to go to our imediate home page or if when the person is logged in their homepage -->
        <!-- Later versions of this header will include (logout/login links, search bar, etc. )-->
    	<a href = "home.php" ><img src="images/MoocLogo.png" height = "75px" width:"auto"/></a>
        </div>
        <div id="socialNav">
       		<h3>"The future of online learning"</h3>
        </div>
        <ul id="globalNavBar">
            <li><a href="home.php" ><?php echo $session_user; ?></a></li>
            <li><a href="all_grades.php" >Grades</a></li>
            <li><a href="all_assignments.php" >Assignments</a></li>
            <li><a href="classes.php" >Classes</a></li>
            <li><a href="classmates.php" >Classmates</a></li>
            <li><a href="http://en.wikipedia.org/wiki/Massive_open_online_course" >About MOOC</a></li>
             <li><a href="logout.php">Logout</a></li>
       </ul>   
</div>
<body>

</body>
</html>
