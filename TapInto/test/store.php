<?php

function store($url, $textbox){

$db_host="localhost";
$db_username="matth114_user";
$db_pass="imsofly1";
$db_name="matth114_subscribe";

$con = mysql_connect("$db_host","$db_username","$db_pass");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
 
mysql_select_db("$db_name") or die ("No database exists");

$sql="INSERT INTO data (image_url, textbox)
VALUES
('$url', '$textbox')";
 
if (!mysql_query($sql,$con))
  {
  die('Error: ' . mysql_error());
  }

mysql_close($con);

}

?>