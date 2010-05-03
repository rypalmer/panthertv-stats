<?php
// include the database configuration and
// open connection to database


include ("connect.php");


// check if the form is submitted
if(isset($_POST['btnSign']))
{
    // get the input from $_POST variable
    // trim all input to remove extra spaces
    $title    = trim($_POST['txtTitle']);
    $name    = trim($_POST['txtName']);
    $email   = trim($_POST['txtEmail']);
    $url     = trim($_POST['txtUrl']);
    $message = trim($_POST['mtxMessage']);
    
    // escape the message ( if it's not already escaped )
    if(!get_magic_quotes_gpc())
    {
        $title    = addslashes($title);
        $name    = addslashes($name);
        $message = addslashes($message);
    }
    
    // if the visitor do not enter the url
    // set $url to an empty string
    if ($url == 'http://')
    {
        $url = '';
    }
    
    // prepare the query string
    $query = "INSERT INTO slides (img_name, img_contact, img_contact_email, img_href, img_log, img_entry_date) " .
             "VALUES ('$title', '$name', '$email', '$url', '$message', current_date)";

    // execute the query to insert the input to database
    // if query fail the script will terminate         
    mysql_query($query) or die('Error, query failed. ' . mysql_error());
    
    // redirect to current page so if we click the refresh button 
    // the form won't be resubmitted ( as that would make duplicate entries )
    header('Location: ' . $_SERVER['REQUEST_URI']);
    
    // force to quite the script. if we don't call exit the script may
    // continue before the page is redirected
    exit;
}
?>
<html>
<head>
<title>Campus Screens - Insert Image</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<style type="text/css">

.table		{
		background-color:#AC9B7D; 
		border: 1;
		width: 800px;
		}
.small		{
		font: 0.7em "MS Verdana" sans-serif;
		font-color: white;
		text-decoration: none;
		}
p		{
		font: 0.9em "MS Verdana" sans-serif;
		font-color: white;
		text-decoration: none;		
		}

.lcol		{
		position: relative;
		left: 0px;
		width: 600px;
		}

.rcol		{
		position: relative;
		left: 150px;
		right: 100px;
		}
.fcol		{

		float: right;
		width: 20%;
		}

</style>

<script language="JavaScript">
/*
    This function is called when
    the 'Sign Guestbook' button is pressed
    Output : true if all input are correct, false otherwise
*/
function checkForm()
{
    // the variables below are assigned to each
    // form input 
    var gname, gemail, gurl, gmessage;
    with(window.document.guestform)
    {
        gtitle    = txtTitle;
        gname    = txtName;
        gemail   = txtEmail;
        gurl     = txtUrl;
        gmessage = mtxMessage;
    }
    // if name is empty alert the visitor
    if(trim(gtitle.value) == '')
    {
        alert('Please enter an image');
        gtitle.focus();
        return false;
    }
    
    // if name is empty alert the visitor
    if(trim(gname.value) == '')
    {
        alert('Please enter a contact name');
        gname.focus();
        return false;
    }
   // if url has only the http alert the visitor
    else if(trim(gurl.value) == 'http://')
    {
        alert('Please enter a valid email address or leave it blank');
        gemail.focus();
        return false;
    }
    // alert the visitor if email is empty or the format is not correct 
    else if(trim(gemail.value) != '' && !isEmail(trim(gemail.value)))
    {
        alert('Please enter a valid contact email address or leave it blank');
        gemail.focus();
        return false;
    }
    else
    {
        // when all input are correct 
        // return true so the form will submit        
        return true;
    }
}

/*
Strip whitespace from the beginning and end of a string
Input  : a string
Output : the trimmed string
*/
function trim(str)
{
    return str.replace(/^\s+|\s+$/g,'');
}

/*
Check if a string is in valid email format. 
Input  : the string to check
Output : true if the string is a valid email address, false otherwise.
*/
function isEmail(str)
{
    var regex = 

/^[-_.a-z0-9]+@(([-a-z0-9]+\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|

bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj

|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|

gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|

li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne

|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc

|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um

|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]

)\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i;
    return regex.test(str);
}
</script>
</head>
<body>

<img src="top.png" width="600" height="150" alt="top"/>

<h2>Instert a Slide into active rotation</h2>


<form method="post" name="guestform">
 <table width="100%" border="0" cellpadding="2" cellspacing="1">
  <tr> 
   <td width="100">Image Title *</td> <td> 
    <input name="txtTitle" type="text" id="txtTitle" size="30" maxlength="50"></td>
<td rowspan="6"><h3>* denotes a required field</h3></td>
 </tr>

  <tr> 
   <td width="100">Contact Name *</td> <td> 
    <input name="txtName" type="text" id="txtName" size="30" maxlength="50"></td>
 </tr>
  <tr> 
   <td width="100">Contact Email *</td>
   <td> 
    <input name="txtEmail" type="text" id="txtEmail" size="30" maxlength="100"></td>
 </tr>
  <tr> 
   <td width="100">Image URL *</td>
   <td> 
    <input name="txtUrl" type="text" id="txtUrl" value="http://" size="30" maxlength="250"></td>
 </tr>
  <tr> 
   <td width="100">Image Log Message *</td> <td> 
    <textarea name="mtxMessage" cols="40" rows="5" id="mtxMessage"></textarea></td>
 </tr>
  <tr> 
   <td width="100">&nbsp;</td>
   <td> 
    <input name="btnSign" type="submit" id="btnSign" value="Insert Image" onClick="return checkForm();"></td>
 </tr>
