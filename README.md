# compose-services_tcga_slideimage

## 1. Install package
```
sudo apt=get update -y
sudo apt=get install jq parallel -y
```

## 2. Install Miniconda3
```
cd ~/
wget https://repo.anaconda.com/miniconda/Miniconda3-latest-Linux-x86_64.sh
bash Miniconda3-latest-Linux-x86_64.sh
```

## 3. Install g3po and Fix code
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
## b. ~/miniconda3/envs/g3po/lib/python3.8/site-packages/gen3/index.py
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
