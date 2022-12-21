import sys
#from gen3.file import Gen3File
from gen3.index import Gen3Index
from gen3.auth import Gen3Auth
from gen3.submission import Gen3Submission


# argument
if len(sys.argv) < 2:
    print('no argument')
    sys.exit()
program=sys.argv[1]
project=sys.argv[2]

# Install n API Key downloaded from the 
# commons' "Profile" page at ~/.gen3/credentials.json
def main():
    #auth = Gen3Auth()
    auth = Gen3Auth(refresh_file="credentials.json")
    auth.endpoint='https://google-gen4.biobank.org.tw'
    index = Gen3Index(auth.endpoint, auth_provider=auth)
    sub = Gen3Submission(auth.endpoint, auth_provider=auth)

    #file = Gen3File(auth.endpoint, auth_provider=auth)

    #index = Gen3Index(auth)
    if not index.is_healthy():
        print(f"uh oh! The indexing service is not healthy in the commons {auth.endpoint}")
        exit()
    #result=file.delete_file_locations(guid=guid)    
    result=sub.delete_project(program=program, project=project)  
    
    
    #result=index.get(guid='97943d87-fed7-4f14-a0a7-c5bfee64c392')
    print(result)
# id	filename	md5	size	state
# cc4e713b-f86a-44b6-b714-458611b268de	TCGA-A8-A07G-01Z-00-DX1.37E8A762-8141-4BE6-935A-B3DCB712BB4A.svs	95de72fe73e512e7863065dd3d620252	462747644	released
# bd5bd325-ddd8-420d-866d-8454b5782ed5	TCGA-A8-A07G-01A-01-TS1.ed5520f2-535b-4bb4-b580-b2372714d3fb.svs	9fd9f9fe9886e3ce6412c890df0611a5	152899879	released
# 5f2554f7-7140-4e0e-b028-b50d6fde5587	TCGA-A8-A07G-01A-01-BS1.77d7598e-9d52-424b-8e97-50f45155b8b7.svs	93facec1d9c6548b3557ca7232a7587d	347455741	released



if __name__ == "__main__":
    main()