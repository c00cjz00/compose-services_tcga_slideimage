<?php
// conda activate g3po4
// export GEN3_URL=https://google-gen4.biobank.org.tw/

$program_id=$argv[1];




$manifest="tcga_data/gdc_manifest.txt";
$arr=file($manifest);
foreach ($arr as $key => $value) {
 //id      filename        md5     size    state	
 $tmpArr=explode("\t",trim($value));
 $did=$tmpArr[0]; 
 if (strlen($did)>10){ 
  $file_name=$tmpArr[1]; 
  $md5=$tmpArr[2]; 
  $tmp="did_".$file_name; $$tmp=$did;
  $tmp="md5_".$file_name; $$tmp=$md5;
 }
}


$string = file_get_contents("tcga_data/files.json");
$json_data = json_decode($string, true);
// 變魔法！
#$iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($json_data));
// 當成一維陣列迭代！
#foreach ($iterator as $element) {
#    echo "$element" . PHP_EOL;
#}

//print_r($json_data);

$data_type=array('image', 'Single Cell Image', 'Raw IMC Data', 'Single Channel IMC Image', 'Antibody Panel Added');
foreach ($json_data as $key => $arr) {
  $tmpArr=explode('.',basename($arr["file_name"],".svs"));
  if (isset($tmpArr[1])) {
   $data["slides"]["id"]=$tmpArr[1];
   $data["type"]="slide_image";
   $data["data_category"]=$arr["data_category"];
   $data["data_format"]=$arr["data_format"];
   $project_id=$arr["cases"][0]["project"]["project_id"];

   if ($arr["data_type"]=="Slide Image") $arr["data_type"]="image";
   $data["data_type"]=$arr["data_type"];
   $data["experimental_strategy"]=$arr["experimental_strategy"];
   $data["file_name"]=$arr["file_name"];
   $data["file_size"]=$arr["file_size"];
   $tmp="md5_".$arr["file_name"]; $data["md5sum"]=$$tmp;
   //$data["id"]=$arr["file_id"];
   $data["object_id"]=$arr["file_id"];
   $data["submitter_id"]=$tmpArr[0];
   $json = "[".json_encode ( $data )."]" ; 
   //echo $json."\n";
   //$prgfile_hx = tempnam("/tmp", "json_"); $fp = fopen($prgfile_hx, "w"); fwrite($fp, $json); fclose($fp);
   //$cmd="php 03-gdc_metadata_add.php $program_id $project_id $prgfile_hx";
   //echo $cmd."\n";
   //echo shell_exec($cmd);
   //unlink($prgfile_hx);
   unset($data);
   #exit();
  }

}

/*
{
  "type": "slide_image",
  "data_category": "Slide Image",
  "data_format": "SVS",
  "data_type": "image",
  "experimental_strategy": "Diagnostic Slide",
  "file_name": "TCGA-DD-A73C-01Z-00-DX2.616264EE-93CE-4E2F-A4DA-1CD3663A4F3C.svs",
  "file_size": "5263530",
  "md5sum": "9ea47c62840313a1514bc80b6b968582",
  "object_id": "36de08bc-e888-4c76-a159-ac3a440d7c5f",
  "submitter_id": "core_metadata_collection_60acece55c",
  "slides": [
    {
      "id": "47980d31-833d-45a4-9d01-a0ddf3ca84a1"
    }
  ]
}


*/


