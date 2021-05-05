# ポートフォリオ デプロイ手順
<a herf='https://github.com/homing-job/portfolio'>https://github.com/homing-job/portfolio</a><br>
<br>
# 1. docker file clone
git clone https://github.com/homing-job/docker.git<br>
cd docker<br>
mkdir server<br>
docker-compose up -d<br>
<br>
# 2. laravel project clone<br>
git clone https://github.com/homing-job/portfolio.git server<br>
<br>
# 3. db作成
docker exec -it db bash<br>
　　mysql -u root -p<br>
　　- Enter password: root<br>
　　- mysql> create database laravel;<br>
　　- mysql> quit;<br>
　　exit<br>
<br>
# 4. laravel環境設定
cp server/.env.sample server/.env<br>
vim server/.env<br>
　　DB_CONNECTION=mysql<br>
　　DB_HOST=db<br>
　　DB_PORT=3306<br>
　　DB_DATABASE=laravel<br>
　　DB_USERNAME=root<br>
　　DB_PASSWORD=root<br>
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
# DNS周りでエラーがおきる場合
https://ittechnicalmemos.blogspot.com/2020/05/dockernpm-installeaiagainlinux.html
