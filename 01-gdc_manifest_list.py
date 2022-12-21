# python 01-gdc_manifest_ad.py \
# 95de72fe73e512e7863065dd3d620252 \
# 462747644 \
# cc4e713b-f86a-44b6-b714-458611b268de \
# nchcbucket7 \
# TCGA-A8-A07G-01Z-00-DX1.37E8A762-8141-4BE6-935A-B3DCB712BB4A.svs \
# /programs/jnkns/projects/jenkins \
# summerhill001@gmail.com

import sys
from gen3.index import Gen3Index
from gen3.auth import Gen3Auth
from gen3.tools.indexing import index_manifest

# argument
# if len(sys.argv) < 8:
    # print('no argument')
    # sys.exit()

# md5=sys.argv[1]
# size=int(sys.argv[2])
# did=sys.argv[3]
# bucket=sys.argv[4]
# file_name=sys.argv[5]
# authz=sys.argv[6]
# uploader=sys.argv[7]

# Install n API Key downloaded from the 
# commons' "Profile" page at ~/.gen3/credentials.json
def main():
    #auth = Gen3Auth()
    auth = Gen3Auth(refresh_file="credentials.json")
    auth.endpoint='https://google-gen4.biobank.org.tw'
    index = Gen3Index(auth.endpoint, auth_provider=auth)
    #index = Gen3Index(auth)
    if not index.is_healthy():
        print(f"uh oh! The indexing service is not healthy in the commons {auth.endpoint}")
        exit()
    result=index.get_all_records()   
    result=index_manifest.GUID()    
    #result=index.get(guid='97943d87-fed7-4f14-a0a7-c5bfee64c392')
    print(result)
    

if __name__ == "__main__":
    main()