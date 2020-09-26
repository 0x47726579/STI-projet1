#!/bin/bash
# This script was only tested on WSL bash
# but it should still work on linux.


docker kill sti_project
docker rm sti_project

echo "[+] Building and running docker..."

sleep 1
docker.exe run -ti -v "/${PWD}/site/":/usr/share/nginx/ -d -p 8080:80 --name sti_project --hostname sti arubinst/sti:project2018 

sleep 2
echo "[+] Starting nginx service"
docker exec -u root sti_project service nginx start
echo "[+] Starting php service"
docker exec -u root sti_project service php5-fpm start
echo "[*] Done"

sleep 10