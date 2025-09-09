# coachtech-flea

## サービス概要

現在競合他社で展開しているフリマアプリは、機能や画面が複雑で使いにくい仕様になっているものが多くあります。  
そこでシンプルで直感的に使うことができるフリマアプリを作成しました。

## 環境構築

### Docker ビルド

1.git clone<https://github.com/kenta-10043/coachtech-flea.git>  
2.docker-compose up -d --build

\*MySQL は、OS によって起動しない場合があるのでそれぞれの PC に合わせて docker-compose.yml ファイルを編集してください。

Laravel 環境構築

1.PHP コンテナへの移動

docker-compose exec php bash

2.Laravel のパッケージのインストール

composer install

3.env.example ファイルから.env を作成し、環境変数を変更

cp .env.example .env

| 設定項目    | 変更前    | 変更後       |
| ----------- | --------- | ------------ |
| DB_HOST     | 127.0.0.1 | mysql        |
| DB_DATABASE | laravel   | laravel_db   |
| DB_USERNAME | root      | laravel_user |
| DB_PASSWORD | ー        | laravel_pass |

|STRIPE*KEY|---|pk_test*×××××|（××××× はご自身で KEY を取得・入力してください。）  
|STRIPE*SECRET|---|sk_test*×××××|（××××× はご自身で KEY を取得・入力してください。）  
Stripe の API キーは、Stripe ダッシュボード(https://stripe.com/jp)から取得してください。

4.アプリケーションキーの作成

php artisan key:generate

5.マイグレーションの実行

php artisan migrate

php artisan migrate 実行時に DB エラーが発生した場合は以下のコマンドで volume を削除して再構築してください。

docker-compose down -v (volume 削除 DB 初期化)

docker-compose up -d

6.シーディングの実行

php artisan db:seed

7.画像ファイルのシンボリックリンク

php artisan storage:link

8.テストを実行する際は.test.env ファイルを作成

cp .env .test.env

| 設定項目      | 変更前       | 変更後     |
| ------------- | ------------ | ---------- |
| APP_ENV       | local        | test       |
| DB_CONNECTION | mysql        | mysql_test |
| DB_DATABASE   | laravel_db   | demo_test  |
| DB_USERNAME   | laravel_user | root       |
| DB_PASSWORD   | laravel_user | root       |

### テスト実行手順

- demo_test データベース作成

CREATE DATABASE demo_test

- テスト用テーブル作成

php artisan migrate --env=testing

- テスト実行

php artisan test

### ストライプダミー決済実行のテストカード番号

- カード番号：4242 4242 4242 4242
- 有効期限：（例：12/34）
- CVC：（例：123）

> これらは **テストモード専用** の番号です。本番では使用しないでください。

## 使用技術

- PHP 8.3-fpm
- Laravel 10.48.29
- MySQL 8.0.34
- fortify \* v1.28.0
- mailhog

## ER 図

## 開発環境

- 商品一覧：http://localhost/
- ユーザー登録：http://localhost/register
- phpMyAdmin：http://localhost:8080/
