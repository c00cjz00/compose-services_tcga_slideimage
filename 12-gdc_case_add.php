<?php
// conda activate g3po4
// export GEN3_URL=https://google-gen4.biobank.org.tw/
//  php 12-gdc_case_add.php TCGA
$program_id=$argv[1];

//check exist
$cmd="php 22-gen3_get_list_all_project.php $program_id case";
$tmp=shell_exec($cmd);
$arr=explode("\n",trim($tmp));
$record="";
foreach ($arr as $key => $value) {
 $tmp=trim($value); $$tmp=1;
}

$string = file_get_contents("tcga_data/cases.json");
$json_data = json_decode($string, true);
// 變魔法！
#$iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($json_data));
// 當成一維陣列迭代！
#foreach ($iterator as $element) {
#    echo "$element" . PHP_EOL;
#}

//print_r($json_data);
$i=0;
foreach ($json_data as $key => $arr) {
 $i++;	
 if (is_array($arr["disease_type"])){
  $disease_type=implode("; ",$arr["disease_type"]);
 }else{
  $disease_type=$arr["disease_type"];	 
 }
 $primary_site=$arr["primary_site"];
 $project_id=$arr["project"]["project_id"];
 $case_id=$arr["case_id"];
 $submitter_id=$arr["submitter_id"];


 $data["type"]="case";
 $data["disease_type"]=$disease_type;
 $data["primary_site"]=$primary_site;
 $data["experiments"]["submitter_id"]="experimental_".$project_id;
 $data["id"]=$case_id;
 $data["submitter_id"]=$submitter_id;
 if (!isset($$case_id)){
  $json = "[".json_encode ( $data )."]" ; 
  //echo $json."\n";
  $prgfile_hx = tempnam("/tmp", "json_"); $fp = fopen($prgfile_hx, "w"); fwrite($fp, $json); fclose($fp);
  $cmd="php 03-gdc_metadata_add.php $program_id $project_id $prgfile_hx";
  echo $cmd."\n";
  //exec($cmd);
  //unlink($prgfile_hx);
  //exit();
 }
 unset($data);
}
// $json = json_encode ( $data ) ; 
// $prgfile_hx = tempnam("/tmp", "json_"); $fp = fopen($prgfile_hx, "w"); fwrite($fp, $json); fclose($fp);
// $cmd="php 03-gdc_metadata_add.php $prgfile_hx";
// echo $cmd;
// exec($cmd);
// unlink($prgfile_hx);
// $data="";

/*{
{
  "type": "case",
  "disease_type": "Adenomas and Adenocarcinomas",
  "primary_site": "Breast",
  "experiments": [
    {
      "submitter_id": "TCGA-BRCA"
    }
  ],
  "submitter_id": "3afa1e93-1df8-4e4c-aaa4-557463f4bb77"
}*/


  // "primary_site": "Breast",
  // "disease_type": "Ductal and Lobular Neoplasms",
  // "case_id": "3afa1e93-1df8-4e4c-aaa4-557463f4bb77",
  // "project": {
    // "project_id": "TCGA-BRCA",
    // "program": {
      // "name": "TCGA"
    // }
  // },


