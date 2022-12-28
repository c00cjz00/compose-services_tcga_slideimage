<?php
// conda activate g3po4
// export GEN3_URL=https://google-gen4.biobank.org.tw/

$program_id=$argv[1];

//get project id
$string = file_get_contents("tcga_data/files.json");
$json_data = json_decode($string, true);
foreach ($json_data as $key => $arr) {
 $project_id=$arr["cases"][0]["project"]["project_id"];	
 $file_name_tmp=$arr["file_name"];
 $$file_name_tmp=$project_id;
}

$manifest="tcga_data/gdc_manifest.txt";
$arr=file($manifest);
foreach ($arr as $key => $value) {
 //id      filename        md5     size    state	
 $tmpArr=explode("\t",trim($value));
 $did=$tmpArr[0]; 
 if (strlen($did)>10){ 
  $file_name=$tmpArr[1]; 
  $project_id=$$file_name;
  $md5=$tmpArr[2]; 
  $size=$tmpArr[3]; 
  $bucket="tcgademo";
  $authz="/programs/$program_id/projects/$project_id";
  $uploader="summerhill001@gmail.com";
  #python 01-gdc_manifest_add.py 95de72fe73e512e7863065dd3d620252 462747644 cc4e713b-f86a-44b6-b714-458611b268de nchcbucket7 TCGA-A8-A07G-01Z-00-DX1.37E8A762-8141-4BE6-935A-B3DCB712BB4A.svs /programs/jnkns/projects/jenkins summerhill001@gmail.com
  $cmd="python 01-gdc_manifest_add.py $md5 $size $did $bucket $file_name $authz $uploader";
  echo $cmd."\n";
  //exec($cmd);
 }
}
