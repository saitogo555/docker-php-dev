# Docker PHP Development Environment

このリポジトリはPHPの開発環境をDockerで構築したものです。

phpMyAdminとMailhogが導入済みのため、それぞれブラウザからデータベースとメールを確認することが出来ます。

## 必須環境

- Docker (Docker Desktop, Docker Engine)

## セットアップ手順

1. リポジトリをクローンする。

    ```bash
    git clone https://github.com/saitogo555/docker-php-dev.git
    ```

2. プロジェクトフォルダに移動する。

    ```bash
    cd docker-php-dev
    ```

3. コンテナを起動する。

    ```bash
    docker compose up -d
    ```

## サービス一覧

| サービス名                 | 概要                                |
|---------------------------|-------------------------------------|
| [php](#php)               | ApacheとComposer                    |
| [mariadb](#mariadb)       | リレーショナルデータベース            |
| [phpmyadmin](#phpmyadmin) | ブラウザベースのデータベース管理ツール |
| [mailhog](#mailhog)       | メール送受信テスト用ツール            |

## php

srcフォルダ直下がドキュメントルートになります。

`http://localhost:8080`でWebサイトにアクセスできます。

### Composer

phpサービスにはcomposerが最初からインストールされています。

composerの使用方法は以下の2通りあります。

1. phpコンテナ内に入ってから任意のコマンドを実行する。

    ```sh
    docker compose exec php bash
    composer -V
    ```

2. ホスト側からexecコマンドで任意のコマンドを実行する。

    ```sh
    docker compose exec php composer -V
    ```

## mariadb

直接コマンドでデータベースを操作する場合は下記の手順でMariaDBにログイン出来ます。

1. `docker compose exec mariadb bash`を実行してmariadbコンテナに入る。
2. `mariadb -u root -p`を実行してパスワード入力画面に遷移する。
3. パスワード`root`を入力し、Enterを押してMariaDBにログインする。

### 初期データ挿入

`sql`フォルダ直下にSQLファイルを配置することで、コンテナ起動時に自動的にデータベースに初期データを挿入できます。

**使用方法:**

1. `sql`フォルダにSQLファイル(例: `init.sql`)を配置する
2. `docker compose up -d`でコンテナを起動すると、SQLファイルが自動実行される

**注意:** 初期化スクリプトはデータベースが初回作成時のみ実行されます。既存のデータベースがある場合は実行されないため、再度実行したい場合はボリュームを削除してください。

### データベース接続情報

| Key        | Value       |
|------------|-------------|
| HOST       | localhost   |
| PORT       | 3306        |
| DATABASE   | php-dev     |
| USERNAME   | root        |
| PASSWORD   | root        |

## phpmyadmin

`http://localhost:8081`でデータベースの管理画面にアクセス出来ます。

## mailhog

phpからのメール送信は全てMailhogにリダイレクトされます。

`http://localhost:8025`でメールの確認画面にアクセス出来ます。
