## アプリ概要
入力ページ、入力内容確認ページ、完了ページ<br>
それに伴う管理画面<br>
<br>
https://portfolio-rito.net/<br>
<br>
test用ユーザー<br>
メールアドレス:test@test.co.jp<br>
パスワード:test<br>
<br>

## 機能一覧
- 申込同意

- 申込
    - 直前同意チェック
    - 入力エラーチェック
    - 住所自動検索
    
- 申込確認
    - 入力内容表示
    
- 申込完了
    
- ユーザー関係
    - ログイン、ログアウト
    
- 管理画面(申込状況)
    - 一覧表示
    - 一覧絞り込み
    - 申込詳細表示
    - 申込削除
    
- 管理画面(競技日管理)
    - 一覧表示
    - 一覧絞り込み
    - 競技日登録
    - 競技日削除

- 管理画面(競技マスタ)
    - 一覧表示
    - 一覧絞り込み
    - マスタexcel出力
    - 登録、更新、削除、入力エラーチェック
    - 削除チェック(競技日存在チェック)
    - 更新、削除チェック(楽観ロック)

- 管理画面(汎用マスタ)
    - 一覧表示
    - 一覧絞り込み
    - マスタexcel出力
    - 登録、更新、削除、入力エラーチェック
    - 更新、削除チェック(楽観ロック)

## 使用画面

フロントエンド

| 申込同意　| 申込  |
| :----: | :----: |
| <img src="https://user-images.githubusercontent.com/72111956/107872605-b1408700-6eee-11eb-93bc-f0bc2ef7329f.png">   | <img src="https://user-images.githubusercontent.com/72111956/107872607-b1d91d80-6eee-11eb-812d-406d8fd36ba0.png">   |
<br>

| 申込確認 | 申込完了 |
| :----: | :----: |
| <img src="https://user-images.githubusercontent.com/72111956/107872608-b271b400-6eee-11eb-9ce6-f4219c2a23e5.png"> | <img src="https://user-images.githubusercontent.com/72111956/107872760-d681c500-6eef-11eb-9ff4-047be1499554.png"> |
<br>

管理画面

| ログイン | 申込状況 |
| :----: | :----: |
| <img src="https://user-images.githubusercontent.com/72111956/107872726-9589b080-6eef-11eb-8ae3-b016c78ef8c4.png"> | <img src="https://user-images.githubusercontent.com/72111956/108623828-6e4d5900-7484-11eb-925f-52109b47854d.png"> |

| 競技日管理(一覧) | 競技日管理(登録) |
| :----: | :----: |
| <img src="https://user-images.githubusercontent.com/72111956/107872595-ae459680-6eee-11eb-9a49-b12d2240571a.png"> | <img src="https://user-images.githubusercontent.com/72111956/107872691-55c2c900-6eef-11eb-9c26-a43027681250.png"> |

| 競技マスタ(一覧) | 競技日マスタ(登録) |
| :----: | :----: |
| <img src="https://user-images.githubusercontent.com/72111956/107872598-af76c380-6eee-11eb-8cd4-7117dab2d594.png"> | <img src="https://user-images.githubusercontent.com/72111956/107872599-b00f5a00-6eee-11eb-9667-0e66737cbdd8.png"> |

| 競技マスタ(編集) ||
| :----: | :----: |
| <img src="https://user-images.githubusercontent.com/72111956/107873831-ccb08f80-6ef8-11eb-8af9-2f5e03302b7b.png"> ||

| 汎用マスタ(一覧) | 汎用マスタ(登録) |
| :----: | :----: |
| <img src="https://user-images.githubusercontent.com/72111956/107873916-4183c980-6ef9-11eb-91b1-4922e037a1e0.png"> | <img src="https://user-images.githubusercontent.com/72111956/107872604-b1408700-6eee-11eb-95b8-1c4934a46221.png"> |

| 汎用マスタ(編集) ||
| :----: | :----: |
| <img src="https://user-images.githubusercontent.com/72111956/108779922-ffb6eb00-75aa-11eb-8389-c206df341c87.png"> ||

<br>
<br>

## 使用技術

### フロントエンド
- JavaScript
- Jquery 3.2
- bootstrap 4.0.0
- bootstrap-vue 2.19.0
- Vue 2.6.12

### バックエンド
- PHP 7.4.2
- Laravel 8.26.1
- PHPUnit 9.3.3
- larastan 0.6.10
- Laravel Dusk 6.9
- composer 2.0.4
- node.js 15.1.0
- npm 7.0.8
- Docker 19.03.13
- docker-compose 1.27.4

### インフラストラクチャー
- Mysql 8.0.20
- nginx 1.16.1
- AWS

### AWS
    - VPC
    - EC2
    - ALB
    - RDS
    - ACM
    - Route 53
    - ElastiCache
<img src="https://user-images.githubusercontent.com/72111956/108617259-1f89ca00-7458-11eb-8f50-c74be1598966.png">

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

# DNSエラーが発生する場合
https://ittechnicalmemos.blogspot.com/2020/05/dockernpm-installeaiagainlinux.html<br>
sudo vim /etc/docker/daemon.json<br>
  {<br>
      "dns": ["DNSアドレス1"]<br>
  }<br>
sudo service docker restart<br>
