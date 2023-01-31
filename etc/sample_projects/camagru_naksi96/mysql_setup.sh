docker-machine start Camagru
eval $(docker-machine env Camagru)
docker start mysql-db
docker exec -it mysql-db /bin/bash