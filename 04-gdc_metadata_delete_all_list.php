<?php
// 輸入
$file=trim($argv[1]);
$cmd="awk -F \"\t\" '{print $2}' $file";
$result=trim(shell_exec($cmd));
$arr=explode("\n",$result);

for($i=0;$i<count($arr);$i++){
 $guid=trim($arr[$i]);
 if ($guid!=""){
  //echo $guid."\n";
  $cmd="php 04-gdc_metadata_delete.php ".$guid;  
  echo $cmd."\n";
 }
}
