# Docker PHP Development Environment

このリポジトリはPHPの開発環境をDockerで構築したものです。

phpMyAdminとMailhogが導入済みのため、それぞれブラウザからデータベースとメールを確認することが出来ます。

## 必須環境

- Docker (Docker Desktop, Docker Engine)
- Hyper-V (Windowsのみ)
- WSL2 (Windowsのみ)

※Hyper-VとWSL2はどちらか一方がセットアップされている必要があります。

## セットアップ手順

1. `git clone https://github.com/saitogo555/docker-php-dev.git`を実行してリポジトリをクローンする
2. `cd docker-php-dev`を実行してプロジェクトフォルダに移動する。
3. `docker compose up -d`を実行してコンテナを起動する。

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

composerコマンドを使用するにはphpコンテナ内で実行する必要があります。

方法は以下の2通りあります。

1. phpコンテナ内に入ってから任意のコマンドを実行する。

    ```sh
    docker compose exec php bash
    composer -V
    ```

2. ホスト側からexecコマンドで任意のコマンドを実行する。

    ```sh
    docker compose exec php composer -V
    ```

### データベース

| Key        | Value       |
|------------|-------------|
| HOST       | mariadb     |
| PORT       | 3306        |
| DATABASE   | php-dev     |
| USERNAME   | root        |
| PASSWORD   | root        |

## mariadb

phpMyAdminからデータベースの管理を行うことが出来ます。

直接コマンドでデータベースを操作する場合は下記の手順でMariaDBにログイン出来ます。

1. `docker compose exec mariadb bash`を実行してmariadbコンテナに入る。
2. `mariadb -u root -p`を実行してパスワード入力画面に遷移する。
3. パスワード`root`を入力し、Enterを押してMariaDBにログインする。

## phpmyadmin

`http://localhost:8081`でデータベースの管理画面にアクセス出来ます。

## mailhog

phpからのメール送信は全てMailhogにリダイレクトされます。

`http://localhost:8025`でメールの確認画面にアクセス出来ます。
