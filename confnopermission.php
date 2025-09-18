<?php 
$page_title = "no permission"; //title of page
$page_name="conferences"; //name of active menu button
$page_status=0; //who can visit this page; 0 = everyone, 1 = members
require "./includes/header.inc.php";
?>
<h3>Ooops! you are not yet logged into the conference site, read the following instruction:</h3>
<p>You must be registered for the conference to access the abstract submission page. Note that this conference registration is different from registering to become IFHA member. Click on one of following links:</p>
<p><a href="conflogin.php">>> Login</a><br />
<a href="confregister.php">>> Register</a></p>
<div class="top"><a href="#top">top</a></div>
<?php require "./includes/footer.inc.php" ?>