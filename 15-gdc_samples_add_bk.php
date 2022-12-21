<?php
// conda activate g3po4
// export GEN3_URL=https://google-gen4.biobank.org.tw/
$string = file_get_contents("tcga_data/biospecimen.json");
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
 if (isset($arr["samples"])){
  foreach ($arr["samples"] as $key1 => $arr1) {
   $i++;
   $data[$key1]["type"]="samples";
   $data[$key1]["cases"]["submitter_id"]=$arr["case_id"];
   // if (!isset($arr1["composition"])){
	   // echo $arr["case_id"]." ";
   // echo $arr1["composition"]." ";
   // echo $arr1["sample_type_id"]." ";
   // echo $arr1["sample_id"]."\n";    
   // }
   // $data[$key1]["composition"]=$arr1["composition"];
   // $data[$key1]["current_weight"]=$arr1["current_weight"];
   // $data[$key1]["days_to_collection"]=$arr1["days_to_collection"];
   // $data[$key1]["days_to_sample_procurement"]=$arr1["days_to_sample_procurement"];
   // $data[$key1]["freezing_method"]=$arr1["freezing_method"];
   // $data[$key1]["initial_weight"]=$arr1["initial_weight"];
   // $data[$key1]["intermediate_dimension"]=$arr1["intermediate_dimension"];
   // $data[$key1]["is_ffpe"]=$arr1["is_ffpe"];
   // $data[$key1]["longest_dimension"]=$arr1["longest_dimension"];
   // $data[$key1]["oct_embedded"]=$arr1["oct_embedded"];
   // $data[$key1]["preservation_method"]=$arr1["preservation_method"];
   // $data[$key1]["sample_type"]=$arr1["sample_type"];
   // $data[$key1]["sample_type_id"]=$arr1["sample_type_id"];
   // $data[$key1]["shortest_dimension"]=$arr1["shortest_dimension"];
   // $data[$key1]["submitter_id"]=$arr1["submitter_id"];
   // $data[$key1]["time_between_clamping_and_freezing"]=$arr1["time_between_clamping_and_freezing"];
   // $data[$key1]["time_between_excision_and_freezing"]=$arr1["time_between_excision_and_freezing"];
   // $data[$key1]["tissue_type"]=$arr1["tissue_type"];
   // $data[$key1]["tumor_code"]=$arr1["tumor_code"];
   // $data[$key1]["tumor_code_id"]=$arr1["tumor_code_id"];
   // $data[$key1]["tumor_descriptor"]=$arr1["tumor_descriptor"];


   //echo $arr1["sample_type_id"]." ".$arr1["sample_id"]."\n";
   $sample=$arr1["sample_id"];
   //echo $arr1["sample_id"]."\n";
   if (isset($arr1["portions"])){
    foreach ($arr1["portions"] as $key2 => $arr2) {
	 if (isset($arr2["slides"])){
	echo $arr1["sample_type_id"]." ".$arr1["sample_id"]."\n";	 
      foreach ($arr2["slides"] as $key3 => $arr3) {
       echo $arr1["sample_type_id"]." ".$arr1["sample_id"]." xxxx ".$key3." -- ".$arr3["submitter_id"]." -- ".$arr3["submitter_id"]."\n";
	  }
	 }
    }
   }
   //print_r($arr1);
   //exit();
   //$data[$key]["age_at_diagnosis"]=$arr["samples"][0]["sample_type_id"];
  }

 }
 // $json = "[".json_encode ( $data[($i-1)] )."]" ; 
 // $prgfile_hx = tempnam("/tmp", "json_"); $fp = fopen($prgfile_hx, "w"); fwrite($fp, $json); fclose($fp);
 // $cmd="php 03-gdc_metadata_add.php $prgfile_hx";
 // echo $cmd."\n";
 // exec($cmd);
 // unlink($prgfile_hx);
 // unset($data);
}
// $json = json_encode ( $data ) ; 
// $prgfile_hx = tempnam("/tmp", "json_"); $fp = fopen($prgfile_hx, "w"); fwrite($fp, $json); fclose($fp);
// $cmd="php 03-gdc_metadata_add.php $prgfile_hx";
// echo $cmd;
// exec($cmd);
// unlink($prgfile_hx);
// $data="";



// 描述
/*
{
  "type": "sample",
  "cases": [
    {
      "submitter_id": "TCGA-CC-A8HU",7
      "id": "TCGA-CC-A8HU"	  
    }
  ],
  "composition": "Unknown",
  "current_weight": "current_weight",
  "days_to_collection": "days_to_collection",
  "days_to_sample_procurement": "days_to_sample_procurement",
  "freezing_method": "freezing_method",
  "initial_weight": "initial_weight",
  "intermediate_dimension": "intermediate_dimension",
  "is_ffpe": "is_ffpe",
  "longest_dimension": "longest_dimension",
  "oct_embedded": "oct_embedded",
  "preservation_method": "Cryopreserved",  
  "sample_type": "Additional Metastatic",
  "sample_type_id": "01",
  "shortest_dimension": "shortest_dimension",
  "submitter_id": "demographic-TCGACCA8HU",
  "time_between_clamping_and_freezing": "time_between_clamping_and_freezing",
  "time_between_excision_and_freezing": "time_between_excision_and_freezing",
  "tissue_type": "Tumor",
  "tumor_code": "Non cancerous tissue",
  "tumor_code_id": "00",
  "tumor_descriptor": "Metastatic"
}




      "sample_type_id": "01",
      "tumor_descriptor": null,
      "sample_id": "4f441e61-6bea-4a12-841d-def270804bbe",
      "sample_type": "Primary Tumor",
      "tumor_code": null,
      "created_datetime": null,
      "time_between_excision_and_freezing": null,
      "composition": null,
      "updated_datetime": "2018-11-15T21:38:54.195821-06:00",
      "days_to_collection": 177,
      "state": "released",
      "initial_weight": 350.0,
      "preservation_method": null,

      "intermediate_dimension": null,
      "time_between_clamping_and_freezing": null,
      "freezing_method": null,
      "pathology_report_uuid": "69AC5937-3FFD-40FB-9922-79DB3CED7510",
      "submitter_id": "TCGA-A7-A0DA-01A",
      "tumor_code_id": null,
      "shortest_dimension": null,
      "oct_embedded": "false",
      "days_to_sample_procurement": null,
      "longest_dimension": null,
      "current_weight": null,
      "is_ffpe": false,
      "tissue_type": "Not Reported"


*/


