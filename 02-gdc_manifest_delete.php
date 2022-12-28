<?php
// conda activate g3po4
// export GEN3_URL=https://google-gen4.biobank.org.tw/
$manifest="tcga_data/gdc_manifest.txt";
$arr=file($manifest);
foreach ($arr as $key => $value) {
 //id      filename        md5     size    state	
 $tmpArr=explode("\t",trim($value));
 $did=$tmpArr[0]; 
 if (strlen($did)>10){
  $file_name=$tmpArr[1]; 
  $md5=$tmpArr[2]; 
  $size=$tmpArr[3]; 
  $bucket="nchcbucket7";
  $authz="/programs/jnkns/projects/jenkins";
  $uploader="summerhill001@gmail.com";
  #python 02-gdc_manifest_delete.py 95de72fe73e512e7863065dd3d620252 
  $cmd="python 02-gdc_manifest_delete.py $did";
  echo $cmd."\n";
  //exec($cmd);
 }
}
