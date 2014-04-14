<?php
date_default_timezone_set('America/Los_Angeles');
$uploaddir = 'uploads/'; 
$allowedExts = array("gif", "jpeg", "jpg", "png");
$ext = pathinfo($_FILES['uploadfile']['name'], PATHINFO_EXTENSION);
$response=array();
    if(!empty($_FILES['uploadfile']['name'])){
        if(in_array($ext, $allowedExts)){
            if($_FILES["file"]["size"] < 2048){
                if(!empty($_FILES['uploadfile']['name']))$filename=getImagename($ext);
                $file = $uploaddir.$filename; 
                if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) { 
                        $response['status']='Succcess';
                        $response['msg']="Error in uploading file";
                        $response['file']=$filename;
                }
                else {
                        $response['status']='Error';
                        $response['msg']="Error in uploading file";
                }
            }
            else{ 
                 $response['status']='Error';
                 $response['msg']="File size Exceeded";
                }
        }
        else{
             $response['status']='Error';
             $response['msg']=".$ext File type not allowed";
            } 
           
    }
 else{
     $response['status']='Error';
     $response['msg']='upload Proper file';
   }
   echo  json_encode($response);
   exit();
 
function getImagename($ext){
        $today = getdate();
        $uniqueStr = $today[year];
        $uniqueStr .= $today[mon];
        $uniqueStr .= $today[wday];
        $uniqueStr .= $today[mday];
        $uniqueStr .= $today[hours];
        $uniqueStr .= $today[minutes];
        $uniqueStr .= $today[seconds];
        $uniqueStr .= rand(1,9);
      return $uniqueStr.".".$ext;
}
?>