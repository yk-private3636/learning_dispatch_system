# アプリケーション概要
エンジニア向けのロードマップ共有アプリ<br>
→ 詳細は随時更新予定


# 技術スタック
### フロントエンド
##### 利用者側
<img src="https://img.shields.io/badge/Vue.js-4FC08D.svg?logo=vue.js&style=flat&logoColor=white"> <img src="https://img.shields.io/badge/Vuetify-1867C0.svg?logo=Vuetify&style=flat&logoColor=white"> <img src="https://img.shields.io/badge/Inertia-9553E9.svg?logo=inertia&style=flat&logoColor=white"> <img src="https://img.shields.io/badge/Vite-646CFF.svg?logo=vite&style=flat&logoColor=white">
##### 管理者側
<img src="https://img.shields.io/badge/Vue.js-4FC08D.svg?logo=vue.js&style=flat&logoColor=white"> <img src="https://img.shields.io/badge/TypeScript-3178C6.svg?logo=typescript&style=flat&logoColor=white"> <img src="https://img.shields.io/badge/Tailwind CSS-06B6D4.svg?logo=Tailwind CSS&style=flat&logoColor=white"> <img src="https://img.shields.io/badge/Vite-646CFF.svg?logo=vite&style=flat&logoColor=white">

### バックエンド
<img src="https://img.shields.io/badge/Laravel-FF2D20.svg?logo=laravel&style=flat&logoColor=white">

### OS
<img src="https://img.shields.io/badge/Linux-FCC624.svg?logo=linux&style=flat&logoColor=white"> <img src="https://img.shields.io/badge/Debian-A81D33.svg?logo=debian&style=flat&logoColor=white">

### ミドルウェア
<img src="https://img.shields.io/badge/Apache-D22128.svg?logo=apache&style=flat&logoColor=white"> <img src="https://img.shields.io/badge/MySQL-4479A1.svg?logo=mysql&style=flat&logoColor=white"> <img src="https://img.shields.io/badge/Redis-FF4438.svg?logo=redis&style=flat&logoColor=white"> 

### インフラ(想定)
<img src="https://img.shields.io/badge/Docker-2496ED.svg?logo=docker&style=flat&logoColor=white"> <img src="https://img.shields.io/badge/GitHubActions-2088FF.svg?logo=githubactions&style=flat&logoColor=white"> <img src="https://img.shields.io/badge/AmazonEC2-FF9900.svg?logo=amazonec2&style=flat&logoColor=white"> <img src="https://img.shields.io/badge/AmazonS3-569A31.svg?logo=amazons3&style=flat&logoColor=white"> <img src="https://img.shields.io/badge/AmazonSES-DD344C.svg?logo=amazonsimpleemailservice&style=flat&logoColor=white"> <img src="https://img.shields.io/badge/AmazonRoute53-8C4FFF.svg?logo=amazonroute53&style=flat&logoColor=white">

# 環境構築
##### 前提
①Gitのインストールが完了していること <br>
②Dockerのインストールが完了していること <br>
③実行環境がWSL上であること <br>

##### 留意点
・以下ポートを使用します <br>
→ 8080: Apache <br>
→ 5173: Vite <br>
→ 3306: MySQL <br>
→ 4040: phpMyAdmin <br>
・ローカルでのメール送信は、mailtrapなどの無料で使える外部サービスやアプリケーションログに吐き出す方法で、動作確認を行う(実際の運用はAWS SES想定)<br>
・OAuth認証機能があるが、ローカルで利用する場合は、OAuth Appsを作成する必要があり。<br>
→ 参照: https://docs.github.com/ja/apps/oauth-apps/building-oauth-apps/creating-an-oauth-app <br>
※.envも編集が必要

##### 手順
①git init <br>
②git clone https://{アクセストークン}@github.com/yk-private3636/learning_dispatch_system <br>
※アクセストークンは、リポジトリ管理者経由で取得 <br>
→ 閲覧用ユーザーに対しては、参照権限のみのアクセストークンを付与 <br>
→ 作業用ユーザーに対しては、参照・書き込み権限付きのアクセストークンを付与 <br>

③cd ./learning_dispatch_system <br>
④bash ./git-hooks/setup.sh <br>
⑤docker compose up -d --bulid <br>
⑥docker exec -it bash <br>
⑦cp ./.env.example ./.env <br>
⑧composer install <br>
⑨npm install <br>
⑩php artisan key:generate <br>
⑪php artisan migrate --seed <br>
--- 立ち上げ時毎回 --- <br>
⑫nohup php artisan queue:work& <br>
⑬nohup npm run dev& <br>

--- 次回以降、立ち上げ時ルーティン --- <br>
①docker compose exec -d web php artisan queue:work <br>
②docker compose exec -d web npm run dev <br>
