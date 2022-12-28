# build
## 1. create program name TCGA
## repleace google-gen4.biobank.org.tw to your domain name, and replace the command that contains google-gen4.biobank.org.tw to your domain name below
## https://google-gen4.biobank.org.tw/_root
## dbgap_accession_number: tcga_version1.0 and name: TCGA

## 2. Download credentials.json from your gen3 website and copy to ~/.gen3/ Folder
#cp credentials.json ~/.gen3/credentials.json

## 3. delete json
find /tmp -name 'json*' | xargs rm ;
sleep 3

## 4. upload credentials.json
### copy credentials.json from ~/.gen3/ Folder  to tcga_data Folder  
rm -rf tcga_data
sleep 3
tar xzvf tcga_data_demo.tgz
cp  ~/.gen3/credentials.json tcga_data/

## 5. create project 
php 10-gdc_project_add.php TCGA

## 6. create experiment
php 11-gdc_experiment_add.php TCGA

## 7. buid manifest
php 01-gdc_manifest_add.php TCGA > tmp_add.sh
chmod 755 tmp_add.sh
sleep 2
cat tmp_add.sh | parallel -j 16
sleep 2
find /tmp -name 'json*' | xargs rm ;

## 8. create metadata
### conda activate g3po4
### export GEN3_URL=https://google-gen4.biobank.org.tw/
gen3_metadata_add () {
 echo 'test' > tmp_add.sh
 for i in {1..5};
 do
  if [ -s tmp_add.sh ]; then
   echo Round: $i
   php $app $program > tmp_add.sh
   chmod 755 tmp_add.sh
   sleep 2
   cat tmp_add.sh | parallel -j $jobs
   sleep 2
   find /tmp -name 'json*' | xargs rm ;
  fi
 done
}

### 8.1 case
program='TCGA'
app='12-gdc_case_add.php'
jobs=16
gen3_metadata_add

### 8.2 demographic
program='TCGA'
app='13-gdc_demographic_add.php'
jobs=16
gen3_metadata_add

### 8.3 diagnosis
program='TCGA'
app='14-gdc_diagnosis_add.php'
jobs=16
gen3_metadata_add

### 8.4 samples
program='TCGA'
app='15-gdc_samples_add.php'
jobs=16
gen3_metadata_add

### 8.5 slide
program='TCGA'
app='16-gdc_slide_add.php'
jobs=16
gen3_metadata_add

### 8.6 slide_image
program='TCGA'
app='17-gdc_slide_image_add_submit_id.php'
jobs=16
gen3_metadata_add







