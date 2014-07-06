<?php

$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);

  //Retrieve the number to append to the image name, this will create a standard for images uploaded.
 if (file_exists('counter.txt'))
 {
   //set point to read from file.
   $fpointer = fopen('counter.txt', r);

   //create variable to store the current count. Increment by 1.
   $count = fread($fpointer, filesize('counter.txt'));
   echo $count+1;
   
   fclose($fpointer);
   $fpointer = fopen('counter.txt',w);
   fwrite($fpointer, $count+1);
 }
 else{
   $fpointer = fopen('counter.txt',w);
   $count = 1;
   fwrite($fpointer, $count+1);
   echo $count;
   fclose($fpointer);
 }

 function findexts ($filename) 
 { 
 //filename is the name of the uploaded file.
 $filename = strtolower($filename) ; 
 //exts = extension with the dot, filename = name before the dot
 $exts = split("[/\\.]", $filename) ; 
 //remove the dot from the extension
 $n = count($exts)-1; 
 $exts = $exts[$n]; 
 return $exts; 
 } 
 
 //This applies the function to our file  
 $ext = findexts ($_FILES['file']['name']) ; 

 //This line assigns a random number to a variable. You could also use a timestamp here if you prefer. 
 $name = "image".$count;

 //This takes the random number (or timestamp) you generated and adds a . on the end, so it is ready of the file extension to be appended.
 $namedot = $name.".";

 //This assigns the subdirectory you want to save into!
 $target = "upload/";

 //This combines the directory, the random file name, and the extension
 $target = $target . $namedot.$ext; 

if ((($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/png"))
&& in_array($extension, $allowedExts))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    }
  else
    {
    echo "Upload: " . $_FILES["file"]["name"] . "<br>";
    echo "Type: " . $_FILES["file"]["type"] . "<br>";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

    if (file_exists("upload/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"], $target);
      //echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
      echo "Upload Directory: "."http://matthewmarji.com/TapInto/test/".$target . "<br>";
      
      //Now, we want to store the http url, and textbox data in our database for storage. We will leave that to store.php to do.
      include 'store.php';
      $url = "http://www.matthewmarji.com/TapInto/test/".$target;
      $textbox = $_POST["text"];
      echo store($url, $textbox);
      }
    }
  }
else
  {
  echo "Invalid file";
  }
?>