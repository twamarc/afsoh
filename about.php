<?php 
$page_title = "About us"; //title of page
$page_name = "about"; //name of active menu button
$page_status = 0; //who can visit this page; 0 = everyone, 1 = members
require "./includes/header.inc.php";
require_once ("./admin/classes/news.class.php");
?>

<style>
img {
  display: block;
  margin-left: auto;
  margin-right: auto;
}
</style>

<body>
    <h3>About Us</h3>
    <p>The <strong>AfSoH</strong> initiative is a new project, started since June 2010.<br/> 
    The initiative is currently coordinated by an <strong>a.i. Steering Committee</strong> as the executive organ, and is still in the fundraising phase.<br/> 
    The current a.i. Steering Committee gathers 6 individuals: all of them are health professionals, scholars or scientists, or academicians active in the field of high blood pressure, hypertension, its risk factors and related complications in Africa.</p>
    <p>The mission and activities of <strong>AfSoH</strong>, as started in the initiative generic constitution, will be included in <font color="red"><strong>five task forces:</strong></font></p> 
    <div class="image-container">
        <img src="images/afsoh_task_forces.jpg" alt="Task forces in AfSoH" width="720" height="540" />
    </div>
    <h3><font color="blue">Please Join us if you share the goal of tackling high blood pressure and its risk factors in Africa</font></h3>
    <h4><p>For any suggestions, supports, questions, or comments, please contact the <a href="http://www.afsoh.com/contact.php"> <strong>a.i. Steering Committee</strong></a>: <br> Both by post, phone or e-mail are possible. For email, you have to send them to <a href="mailto:secretary@afsoh.com?Subject=AfSoH. via web: Questions/Comments/Suggestions &bcc=twamarc@gmail.com">secretary@afsoh.com</a></p>
	</h4>
</body>	

<?php require "./includes/footer.inc.php"; ?>
