# coachtech-flea

## サービス概要

現在競合他社で展開しているフリマアプリは、機能や画面が複雑で使いにくい仕様になっているものが多くあります。  
そこでシンプルで直感的に使うことができるフリマアプリを作成しました。

## 環境構築

### Docker ビルド

1.

```bash
git clone https://github.com/kenta-10043/coachtech-flea.git
```

2.

```bash
make init
```

※プロジェクト直下のディレクトリで実行してください。  
※MySQL は、OS によって起動しない場合があるのでそれぞれの PC に合わせて docker-compose.yml ファイルを編集してください。


### Laravel 環境構築

1.env の環境変数を変更

| 設定項目    | 変更前    | 変更後       |
| ----------- | --------- | ------------ |
| DB_HOST     | 127.0.0.1 | mysql        |
| DB_DATABASE | laravel   | laravel_db   |
| DB_USERNAME | root      | laravel_user |
| DB_PASSWORD | ー        | laravel_pass |

<br>

| 設定項目      | 入力値        |
| ------------- | ------------- |
| STRIPE KEY    | pk_test ××××× |
| STRIPE SECRET | sk_test ××××× |
- ××××× はご自身で KEY を取得・入力してください。
- Stripe の API キーは、[Stripe](https://stripe.com/jp)ダッシュボードから取得してください。

<br>

| 設定項目      | 入力値        |
| ------------- | ------------- |
| USER_ID       | ××××　　　　　 |
| GROUP_ID 　　　| ××××　　　　　 |
- Docker環境下で権限トラブルの軽減のためにプロジェクトルート直下に.envファイルを作成してUSER_IDとGROUP_IDにご自身のホストIDを入力してください。
- ホストIDはローカルのターミナルでidコマンドを入力して確認できます。
```bash
id
# uid=××××（〇〇〇〇) gid=××××（〇〇〇〇）
```
<br>

2.マイグレーションの実行

```bash
php artisan migrate
```

- php artisan migrate 実行時に DB エラーが発生した場合は以下のコマンドで volume を削除して再構築してください。

```bash
docker-compose down -v  # volume 削除 DB 初期化
docker-compose up -d
```
<br>

3.シーディングの実行

```bash
php artisan db:seed
```
<br>

4.テストを実行する際は.test.env ファイルを作成

```bash
cp .env .env.testing
```

| 設定項目       | 変更前       | 変更後     |
| -------------- | ------------ | ---------- |
| APP_ENV        | local        | testing    |
| DB_CONNECTION  | mysql        | mysql_test |
| DB_DATABASE    | laravel_db   | demo_test  |
| DB_USERNAME    | laravel_user | root       |
| DB_PASSWORD    | laravel_user | root       |
| CACHE_DRIVER   | file         | array      |
| SESSION_DRIVER | file         | array      |
| MAIL_MAILER    | smtp         | log        |

### テスト実行手順

- demo_test データベース作成

```bash
docker-compose exec mysql bash
```

```sql
mysql -u root -p
```

```sql
CREATE DATABASE demo_test;
```

- テスト用テーブル作成

```bash
php artisan migrate --env=testing
```

- php artisan migrate --env=testing 実行時に DB エラーが発生した場合は以下のコマンドで volume を削除して再構築してください。

```bash
docker-compose down -v  # volume 削除 DB 初期化
docker-compose up -d
```

- テスト実行

```bash
php artisan test --env=testing
```
<br>

### ストライプダミー決済実行のテストカード番号

- カード番号：4242 4242 4242 4242
- 有効期限：（例：12/34）
- CVC：（例：123）

- これらは **テストモード専用** の番号です。本番では使用しないでください。

<br>

## 使用技術

- PHP 8.3-fpm
- Laravel 10.48.29
- MySQL 8.0.34
- fortify \* v1.28.0
- mailhog

<br>

## テーブル仕様

- users テーブル

|     カラム名             |      型      | primary key | unique key | not null | foreign key |
| :---------------:        | :----------: | :---------: | :--------: | :------: | :---------: |
|        id                |   bigint.    |      ◯      |            |    ◯     |             |
|       name               | varchar(255) |             |            |    ◯     |             |
|       email              | varchar(255) |             |     　     |    ◯     |             |
|     password             | varchar(255) |             |            |    〇    |             |
| profile_completed        |  boolean     |             |            |          |             |
| email_verified_at        |  timestamp   |             |            |          |             |
|  remember_token          | varchar(100) |             |            |          |             |
| two_factor_secret        |   text       |             |            |          |             |
| two_factor_recovery_code |   text       |             |            |          |             |
| two_factor_confirmed_at  |  timestamp   |             |            |          |             |
|    role                  | varchar(100) |             |            |    〇    |             |
| deleted_at               |  timestamp   |             |            |          |             |
| created_at               |  timestamp   |             |            |          |              |
| updated_at               |  timestamp   |             |            |          |              |
<br>

- profiles テーブル

|  カラム名       |    型        | primary key | unique key | not null | foreign key  |
| :--------:     | :-------:    | :---------: | :--------: | :------: | :----------: |
|     id         |  bigint      |      ◯      |            |    ◯     |              |
|  user_id       |  bigint      |             |            |    ◯     |  users(id)   |
| postal_code    |  char(8)     |             |            |    ◯     |             |
|  address       | varchar(255) |             |            |    〇     |              |
|  building      | varchar(255) |             |            |           |              |
|  profile_image | varchar(255) |             |            |          |              |
| created_at     | timestamp    |             |            |          |              |
| updated_at     | timestamp    |             |            |          |              |
<br>

- likes テーブル

|    カラム名    |    型     | primary key | unique key | not null |   foreign key     |
| :------------: | :-------: | :---------: | :--------: | :------:  | :--------------: |
|       id       |  bigint   |      ◯     |            |    ◯     |                  |
|    user_id     |  bigint   |             |            |    ◯     |    users(id)     |
|    item_id     |  bigint   |             |            |    ◯     |    items(id)     |
|   created_at   | timestamp |             |            |           |                  |
|   updated_at   | timestamp |             |            |           |                  |
<br>

- comments テーブル

|   カラム名    |      型      | primary key | unique key | not null |   foreign key   |
| :-----------: | :----------: | :---------: | :--------: | :------: | :-------------: |
|      id       |    bigint    |      ◯     |            |    ◯     |                 |
|    user_id    |    bigint    |             |            |    ◯     |    users(id)    |
|    item_id    |    bigint    |             |            |    ◯     |    items(id)    |
|    comment    |    text      |             |            |           |                 |
|  created_at   |  timestamp   |             |            |           |                 |
|  updated_at   |  timestamp   |             |            |           |                 |
<br>

- items テーブル

|  カラム名             |    型          | primary key | unique key | not null | foreign key        |
| :--------:           | :-------:     | :---------: | :--------: | :------: | :---------:        |
|     id               |  bigint       |      ◯      |            |    ◯     |                  |
|   user_id            |  bigint       |              |            |    ◯     |  users(id)       |
|   buyer_id           |  bigint       |              |            |           |  users(id)       |
|   condition_id       |  bigint       |              |            |    ◯     |  conditions(id)  |
|   item_name          |  varchar(255) |              |            |    ◯     |                  |
|   brand_name         |  varchar(255) |              |            |           |                  |
|   price              |  int          |              |            |    ◯     |                  |
|   item_image         |  varchar(255) |              |            |    ◯     |                  |
|   status             |  tinyint      |              |            |    ◯     |                  |
|   transaction_status |  tinyint      |              |            |           |                  |
|   description        |  text         |              |            |    ◯     |                  |
| created_at           | timestamp     |              |            |           |                  |
| updated_at           | timestamp     |              |            |           |                  |
<br>

- categories テーブル

|  カラム名        |    型          | primary key | unique key | not null | foreign key        |
| :--------:      | :-------:     | :---------: | :--------: | :------: | :---------:        |
|     id          |  bigint       |      ◯      |            |    ◯     |                  |
|   category      |  int          |              |            |    ◯     |                  |
| created_at      | timestamp     |              |            |           |                  |
| updated_at      | timestamp     |              |            |           |                  |
<br>

- category_item テーブル

|  カラム名       |    型          | primary key | unique key | not null | foreign key        |
| :--------:      | :-------:     | :---------: | :--------: | :------: | :---------:        |
|     id          |  bigint       |      ◯      |            |    ◯     |                  |
|   item_id       |  bigint       |              |            |    ◯     |  items(id)       |
|   category_id   |  bigint       |              |            |    ◯     |  categories(id)  |
| created_at      | timestamp     |              |            |           |                  |
| updated_at      | timestamp     |              |            |           |                  |
<br>

- conditions テーブル

|  カラム名        |    型         | primary key | unique key | not null | foreign key        |
| :--------:      | :-------:     | :---------: | :--------: | :------: | :---------:        |
|     id          |  bigint       |      ◯      |            |    ◯     |                  |
|   condition     |  tinyint      |              |            |    ◯     |                  |
| created_at      | timestamp     |              |            |           |                  |
| updated_at      | timestamp     |              |            |           |                  |
<br>

- orders テーブル

|  カラム名              |    型         | primary key | unique key | not null | foreign key        |
| :--------:            | :-------:     | :---------: | :--------: | :------: | :---------:        |
|     id                |  bigint       |      ◯      |            |    ◯     |                  |
|   user_id             |  bigint       |              |            |    ◯     |  users(id)       |
|   item_id             |  bigint       |              |            |    ◯     |  items(id)       |
|   payment_method      |  tinyint      |              |            |    ◯     |                  |
| shopping_postal_code  |  varchar(255) |              |            |           |                  |
| shopping_address      |  varchar(255) |              |            |           |                  |
| shopping_building     |  varchar(255) |              |            |           |                  |
|   status              |  varchar(255) |              |            |           |                  |
|  checkout_session_id  |  varchar(255) |              |     〇     |           |                  |
|   paid_at             |  timestamp    |              |            |           |                  |
| created_at            | timestamp     |              |            |           |                  |
| updated_at            | timestamp     |              |            |           |                  |
<br>  

- ratings テーブル

|  カラム名              |    型         | primary key | unique key | not null | foreign key        |
| :--------:            | :-------:     | :---------: | :--------: | :------: | :---------:        |
|     id                |  bigint       |      ◯      |            |    ◯     |                  |
|   reviewer_id         |  bigint       |              |            |    ◯     |  users(id)       |
|   reviewee_id         |  bigint       |              |            |    ◯     |  users(id)       |
|   rating              |  tinyint      |              |            |           |                  |
| created_at            | timestamp     |              |            |           |                  |
| updated_at            | timestamp     |              |            |           |                  |
<br>  

- chats テーブル

|  カラム名              |    型         | primary key | unique key | not null | foreign key        |
| :--------:            | :-------:     | :---------: | :--------: | :------: | :---------:        |
|     id                |  bigint       |      ◯      |            |    ◯     |                  |
|   item_id             |  bigint       |              |            |    ◯     |  item(id)        |
|   sender_id           |  bigint       |              |            |           |  users(id)       |
|   receiver_id         |  bigint       |              |            |           |  users(id)       |
|   body                |  text         |              |            |           |                  |
| created_at            | timestamp     |              |            |           |                  |
| updated_at            | timestamp     |              |            |           |                  |
<br>  

- chat_images テーブル

|  カラム名              |    型         | primary key | unique key | not null | foreign key        |
| :--------:            | :-------:     | :---------: | :--------: | :------: | :---------:        |
|     id                |  bigint       |      ◯      |            |    ◯     |                  |
|   chat_id             |  bigint       |              |            |    ◯     |  chat(id)        |
|   chat_image          |  string       |              |            |           |                  |
| created_at            | timestamp     |              |            |           |                  |
| updated_at            | timestamp     |              |            |           |                  |
<br>



## ER 図  

![ER](./flea_2.drawio.png)  

<br>

## 開発環境

- 商品一覧：http://localhost/
- ユーザー登録：http://localhost/register
- phpMyAdmin：http://localhost:8080/

<br>

## ログイン情報  

### 一般ユーザー 
#### user01
- email:user01@example.com  
- password:password01
- itemデータ紐づけなし
<br>

#### user02  
- email:user02@example.com    
- password:password02  
- itemデータ紐づけCO01~CO05  
<br>

#### user03  
- email:user03@example.com  
- password:password03  
- itemデータ紐づけCO06~CO10
  
<br>  

- roleによって管理者・一般ユーザーを区別しています  
  

