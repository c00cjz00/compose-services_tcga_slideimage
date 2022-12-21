<?php
// conda activate g3po4
// export GEN3_URL=https://google-gen4.biobank.org.tw/
// php 14-gdc_sample_add.php TCGA
$program_id=$argv[1];
//check exist
$cmd="php 22-gen3_get_list_all_project.php $program_id sample";
$tmp=shell_exec($cmd);
$arr=explode("\n",trim($tmp));
$record="";
foreach ($arr as $key => $value) {
 $tmp="check_".trim($value); $$tmp=1;
}
// case > project
$string = file_get_contents("tcga_data/cases.json");
$json_data = json_decode($string, true);
foreach ($json_data as $key => $arr) {
 $project_id_tmp=$arr["project"]["project_id"];
 $case_id=$arr["case_id"];
 $$case_id=$project_id_tmp;
}



$string = file_get_contents("tcga_data/biospecimen.json");
$json_data = json_decode($string, true);
// 變魔法！
#$iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($json_data));
// 當成一維陣列迭代！
#foreach ($iterator as $element) {
#    echo "$element" . PHP_EOL;
#}

//print_r($json_data);

foreach ($json_data as $key => $arr) {
 if (isset($arr["samples"])){
  foreach ($arr["samples"] as $key1 => $arr1) {
   $sample_id=$arr1["sample_id"]; 	  
   if (isset($arr1["portions"])){
    foreach ($arr1["portions"] as $key2 => $arr2) {
	 if (isset($arr2["slides"]) && !isset($$sample_id)){
	   
	   $$sample_id=1;	 
	   if (!isset($arr1["composition"])) $arr1["composition"]=null; 
	   if (!isset($arr1["current_weight"])) $arr1["current_weight"]=null; 
	   if (!isset($arr1["days_to_collection"])) $arr1["days_to_collection"]=null; 
	   if (!isset($arr1["days_to_sample_procurement"])) $arr1["days_to_sample_procurement"]=null; 
	   if (!isset($arr1["freezing_method"])) $arr1["freezing_method"]=null;
	   if (!isset($arr1["initial_weight"])) $arr1["initial_weight"]=null; 
	   if (!isset($arr1["intermediate_dimension"])) {$arr1["intermediate_dimension"]=null;}else{$arr1["intermediate_dimension"]=strval($arr1["intermediate_dimension"]);}
	   if (!isset($arr1["is_ffpe"])) $arr1["is_ffpe"]=null; 
	   if (!isset($arr1["longest_dimension"])) {$arr1["longest_dimension"]=null;}else{$arr1["longest_dimension"]=strval($arr1["longest_dimension"]);}
	   if (!isset($arr1["oct_embedded"])) $arr1["oct_embedded"]=null; 
	   if (!isset($arr1["preservation_method"])) $arr1["preservation_method"]=null; 
	   if (!isset($arr1["shortest_dimension"])) {$arr1["shortest_dimension"]=null;}else{$arr1["shortest_dimension"]=strval($arr1["shortest_dimension"]);}
	   if (!isset($arr1["time_between_clamping_and_freezing"])) $arr1["time_between_clamping_and_freezing"]=null; 
	   if (!isset($arr1["time_between_excision_and_freezing"])) $arr1["time_between_excision_and_freezing"]=null; 
	   if (!isset($arr1["tissue_type"])) $arr1["tissue_type"]=null; 
	   if (!isset($arr1["tumor_code"])) $arr1["tumor_code"]=null; 
	   if (!isset($arr1["tumor_code_id"])) $arr1["tumor_code_id"]=null; 
	   if (!isset($arr1["tumor_descriptor"])) $arr1["tumor_descriptor"]=null; 
       $data["type"]="sample";
	   $case=$arr["case_id"];
	   $data["cases"]["id"]=$case;
	   $project_id=$$case;  	   
	   $data["composition"]=$arr1["composition"];
	   $data["current_weight"]=$arr1["current_weight"];
	   $data["days_to_collection"]=$arr1["days_to_collection"];
	   $data["days_to_sample_procurement"]=$arr1["days_to_sample_procurement"];
	   $data["freezing_method"]=$arr1["freezing_method"];
	   $data["initial_weight"]=$arr1["initial_weight"];
	   $data["intermediate_dimension"]=$arr1["intermediate_dimension"];
	   $data["is_ffpe"]=$arr1["is_ffpe"];
	   $data["longest_dimension"]=$arr1["longest_dimension"];
	   $data["oct_embedded"]=$arr1["oct_embedded"];
	   $data["preservation_method"]=$arr1["preservation_method"];
	   $data["sample_type"]=$arr1["sample_type"];
	   $id_check="check_".$arr1["sample_id"];
	   $data["id"]=$arr1["sample_id"];
	   $data["sample_type_id"]=$arr1["sample_type_id"];
	   $data["shortest_dimension"]=$arr1["shortest_dimension"];
	   $data["submitter_id"]=$arr1["submitter_id"];
	   $data["time_between_clamping_and_freezing"]=$arr1["time_between_clamping_and_freezing"];
	   $data["time_between_excision_and_freezing"]=$arr1["time_between_excision_and_freezing"];
	   $data["tissue_type"]=$arr1["tissue_type"];
	   $data["tumor_code"]=$arr1["tumor_code"];
	   $data["tumor_code_id"]=$arr1["tumor_code_id"];
	   $data["tumor_descriptor"]=$arr1["tumor_descriptor"];
	   if (!isset($$id_check)) {
	    $json = "[".json_encode (  $data )."]" ; 
	    //echo $json."\n";
	    $prgfile_hx = tempnam("/tmp", "json_"); $fp = fopen($prgfile_hx, "w"); fwrite($fp, $json); fclose($fp);
	    $cmd="php 03-gdc_metadata_add.php $program_id $project_id $prgfile_hx";
	    echo $cmd."\n";
	    //exec($cmd);
	    //unlink($prgfile_hx);
	   } 

	   unset($data);
       	   
	 }
    }
   }
  }
 }

}



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


