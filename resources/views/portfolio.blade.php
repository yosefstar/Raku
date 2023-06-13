<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>ポート</title>
    <style>
        h2 {
            font-size: smaller;
        }

        .ranking-container {
            display: flex;
            /* フレキシブルボックスを使用 */
        }

        .ranking-want,
        .ranking-have {
            flex: 1;
            /* 要素の幅を均等に分配 */
            margin-left: 10px;
            /* 要素間の余白を調整（必要に応じて調整） */
        }

        .custom-h1,
        .custom-p {
            padding-left: 25px;
        }
    </style>
</head>

<body>
    <h1 class="custom-h1">ランキング</h1>
    <div class="ranking-container">
        <div class="ranking-want">
            <h1>楽天商品の投票アプリ</h1>
            <a href="http://rakuranking.conohawing.com/">http://rakuranking.conohawing.com/</a>
            <h3>ログイン情報</h3>
            <p>メール: test@gmail.com</p>
            <p>パスワード: testuser1212</p>

            <h3>仕様解説動画</h3>
            <a href="https://youtu.be/LS9VgcS9JKc">https://youtu.be/LS9VgcS9JKc</a>
            <h3>イメージ画像</h3>
            <img src="{{ asset('images/main1.png') }}" width="400" height="300">





            <h3>使用言語</h3>
            <ul>
                <li>PHP 8.2.5</li>
                <li>JavaScript</li>
                <li>SQL</li>
                <li>HTML</li>
                <li>CSS</li>
            </ul>

            <h3>DB</h3>
            <ul>
                <li>MySql</li>
            </ul>

            <h3>サーバー</h3>
            <ul>
                <li>CentOS</li>
            </ul>

            <h3>FW・MW・ツール等</h3>
            <ul>
                <li>Laravel</li>
                <li>git</li>
                <li>jQuery</li>
            </ul>

            <h3>機能紹介</h3>
            <ul>
                <li>ユーザー登録、ログイン認証機能</li>
                <li>楽天市場の商品検索</li>
                <li>Want, Have された商品の一覧表示</li>
                <li>Want, Have された商品の数でランキング表示</li>
                <li>楽天 API を使用したカテゴリー分類</li>
                <li>商品の除外機能</li>
                <li>JavaScript の Fetch 関数を利用した非同期通信</li>
            </ul>

            <h3>苦労した点</h3>
            <ul>
                <li>DBのテーブルへの処理</li>
                <li>非同期通信</li>
            </ul>
        </div>

        <div class="ranking-have">
            <h1>フリマ在庫判定スクレイピングアプリ</h1>
            <a href="http://49.212.209.113:5001/">http://49.212.209.113:5001/</a>
            <h3>ログイン情報</h3>
            <p>ログインなし</p>


            <h3>仕様解説動画</h3>
            <a href="https://youtu.be/522TOH7Fy1U">https://youtu.be/522TOH7Fy1U</a>
            <h3>イメージ画像</h3>
            <img src="{{ asset('images/main2.png') }}" width="430" height="300">

            <h3>使用言語</h3>
            <ul>
                <li>Python 3.10.11</li>
                <li>JavaScript</li>
                <li>SQL</li>
                <li>HTML</li>
                <li>CSS</li>
            </ul>

            <h3>DB</h3>
            <ul>
                <li>MySql</li>
            </ul>

            <h3>サーバー</h3>
            <ul>
                <li>Ubuntu</li>
            </ul>

            <h3>FW・MW・ツール等</h3>
            <ul>
                <li>Flask</li>
                <li>WebDriver</li>
                <li>git</li>
                <li>jQuery</li>
            </ul>

            <h3>機能紹介</h3>
            <ul>
                <li>csv読み込み</li>
                <li>csv内のリンクをスクレイピング</li>
                <li>WebDriverを仕様して、動的Htmlサイトに対応</li>
                <li>JavaScriptを用いたカウントダウン機能</li>
            </ul>

            <h3>苦労した点</h3>
            <ul>
                <li>フリマサイトが動的なhtmlのため、WebDriverを用いたスクレイピングをする必要があったこと</li>
            </ul>
        </div>
    </div>
</body>

</html>