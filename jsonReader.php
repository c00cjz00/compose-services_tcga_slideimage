<?php
// conda activate g3po4
// export GEN3_URL=https://google-gen4.biobank.org.tw/
$string = file_get_contents("tcga_data/sample.json");
$json_data = json_decode($string, true);
foreach ($json_data as $key => $arr) {
 foreach ($arr as $key1 => $arr1) {
  $submitter_id=$arr1["submitter_id"];
  echo $submitter_id."\n";
 }
}