</table>
</form>
<h3>Please double-check the image location is correct before submitting a slide.</h3>
<h3>For support, check the <a href="http://beat2.upei.ca/beatwiki/index.php/Campus_Screens">Campus Screens</a> beatWiki article.</h3>

<hr />

<h2>Slides in Campus Screens Database</h2>

<?php


// ================================
// Show campus screen slide entries
// ================================

// how many guestbook entries to show per page
$rowsPerPage = 10;

// by default we show first page
$pageNum = 1;

// if $_GET['page'] defined, use the value as page number
if(isset($_GET['page']))
{
    $pageNum = $_GET['page'];
}

// counting the offset ( where to start fetching the entries )
$offset = ($pageNum - 1) * $rowsPerPage;

// prepare the query string
$query = "SELECT img_id, img_contact, img_contact_email, img_href, img_log, img_status, DATE_FORMAT(img_entry_date, '%d.%m.%Y') ".
         "FROM slides ".
	 // "WHERE img_status='1'".
         "ORDER BY img_id DESC ".        // using ORDER BY to show the most current entry first
         "LIMIT $offset, $rowsPerPage";  // LIMIT is the core of paging

// execute the query 
$result = mysql_query($query) or die('Error, query failed. ' . mysql_error());

// if the guestbook is empty show a message
if(mysql_num_rows($result) == 0)
{
?>
<p><br>
 <br>Campus Screens Database is empty! </p>
<?php
}
else
{
    // get all guestbook entries
    while($row = mysql_fetch_array($result))
    {
        // list() is a convenient way of assign a list of variables
        // from an array values 
        list($img_id, $img_contact, $img_contact_email, $img_href, $img_log, $img_status, $img_entry_date) = $row;

        // change all HTML special characters,
        // to prevent some nasty code injection
        $img_contact    = htmlspecialchars($img_contact);
        $img_log = htmlspecialchars($img_log);        

        // convert newline characters ( \n OR \r OR both ) to HTML break tag ( <br> )
        $img_log = nl2br($img_log);
?>

<table rules="none" frame="box" class="table">
 <tr> 
  <td colspan="2" width="80" align="left"><p class="small">Contact:</p></td>
  <td><a href="mailto:<?=$img_contact_email;?>" class="email"> 
   <p><?=$img_contact;?></p>
   </a> </td>
  <td align="right"> 
  <p class="small">Submitted:  <?=$img_entry_date;?></p>
  </td>
 </tr>
 <tr> 
  <td> 
   <p class="small">Log:</font> </td>
  <td colspan="3"> <p><?=$img_log;?>&nbsp;</p></td>
 </tr>
 <tr>
  <td align="middle, left">
   <p class="small">Preview: </p></td>
  <td colspan="2" width="570">
   <center><img src="<?=$img_href;?>" width="200" align="middle"/></center></td><td width="150">
   <?php

           // show a status graphic
	if($img_status == '1')
	{
	   ?><center><img src="active.png" align="middle" width="100" height="100" alt="active"/></center></td>
	<?php
	}
	else {
	   ?><center><img src="inactive.png" align="middle" width="100" height="100" alt="inactive"/></center></td>
	<?php
	}


           // if the visitor input her homepage url show it
        if($img_href != '')
        {   
            // make the url clickable by formatting it as HTML link
            $img_href = "<a href='$img_href' target='_blank'>$img_href</a>";





?>
   </td>
 </tr>
 <tr>
  <td colspan="2"> 
   <p class="small">Image location:</p></td><td colspan="2"> <p><?=$img_href;?></p> 
   <?php
        }
?>
  </td>
 </tr>
</table>
<br>
<?php
    } // end while

// below is the code needed to show page numbers

// count how many rows we have in database
$query   = "SELECT COUNT(img_id) AS numrows FROM slides ";
$result  = mysql_query($query) or die('Error, query failed. ' . mysql_error());
$row     = mysql_fetch_array($result, MYSQL_ASSOC);
$numrows = $row['numrows'];

// how many pages we have when using paging?
$maxPage  = ceil($numrows/$rowsPerPage);
$nextLink = '';

// show the link to more pages ONLY IF there are 
// more than one page
if($maxPage > 1)
{
    // this page's path
    $self     = $_SERVER['PHP_SELF'];
    
    // we save each link in this array
    $nextLink = array();
    
    // create the link to browse from page 1 to page $maxPage
    for($page = 1; $page <= $maxPage; $page++)
    {
        $nextLink[] =  "<a href=?page=$page>$page</a>";
    }
    
    // join all the link using implode() 
    $nextLink = "Go to page : " . implode(' &raquo; ', $nextLink);
}

// close the database connection since
// we no longer need it

mysql_close();

?>
<table width="550" border="0" cellpadding="2" cellspacing="0">
 <tr> 
  <td align="right" class="text"> 
   <?=$nextLink;?>
  </td>
 </tr>
</table>
<?php
}
?>
</body>
</html>