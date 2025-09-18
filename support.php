<?php 
$page_title = "Support"; //title of page
$page_name="support"; //name of active menu button
$page_status=0; //who can visit this page; 0 = everyone, 1 = members
require "./includes/header.inc.php";
?>
	<h3>AfSoH Initiative financial and other supports special page</h3>
	 
    <p align="left"><font color="#000000" size="2" face="Tahoma">
  We thank you for visiting this page. All received support, donnation and/or payments are to support AfSoH Initiative on this struggle to avert hypertension on African
  Continent. They are not in line of commercial purposes and they are not used to have any profit whatever.                                                               

 
        <ul>
        <li><font color="#000000" size="2" face="" align="left">Are you a particular customer or a company or organization and you want to advertise with AfSoH Initiative ? Please <a href="ads_fees.php"> browse our advertising conditions </a> and contact us. For paying your ads <a href="paysupport.php">please clicking here</a></font><br/>
        <p align="left">&nbsp;</p>        
        <li><font color="#000000" size="2" face="" align="left">If you want to pay your membership fees or a conference registration fees? Please <a href="membership_fees.php"> browse our membership scales </a> and click on adequate online registration form. For paying your membership <a href="paysupport.php">please clicking here</a></font><br/>
        <p align="left">&nbsp;</p>        
        <li><font color="#000000" size="2" face="" align="left">For financial support, <a href="paysupport.php">use our online payment tools </a></font><br/>
        <p align="left">&nbsp;</p>        
        <li><font color="#000000" size="2" face="" align="left">For any other kind of suuport (material and or nature support), please send email on <strong><a href="mailto:secretary@afsoh.com?subject=Advertising%20request"> secretary@afsoh.com</a> </strong> </font><br/>
        </ul>
        </font></p>
        <p align="left">&nbsp;</p>
     
    	<h3>AfSoH Initiative e-Shop page</h3>
    	
    <p align="left"><font color="#000000" size="2" face="Tahoma"> Students, academicians, researchers and other customers can order/buy online documents published by <strong>AfSoH Initiative- Media Center</strong>, 
    or other available items in <strong>AfSoH Initiative eShop Center</strong>. 
    The payment are made online with our secured online payment tool. <strong>Credit cards (Visa and MasterCard) are accepted through PayPal; and Bank transfers as well</strong>.  <br>  
    Please vist this page regulary to have updates on available documents, papers and other items.
 </font></p> <p align="left">&nbsp;</p>
        <table>
        <tr class="legende">
        <td><font color="White" size="2" face="">Available items</font></td>
        <td><font color="White" size="2" face="">Store limit</font></td>
		<td><font color="White" size="2" face="">Nature</font></td>
        <td><p align="center"><font color="White" size="2" face="">Description</font></p></td>
        <td><p align="center"><font color="White" size="2" face="">Accessibility options</font></p></td>
        </tr>
<?php
require_once ("./admin/classes/download.class.php");
require_once ("./admin/classes/upload.class.php");

$dbfile = "files";
$downloads = Download::getAllDownloads();
foreach($downloads as $item) {
	echo "<tr>\n";
	echo "<td>\n";
    echo "<b>".$item->getTitle()."</b>\n";
	echo "<p>".nl2br($item->getOrganized())."</p>\n";
	echo "</td>\n";
	echo "<td>\n";
	echo $item->getLimit()."\n";
	echo "</td>\n";
	echo "<td>\n";
	echo $item->getNature()."\n";
	echo "</td>\n";
	echo "<td>\n";
    echo "<b>".nl2br($item->getDescription())."</b>\n";
	echo "</td>\n";
	echo "<td>\n";
	if($item->getLimit()=="Stock out")
		echo "Sorry! this item is not available at the moment\n";
	else if($item->getPrice()==0 || $item->getPrice()==0.0 || $item->getPrice()=="") {
		$upload = new Upload("","","");
		$uploaded = $upload->init($item->getDownload_id(),$dbfile);
		echo "<a href=\"".$upload->getFolder().$upload->getFilename()."\" target=\"_blank\">Order your item <br> (Free !)</a>\n";
	}
	else
		echo "<a href=\"paysupport.php?id=".$item->getId()."\">Click here to pay <br> == (".$item->getPrice()." $ US)== <br> and order your item</a>\n";
	echo "</td>\n";
	echo "</tr>\n";
}
?>         
        </table>


    
    <div class="top"><a href="#top">top</a></div>
<?php require "./includes/footer.inc.php" ?>