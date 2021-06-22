# Docker setup for linux

1. Get docker if not installed already
    * Note: make sure you don't have previous install of docker first
    ```
   curl -fsSL https://get.docker.com -o get-docker.sh
   sh get-docker.sh
   ```

1. Get docker compose if not installed
   ```
   sudo curl -L "https://github.com/docker/compose/releases/download/1.29.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
   sudo chmod +x /usr/local/bin/docker-compose
   ```
   Read more from https://docs.docker.com/compose/install/
     
1. Create docker .env from .env.dist 
    * From project root dir execute
    ```shell script
    cp .docker/.env.dist .docker/.env
    ```
1. Configure your hosts file to redirect app domain (optional)
       ```bash
      sudo -- sh -c "echo '127.0.0.1 campervan.local' >> /etc/hosts"
       ```
1. Download and run images 
    ```
    # This will download all missing containers and run them (including mariadb)
    cd .docker
    sudo docker-compose up
    ```

### Environments
When docker is running you have access to the following environments
* UI http://localhost or http://campervan.local
* Adminer http://localhost:8089/?server=campervan_mariadb&username=admin
    * DB user and password are in .docker/.env file

### Running console commands

"SSH" into container and run them there
NB! Containers are mostly running alpine linux so no bash, only sh
```shell script
# php container
docker exec -it campervan_php sh

# apache container
docker exec -it campervan_apache sh

# mariadb container
docker exec -it campervan_mariadb sh
```
### Useful docker commands
```
# Rebuild all containers based on Dockerfile
sudo docker-compose up --build

# See active docker containers
sudo docker ps

# See all containers
sudo docker ps -a

# See container resource usage
sudo docker stats

# Free up space by removing unused docker related stuff (-a for removing all)
sudo docker system prune 
```
