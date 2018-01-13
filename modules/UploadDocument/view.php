<?php
$operType = isset($_GET['operType'])?$_GET['operType']:"";
    switch($_GET['operType']){  
       case "viewDirectory":
    $jsonData1 = stripslashes(html_entity_decode($_GET["formDataJson"]));
  $dArray = json_decode($jsonData1,true); 
$path = ('../UploadDocument/'.$dArray[prod_cat].'/'.$dArray[prod_sub_cat].'/'.$dArray[spmdname].'/'.$dArray[spname].'/'.$dArray[spprdcolor]);

$obj_rdi = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
foreach ($obj_rdi as $file){
$entry = $file->getfilename();
$directory = $file->getPathname(); 
if ($entry != "." && $entry != ".."){
$file_list[] = $entry;
$path_list[] = $directory;
}
}

$arr = array();
//$arr1 = array();
foreach (array_combine($file_list, $path_list) as $file2 => $path1)
    
      {
        $arr[] =array('name1'=>$file2,'path'=>'modules/UploadDocument/'.$path1);
            }


            /*foreach ($path_list as $key => $path1)
      {
        $arr1[] =array('name1'=>$file2,'path'=>'modules/UploadDocument/'.$path1);
            }*/
    $json=json_encode($arr); 
     header('Content-Type: application/json');  
     echo $json;

break;
};
?>
