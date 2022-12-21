<?php
// conda activate g3po4
// export GEN3_URL=https://google-gen4.biobank.org.tw/
// php 09-gdc_program_add.php TCGA tcga_version1.0

$name=$argv[1];
$dbgap_accession_number=$argv[2];

$data["type"]="program";
$data["name"]=$name;
$data["dbgap_accession_number"]=$dbgap_accession_number;


$json = json_encode ( $data ) ; 
//echo $json."\n";
$prgfile_hx = tempnam("/tmp", "json_"); $fp = fopen($prgfile_hx, "w"); fwrite($fp, $json); fclose($fp);
$cmd="php 05-gdc_program_add.php $prgfile_hx";
echo $cmd;
exec($cmd);
unlink($prgfile_hx);
