# デプロイ手順
docker-compose up -d<br>
docker exec -it db bash<br>
　　mysql -u root -p<br>
　　- Enter password: root<br>
　　- mysql> create database laravel;<br>
　　- mysql> exit;<br>
　　exit<br>
<br>
docker exec -it php bash<br>
　　composer install<br>
　　npm install<br>
　　npm run prod<br>
　　php artisan migrate:refresh --seed<br>
　　php artisan key:generate<br>
　　chmod -R 777 storage<br>
　　chmod -R 777 bootstrap/cache<br>
<br>

# wslの場合DNSエラーが起こる
https://ittechnicalmemos.blogspot.com/2020/05/dockernpm-installeaiagainlinux.html<br>
sudo vim /etc/docker/daemon.json<br>
  {<br>
      "dns": ["DNSアドレス1"]<br>
  }<br>
sudo service docker restart<br>
