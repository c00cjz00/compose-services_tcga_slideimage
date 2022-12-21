# A. Install Package
## 1. Download credentials.json from your gen3 website and copy to ~/.gen3/ Folder
```
mkdir -p ~/.gen3
cp credentials.json ~/.gen3/credentials.json
```

## 2. Install parallel and php
```
sudo apt-get update -y
sudo apt-get install jq parallel -y
```
```
sudo add-apt-repository ppa:ondrej/php -y
sudo apt-get -y update
sudo apt install -y php7.4-cli php7.4-mbstring php7.4-curl php7.4-zip php7.4-xml php7.4-mbstring php7.4-json 
sudo systemctl stop apache2
sudo systemctl disable apache2
```

## 3. Install Miniconda3 and g3po
```
cd ~/
wget https://repo.anaconda.com/miniconda/Miniconda3-latest-Linux-x86_64.sh
bash Miniconda3-latest-Linux-x86_64.sh
```
```
conda create -n g3po python=3.8 -y
conda activate g3po
pip install gen3
pip install g3po
```

## 4. Fix g3po code
a. ~/miniconda3/envs/g3po/lib/python3.8/site-packages/indexclient/client.py
```
    def create(
        self,
        hashes,
        size,
        did=None,
        urls=None,
        file_name=None,
        metadata=None,
        baseid=None,
        acl=None,
        urls_metadata=None,
        version=None,
        authz=None,
        uploader=None, ## Add this line
    ):

        if urls is None:
            urls = []
        json = {
            "urls": urls,
            "form": "object",
            "hashes": hashes,
            "size": size,
            "file_name": file_name,
            "metadata": metadata,
            "urls_metadata": urls_metadata,
            "baseid": baseid,
            "acl": acl,
            "authz": authz,
            "version": version,
            "uploader": uploader, ## Add this line
        }
```
b. ~/miniconda3/envs/g3po/lib/python3.8/site-packages/gen3/index.py
```
    def create_record(
        self,
        hashes,
        size,
        did=None,
        urls=None,
        file_name=None,
        metadata=None,
        baseid=None,
        acl=None,
        urls_metadata=None,
        version=None,
        authz=None,
        uploader=None, ## Add this line
    ):
        rec = self.client.create(
            hashes,
            size,
            did,
            urls,
            file_name,
            metadata,
            baseid,
            acl,
            urls_metadata,
            version,
            authz,
            uploader, ## Add this line
        )
```
c. ~/miniconda3/envs/g3po/lib/python3.8/site-packages/gen3/__init__.py
```
from cdislogging import get_logger

LOG_FORMAT = "[%(asctime)s][%(levelname)7s] %(message)s"
#logging = get_logger("__name__", format=LOG_FORMAT, log_level="info")
logging = get_logger("__name__",LOG_FORMAT, log_level="info")
```

## 5. g3po example
```
export GEN3_URL=https://google-gen4.biobank.org.tw/
g3po index list
```

## 6. auth.py example
```
from gen3.index import Gen3Index
from gen3.auth import Gen3Auth

# Install n API Key downloaded from the
# commons' "Profile" page at ~/.gen3/credentials.json
def main():
    auth = Gen3Auth()
    auth = Gen3Auth(refresh_file="/home/ubuntu/.gen3/credentials.json")
    auth.endpoint='https://google-gen4.biobank.org.tw'
    index = Gen3Index(auth.endpoint, auth_provider=auth)
    index = Gen3Index(auth)
    if not index.is_healthy():
        print(f"uh oh! The indexing service is not healthy in the commons {auth.endpoint}")
        exit()

    print(f"uh oh! OK {auth.endpoint}")

if __name__ == "__main__":
    main()
```


