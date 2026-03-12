# 図書管理システム
<img width="1919" height="1073" alt="8_books_id" src="https://github.com/user-attachments/assets/8ff63444-a374-481b-9833-167413d643f7" />

Laravel を用いて開発した図書管理 Web アプリケーションです。  
図書の貸出・返却管理、レビュー投稿、評価ランキングなどの機能を備えています。

チーム開発で作成し、実際の図書管理業務を想定したシステムとして設計しました。

## システム設計・開発報告資料

-   [システム概要資料](docs/1_開発報告資料.pdf)
-   [テーブル定義書](docs/2_テーブル定義書.pdf)
-   [画面遷移図](docs/3_画面遷移図.pdf)
-   [ユースケース図](docs/4_ユースケース図.pdf)

---

# 主な機能

## 認証

## 管理者機能
<img width="1920" height="1076" alt="2_top_admin" src="https://github.com/user-attachments/assets/2488aba9-b1aa-4b2f-8cfa-e8fc07d6e0e9" />

-   貸出・返却処理
-   督促通知
-   ユーザー管理（登録・編集・削除）
-   書籍管理（登録・編集・廃棄）
-   カテゴリー管理
-   システム共通設定（メール情報・会社情報・運用表示設定）

## 利用者機能
<img width="1913" height="1069" alt="16_top_customer" src="https://github.com/user-attachments/assets/e2821f16-9ad1-457b-8673-5c628e8fa99b" />

-   書籍検索
-   書籍詳細閲覧
-   レビュー投稿
-   評価ランキング表示
-   貸出履歴確認

---

# 担当機能

本プロジェクトでは以下の機能を担当しました。

### 貸出・返却処理
図書の貸出受付を行い、貸出日・返却期限を管理する機能を実装。
貸出された図書の返却受付を行い、貸出ステータスを更新する機能を実装。
<img width="1917" height="1074" alt="3_loan_checkout" src="https://github.com/user-attachments/assets/66bafc8a-bb27-4f0a-bfaa-ac2641b5a9a4" />

### 貸出状況一覧
貸出状況一覧を表示し、貸出日、貸出ステータスなどで検索できる画面を作成。
<img width="1906" height="1074" alt="5_loan_status" src="https://github.com/user-attachments/assets/c47c54ee-c263-4ecd-ace9-41ea2045ad12" />

### 督促通知機能
返却期限を超過した貸出を一覧で表示し、利用者へ督促通知をメール送信する機能を実装。
<img width="788" height="602" alt="スクリーンショット 2026-03-12 23 34 27" src="https://github.com/user-attachments/assets/42f8daa5-d0f0-4e0b-9faa-97c02df319ec" />

### サイドバー

管理画面のサイドバーを実装し、各管理機能へのナビゲーションを整理。

---

# 画面イメージ

## 認証

-   [login](docs/screen/1_login.png)

## 管理者機能

-   [top](docs/screen/2_top_admin.png)

-   [loan/checkout](docs/screen/3_loan_checkout.png)
-   [loan/checkin](docs/screen/4_loan_checkin.png)
-   [loan/status](docs/screen/5_loan_status.png)
-   [loan/overdue](docs/screen/6_loan_overdue.png)

-   [books](docs/screen/7_books.png)
-   [books/id](docs/screen/8_books_id.png)
-   [books/id/stocks](docs/screen/9_books_id_stocks.png)
-   [books/create](docs/screen/10_books_create.png)
-   [books/id/edit](docs/screen/11_books_id_edit.png)

-   [categories](docs/screen/12_categories.png)
-   [categories/create](docs/screen/13_categories_create.png)

-   [configs](docs/screen/14_configs.png)
-   [configs/edit](docs/screen/15_configs_edit.png)

## 利用者機能

-   [top](docs/screen/16_top_customer.png)
-   [loan-history](docs/screen/17_loan_history.png)
-   [evaluations](docs/screen/18_evaluations.png)
-   [evaluations/ranking](docs/screen/19_evaluations_ranking.png)

---

# 使用技術

## バックエンド

-   PHP

## フレームワーク

-   Laravel 　 Livewire 利用

## フロントエンド

-   Blade
-   Tailwind CSS
-   JavaScript

## データベース

-   MySQL

## 開発環境

-   XAMPP

## バージョン管理

-   Git

---

# 工夫した点

### Livewire を使用した動的 UI

Livewire を使用することで、検索時のリアクティブな UI を実装しました。

### 貸出管理ロジック

貸出・返却状態を管理し、貸出状況一覧画面で現在の貸出状態を確認できるようにしました。

### 督促通知機能

返却期限を超過した利用者へ通知する機能を実装し、図書管理業務を支援できるようにしました。

---
