<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Imageboard Test</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
</head>

<body>
<?php
//Filetypes that are allowed to be saved
$allow_types=array(jpeg,gif);
//Function to find the extension of a file
function findexts ($filename)
{
$filename = strtolower($filename) ;
$exts = split("[/\\.]", $filename) ;
$n = count($exts)-1;
$exts = $exts[$n];
return $exts;
}
//Temporary workaround for PHP throwing an error if an array contains more than one fowardslash
//This is not ideal as this should be handled by PHP
switch ($_FILES["file"]["type"]){
	case "image/jpeg":
	$filetype = jpeg;
	break;
	case "image/gif":
	$filetype = gif;
	break;
	}
//Check for upload errors
if ($_FILES["file"]["error"] > 0)
  {
  echo "Error: " . $_FILES["file"]["error"] . "<br />";
  }
else
  {
//Check filetypes
  if (in_array($filetype, $allow_types)){
//If filetype is allowed then display DEBUG file info
  echo "Upload: " . $_FILES["file"]["name"] . "<br />";
  echo "Type: " . $_FILES["file"]["type"] . "<br />";
  echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
  echo "Temp: " . $_FILES["file"]["tmp_name"] . "<br />";
  if (file_exists("uploads/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      //Sets variable $rename to random number with the same file extension as uploaded file
      $rename= time()+rand() . "." . findexts($_FILES["file"]["name"]);
      move_uploaded_file($_FILES["file"]["tmp_name"], "uploads/" . $rename);
      echo "Stored in: " . "uploads/" . $rename;
      $uploaded="1";
      }
  }
  else
  {
//If invalid filetypes then display what filetypes are allowed
	echo "Allowed filetypes are:";
	foreach($allow_types as $value){echo " ".$value;}
	$uploaded="0";
  }
}
?>
<div id="page">
	<div id="form" align="center">
	<form action="" method="post" enctype="multipart/form-data">
		<label for="name">Name:</label>
		<input type="inputtext" name="name" id="name" />
		<br />
		<label for="email">E-mail:</label>
		<input type="inputtext" name="email" id="email" /> 
		<br />
		<label for="subject">Subject:</label>
		<input type="inputtext" name="subject" id="subject" /> 
		<input type="submit" name="submit" value="Submit" />
		<br />
		<label for="comment">Comment:</label>
		<input type="inputtext" name="comment" id="comment" /> 
		<br />
		<label for="file">File:</label>
		<input type="file" name="file" id="file" />
		<br />
		<label for="password">Password:</label>
		<input type="inputtext" name="password" id="password" /> 
		<br />
	</form>
	</div>
	<div id="image">
		<?php if($uploaded=1){echo "<img src=uploads/".$rename.">";} ?>
	</div>
</div>
</body>
</html>

