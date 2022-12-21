rm -rf db
mkdir -p db/psql
docker exec -it  postgres su postgres bash -c 'pg_dump --format p --inserts arborist_db > /tmp/arborist_db.sql'
docker exec -it  postgres su postgres bash -c 'pg_dump --format p --inserts fence_db > /tmp/fence_db.sql'
docker exec -it  postgres su postgres bash -c 'pg_dump --format p --inserts indexd_db > /tmp/indexd_db.sql'
docker exec -it  postgres su postgres bash -c 'pg_dump --format p --inserts metadata > /tmp/metadata.sql'
docker exec -it  postgres su postgres bash -c 'pg_dump --format p --inserts metadata_db > /tmp/metadata_db.sql'

docker cp postgres:/tmp/arborist_db.sql db/psql/arborist_db.sql 
docker cp postgres:/tmp/fence_db.sql db/psql/fence_db.sql
docker cp postgres:/tmp/indexd_db.sql db/psql/indexd_db.sql
docker cp postgres:/tmp/metadata.sql db/psql/metadata.sql
docker cp postgres:/tmp/metadata_db.sql db/psql/metadata_db.sql


docker cp postgres_init.sql postgres_psql:/tmp/postgres_init.sql
docker cp db/psql/arborist_db.sql postgres_psql:/tmp/arborist_db.sql
docker cp db/psql/fence_db.sql postgres_psql:/tmp/fence_db.sql
docker cp db/psql/indexd_db.sql postgres_psql:/tmp/indexd_db.sql
docker cp db/psql/metadata.sql postgres_psql:/tmp/metadata.sql
docker cp db/psql/metadata_db.sql postgres_psql:/tmp/metadata_db.sql


docker exec -it  postgres_psql su postgres bash -c 'psql -f /tmp/postgres_init.sql'
docker exec -it  postgres_psql su postgres bash -c 'psql arborist_db -f /tmp/arborist_db.sql'
docker exec -it  postgres_psql su postgres bash -c 'psql fence_db -f /tmp/fence_db.sql'
docker exec -it  postgres_psql su postgres bash -c 'psql indexd_db -f /tmp/indexd_db.sql'
docker exec -it  postgres_psql su postgres bash -c 'psql metadata -f /tmp/metadata.sql'
docker exec -it  postgres_psql su postgres bash -c 'psql metadata_db -f /tmp/metadata_db.sql'


