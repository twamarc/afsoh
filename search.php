<?php 
$page_title = "Search"; //title of page
$page_name="search"; //name of active menu button
$page_status=0; //who can visit this page; 0 = everyone, 1 = members
require "./includes/header.inc.php";
?>
<h3>Search</h3>
<form method="get" action="http://www.google.com/search">

<div class="search">
<table border="0" cellpadding="0">
<tr><td>
<input type="text"   name="q" size="25"
 maxlength="255" value="" />
<input type="submit" value="Google Search" /></td></tr>
<tr><td align="center" style="font-size:75%">
<input type="checkbox"  name="sitesearch"
 value="pash-onweb.com" checked /> only search AfSoH website<br />
</td></tr></table>
</div>

</form>
<div class="top"><a href="#top">top</a></div>
<?php require "./includes/footer.inc.php" ?>