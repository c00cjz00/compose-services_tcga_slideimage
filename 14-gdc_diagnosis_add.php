<?php
// conda activate g3po4
// export GEN3_URL=https://google-gen4.biobank.org.tw/
// php 14-gdc_diagnosis_add.php TCGA

$program_id=$argv[1];
//check exist
$cmd="php 22-gen3_get_list_all_project.php $program_id diagnosis";
$tmp=shell_exec($cmd);
$arr=explode("\n",trim($tmp));
$record="";
foreach ($arr as $key => $value) {
 $tmp=trim($value); $$tmp=1;
}

// case > project
$string = file_get_contents("tcga_data/cases.json");
$json_data = json_decode($string, true);
foreach ($json_data as $key => $arr) {
 $project_id_tmp=$arr["project"]["project_id"];
 $case_id=$arr["case_id"];
 $$case_id=$project_id_tmp;
}



$string = file_get_contents("tcga_data/clinical.json");
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
 if (isset($arr["diagnoses"])){
  if (!isset($arr["diagnoses"][0]["ajcc_pathologic_stage"])) $arr["diagnoses"][0]["ajcc_pathologic_stage"]="not reported";
  $data["type"]="diagnosis";
  $case=$arr["case_id"];
  $data["cases"]["id"]=$case;
  $project_id=$$case;  
  $data["age_at_diagnosis"]=$arr["diagnoses"][0]["age_at_diagnosis"];
  $data["classification_of_tumor"]=$arr["diagnoses"][0]["classification_of_tumor"];
  $data["days_to_last_follow_up"]=$arr["diagnoses"][0]["days_to_last_follow_up"];
  $data["days_to_last_known_disease_status"]=$arr["diagnoses"][0]["days_to_last_known_disease_status"];
  $data["days_to_recurrence"]=$arr["diagnoses"][0]["days_to_recurrence"];
  $data["last_known_disease_status"]=$arr["diagnoses"][0]["last_known_disease_status"];
  $data["morphology"]=$arr["diagnoses"][0]["morphology"];
  $data["primary_diagnosis"]=$arr["diagnoses"][0]["primary_diagnosis"];
  $data["progression_or_recurrence"]=$arr["diagnoses"][0]["progression_or_recurrence"];
  $data["site_of_resection_or_biopsy"]=$arr["diagnoses"][0]["site_of_resection_or_biopsy"];
  $data["submitter_id"]=$arr["diagnoses"][0]["submitter_id"];
  $id=$arr["diagnoses"][0]["diagnosis_id"];
  $data["id"]=$arr["diagnoses"][0]["diagnosis_id"];
  $data["tissue_or_organ_of_origin"]=$arr["diagnoses"][0]["tissue_or_organ_of_origin"];
  $data["tumor_grade"]=$arr["diagnoses"][0]["tumor_grade"];
  $data["tumor_stage"]=$arr["diagnoses"][0]["ajcc_pathologic_stage"];
  $data["vital_status"]=strtolower($arr["demographic"]["vital_status"]);
  
  if (!isset($$id)){   
   $json = "[".json_encode ( $data )."]" ; 
   //echo $json."\n";
   $prgfile_hx = tempnam("/tmp", "json_"); $fp = fopen($prgfile_hx, "w"); fwrite($fp, $json); fclose($fp);
   $cmd="php 03-gdc_metadata_add.php $program_id $project_id $prgfile_hx";
   echo $cmd."\n";
   //echo shell_exec($cmd);
   //unlink($prgfile_hx);
  }
  unset($data);
  //exit();
 }
}
// $json = json_encode ( $data ) ; 
// $prgfile_hx = tempnam("/tmp", "json_"); $fp = fopen($prgfile_hx, "w"); fwrite($fp, $json); fclose($fp);
// $cmd="php 03-gdc_metadata_add.php $prgfile_hx";
// echo $cmd;
// exec($cmd);
// unlink($prgfile_hx);
// $data="";

/*
{
  "type": "diagnosis",
  "age_at_diagnosis": 0,
  "cases": [
    {
      "submitter_id": "TCGA-CC-A8HU"
    }
  ],
  "classification_of_tumor": "primary",
  "days_to_last_follow_up": 1,
  "days_to_last_known_disease_status": 1,
  "days_to_recurrence": 1,
  "last_known_disease_status": "Distant met recurrence/progression",
  "morphology": "1",
  "primary_diagnosis": "Hepatocellular carcinoma, NOS",
  "progression_or_recurrence": "yes",
  "site_of_resection_or_biopsy": "1",
  "submitter_id": "slide_image_b8ed4bbadb",
  "tissue_or_organ_of_origin": "1",
  "tumor_grade": "1",
  "tumor_stage": "1",
  "vital_status": "alive"
}



*/


