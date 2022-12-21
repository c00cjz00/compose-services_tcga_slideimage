<?php
# php 22-gen3_get_list_all_project.php TCGA diagnosis
# php 21-gen3_get_list.php TCGA TCGA-BRCA diagnosis
# php 20-gen3_get_program_project.php TCGA
// 輸入
$program=trim($argv[1]);
$node=trim($argv[2]);

$cmd="php 20-gen3_get_program_project.php $program";
$tmp=shell_exec($cmd);
$arr=explode("\n",trim($tmp));
$record="";
foreach ($arr as $key => $value) {
 $project=basename($value);
 //echo $project."\n";
 $cmd="php 21-gen3_get_list.php $program $project $node";
 //echo $cmd."\n";
 $tmp=shell_exec($cmd);
 $arr1=explode("\n",$tmp);
 for($i=1;$i<count($arr1);$i++){
  if (trim($arr1[$i])!="") $record.=trim($arr1[$i])."\n";
 }
}
echo $record;