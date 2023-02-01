select user,host from mysql.user;

dstawebbuild1
docker run --network="host" --rm --tty ghcr.io/dimitri/pgloader:latest pgloader mysql://root@127.0.0.1/camagru_glagan pgsql://postgres:sva_build@127.0.0.1/dstawebbuild1


docker run --network host --rm --tty ghcr.io/dimitri/pgloader:latest pgloader --debug mysql://root@127.0.0.1/camagru_glagan postgresql://postgres:sva_build@localhost/dstawebbuild1

docker run --network host --rm --tty ghcr.io/dimitri/pgloader:latest pgloader --debug mysql://root:root@172.17.0.1/camagru_glagan postgresql://postgres:sva_build@172.17.0.1/dstawebbuild1

psql  postgresql://postgres:sva_build@localhost/dstawebbuild1


 pgloader   mysql://root:root@127.0.0.1/camagru_glagan postgresql://postgres:sva_build@127.0.0.1/dstawebbuild1


    https://github.com/dimitri/pgloader/issues/1241


psql  postgresql://postgres:sva_build@172.23.208.1/dstawebbuild1
pgloader   mysql://root:root@172.23.208.1/camagru_glagan postgresql://postgres:sva_build@172.23.208.1/test
pgloader   mysql://root:root@172.23.208.1/camagru_glagan postgresql://postgres:sva_build@172.23.208.1/dstawebbuild1


skip-grant-tables