# B. update Gen3
## 1. Edit user.yml 
change summerhill001@gmail.com to your gmail
```
authz:
  # policies automatically given to anyone, even if they are not authenticated
  anonymous_policies:
  - open_data_reader

  # policies automatically given to authenticated users (in addition to their other policies)
  all_users_policies: []

  groups:
  # can CRUD programs and projects and upload data files
  - name: data_submitters
    policies:
    - services.sheepdog-admin
    - data_upload
    - MyFirstProject_submitter
    users:
    - summerhill001@gmail.com

  # can create/update/delete indexd records
  - name: indexd_admins
    policies:
    - indexd_admin
    users:
    - summerhill001@gmail.com

  resources:
  - name: workspace
  - name: data_file
  - name: services
    subresources:
    - name: sheepdog
      subresources:
      - name: submission
        subresources:
        - name: program
        - name: project
  - name: open
  - name: programs
    subresources:
    - name: MyFirstProgram
      subresources:
      - name: projects
        subresources:
        - name: MyFirstProject
    - name: TCGA
      subresources:
        - name: projects
          subresources:
            - name: TCGA-DLBC
            - name: TCGA-MESO
            - name: TCGA-PAAD
            - name: TCGA-COAD
            - name: TCGA-LUAD
            - name: TCGA-TGCT
            - name: TCGA-ESCA
            - name: TCGA-CHOL
            - name: TCGA-KIRP
            - name: TCGA-KIRC
            - name: TCGA-PRAD
            - name: TCGA-PCPG
            - name: TCGA-SARC
            - name: TCGA-LIHC
            - name: TCGA-GBM
            - name: TCGA-BLCA
            - name: TCGA-UCS
            - name: TCGA-UCEC
            - name: TCGA-ACC
            - name: TCGA-KICH
            - name: TCGA-READ
            - name: TCGA-OV
            - name: TCGA-SKCM
            - name: TCGA-UVM
            - name: TCGA-THCA
            - name: TCGA-LGG
            - name: TCGA-LUSC
            - name: TCGA-HNSC
            - name: TCGA-THYM
            - name: TCGA-CESC
            - name: TCGA-BRCA
            - name: TCGA-STAD
            - name: TCGA-LAML
    - name: program1
      subresources:
      - name: projects
        subresources:
        - name: P1

  policies:
  - id: workspace
    description: be able to use workspace
    resource_paths:
    - /workspace
    role_ids:
    - workspace_user
  - id: data_upload
    description: upload raw data files to S3
    role_ids:
    - file_uploader
    resource_paths:
    - /data_file
  - id: services.sheepdog-admin
    description: CRUD access to programs and projects
    role_ids:
      - sheepdog_admin
    resource_paths:
      - /services/sheepdog/submission/program
      - /services/sheepdog/submission/project
  - id: indexd_admin
    description: full access to indexd API
    role_ids:
      - indexd_admin
    resource_paths:
      - /programs
  - id: open_data_reader
    role_ids:
      - reader
      - storage_reader
    resource_paths:
    - /open
  - id: all_programs_reader
    role_ids:
    - reader
    - storage_reader
    resource_paths:
    - /programs
  - id: MyFirstProject_submitter
    role_ids:
    - reader
    - creator
    - updater
    - deleter
    - storage_reader
    - storage_writer
    resource_paths:
    - /programs/MyFirstProgram/projects/MyFirstProject
  - id: TCGA
    role_ids:
    - reader
    - creator
    - updater
    - deleter
    - storage_reader
    - storage_writer
    resource_paths:
    - /programs/TCGA
    - /programs/TCGA/projects/TCGA-DLBC
    - /programs/TCGA/projects/TCGA-MESO
    - /programs/TCGA/projects/TCGA-PAAD
    - /programs/TCGA/projects/TCGA-COAD
    - /programs/TCGA/projects/TCGA-LUAD
    - /programs/TCGA/projects/TCGA-TGCT
    - /programs/TCGA/projects/TCGA-ESCA
    - /programs/TCGA/projects/TCGA-CHOL
    - /programs/TCGA/projects/TCGA-KIRP
    - /programs/TCGA/projects/TCGA-KIRC
    - /programs/TCGA/projects/TCGA-PRAD
    - /programs/TCGA/projects/TCGA-PCPG
    - /programs/TCGA/projects/TCGA-SARC
    - /programs/TCGA/projects/TCGA-LIHC
    - /programs/TCGA/projects/TCGA-GBM
    - /programs/TCGA/projects/TCGA-BLCA
    - /programs/TCGA/projects/TCGA-UCS
    - /programs/TCGA/projects/TCGA-UCEC
    - /programs/TCGA/projects/TCGA-ACC
    - /programs/TCGA/projects/TCGA-KICH
    - /programs/TCGA/projects/TCGA-READ
    - /programs/TCGA/projects/TCGA-OV
    - /programs/TCGA/projects/TCGA-SKCM
    - /programs/TCGA/projects/TCGA-UVM
    - /programs/TCGA/projects/TCGA-THCA
    - /programs/TCGA/projects/TCGA-LGG
    - /programs/TCGA/projects/TCGA-LUSC
    - /programs/TCGA/projects/TCGA-HNSC
    - /programs/TCGA/projects/TCGA-THYM
    - /programs/TCGA/projects/TCGA-CESC
    - /programs/TCGA/projects/TCGA-BRCA
    - /programs/TCGA/projects/TCGA-STAD
    - /programs/TCGA/projects/TCGA-LAML    
  - id: program1
    role_ids:
    - reader
    - creator
    - updater
    - deleter
    - storage_reader
    - storage_writer
    resource_paths:
    - /programs/program1
    - /programs/program1/projects/P1

  roles:
  - id: file_uploader
    permissions:
    - id: file_upload
      action:
        service: fence
        method: file_upload
  - id: workspace_user
    permissions:
    - id: workspace_access
      action:
        service: jupyterhub
        method: access
  - id: sheepdog_admin
    description: CRUD access to programs and projects
    permissions:
    - id: sheepdog_admin_action
      action:
        service: sheepdog
        method: '*'
  - id: indexd_admin
    description: full access to indexd API
    permissions:
    - id: indexd_admin
      action:
        service: indexd
        method: '*'
  - id: admin
    permissions:
      - id: admin
        action:
          service: '*'
          method: '*'
  - id: creator
    permissions:
      - id: creator
        action:
          service: '*'
          method: create
  - id: reader
    permissions:
      - id: reader
        action:
          service: '*'
          method: read
  - id: updater
    permissions:
      - id: updater
        action:
          service: '*'
          method: update
  - id: deleter
    permissions:
      - id: deleter
        action:
          service: '*'
          method: delete
  - id: storage_writer
    permissions:
      - id: storage_creator
        action:
          service: '*'
          method: write-storage
  - id: storage_reader
    permissions:
      - id: storage_reader
        action:
          service: '*'
          method: read-storage

clients:
  wts:
    policies:
    - all_programs_reader
    - open_data_reader

users:
  summerhill001@gmail.com:
    tags:
      name: User One
#      email: mustbe@differentemail.com
    policies:
    - workspace
    - data_upload
    - MyFirstProject_submitter
    - TCGA
    - program1
  username2:
    tags:
      name: John Doe
      email: johndoe@gmail.com

cloud_providers: {}
groups: {}
```

## 2.  sync user.yml
```
bash userSync.sh
```

## 3. Create program name TCGA
https://google-gen4.biobank.org.tw/api/v0/submission/TCGA/
```
## repleace google-gen4.biobank.org.tw to your domain name, and replace the command that contains google-gen4.biobank.org.tw to your domain name below
## https://google-gen4.biobank.org.tw/_root
dbgap_accession_number: tcga_version1.0
name: TCGA
```

# C. TCGA
## 1. git clone TCGA code 
```
git clone https://github.com/c00cjz00/compose-services_tcga_slideimage.git
```

## 12. build TCGA code 
```
HOSTNAME=my-gen3.biobank.org.tw
cd compose-services_tcga_slideimage
./replace google-gen4.biobank.org.tw my-gen3.biobank.org.tw -- *
conda activate g3po
bash build.sh
```

# D. Reset gen3
```
cd ~/compose-services_google/
docker-compose down -v
```
