<?php
// conda activate g3po4
// export GEN3_URL=https://google-gen4.biobank.org.tw/
// php 11-gdc_experiment_add.php TCGA
$program_id=$argv[1];

$string = file_get_contents("tcga_data/projects.json");
$json_data = json_decode($string, true);
// 變魔法！
#$iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($json_data));
// 當成一維陣列迭代！
#foreach ($iterator as $element) {
#    echo "$element" . PHP_EOL;
#}

//print_r($json_data);
foreach ($json_data as $key => $arr) {
 $case_count=$arr["summary"]["case_count"];
 $primary_site=$arr["primary_site"][0];
 $project_id=$arr["project_id"];
 $disease_type=implode("; ",$arr["disease_type"]);

 $data["type"]="experiment";
 $data["data_description"]=$primary_site;
 $data["experimental_description"]=$disease_type;
 $data["number_samples_per_experimental_group"]=$case_count;
 $data["projects"]["code"]=$project_id;
 $data["submitter_id"]="experimental_".$project_id;

 $json = json_encode ( $data ) ; 
 //echo $json."\n";
 $prgfile_hx = tempnam("/tmp", "json_"); $fp = fopen($prgfile_hx, "w"); fwrite($fp, $json); fclose($fp);
 $cmd="php 03-gdc_metadata_add.php $program_id $project_id $prgfile_hx";
 echo $cmd;
 exec($cmd);
 //unlink($prgfile_hx);
 //exit();
 unset($data);

}
/*{
  "type": "experiment",
  "data_description": "Thyroid gland",
  "experimental_description": "Epithelial Neoplasms, NOS; Adenomas and Adenocarcinomas",
  "number_samples_per_experimental_group": "507",
  "projects": [
    {
      "code": "jenkins"
    }
  ],
  "submitter_id": "TCGA-THCA"
}*/


 // [32] => Array
        // (
            // [summary] => Array
                // (
                    // [case_count] => 507
                // )

            // [primary_site] => Array
                // (
                    // [0] => Thyroid gland
                // )

            // [project_id] => TCGA-THCA
            // [disease_type] => Array
                // (
                    // [0] => Epithelial Neoplasms, NOS
                    // [1] => Adenomas and Adenocarcinomas
                // )

            // [program] => Array
                // (
                    // [name] => TCGA
                // )

        // )

