@extends('horserace::frontend.layouts.design')
@section('title','Docomo Mail')
@section('content')

<div id="contents">
    <div class="title">※重要※docomoのアドレスをご利用の会員様へ</div>

    <div id="txt-area">
        <p class="imap">「IMAP専用パスワード」について</p>

        <p><span style="color:#ff0000;font-weight:bold;">設定をしないと、ドコモメールの送受信が出来なくなってしまう</span>ため、ご面倒ですが設定をお願い致します。</p>

        <p>IMAP専用パスワードを設定することで、iPhone・iPadの標準メールアプリやIMAPに対応しているサードパーティのメールアプリでのメールサーバーへの接続が本パスワードでのみ可能となるため、より<span
                style="color:#ff0000;">安全にドコモメールをご利用いただくことができます</span>。<br>
            システム生成のランダム文字列によって構成されたパスワードのため、第三者に予測されにくく、<span style="color:#ff0000;">不正アクセス対策などに有効</span>です。</p>

        <br>
        <img src="{{ asset('frontend/images/channel/login/docomo_imap.gif') }}"><br>
        <br>

        <p>今回の経緯について詳細は下記ドコモページをご覧ください。<br>
            <a href="https://www.nttdocomo.co.jp/info/notice/pages/181211_00.html" target="_blank"
                rel="noopener noreferrer" style="text-decoration:underline;">≫セキュリティ強化に伴うドコモメールの設定変更のお願い</a></p>

        <br>
        <p class="imap">設定が必要な方</p>
        <p>iPhone・iPad標準メールアプリやSIMフリースマホなどのIMAP対応メールアプリをご利用の方は設定が必要です。</p>
        <p style="color:#ff0000;">※Androidのドコモ標準メールアプリ、SPモードメールアプリ、ブラウザ版は非対応のため、設定の必要はありません。</p>

        <br>
        <p class="imap">注意事項</p>

        <p>wi-fi環境では接続ができないため、<span style="color:#ff0000;">wi-fiは切断し3G/LTE(docomoのモバイルネットワーク)回線</span>にてお手続きをお願いします。</p>
        <p><span style="color:#ff0000;">一度設定を始めると設定完了まではドコモメールが送受信できなくなります。</span><br>
            メールのやり取りがない時間帯での設定をおすすめ致します。(設定は数分で終わります)</p>

        <p>IMAP専用パスワードを発行後、必ずご利用いただいているアプリ・サービスの設定を変更してください。<br>
            <span style="color:#ff0000;">変更されないまま一定時間経過しますと、dアカウントがロック</span>されます。</p>

        <br>
        <p class="imap">iPhoneでの設定方法</p>

        <p>1.マイドコモ(お客様サポート)<a href="https://www.nttdocomo.co.jp/mydocomo/" target="_blank" rel="noopener noreferrer"
                style="text-decoration:underline;">https://www.nttdocomo.co.jp/mydocomo/</a>にアクセスし、dアカウントでログインします。</p>
        <br>
        <p>2.「設定」から「メール設定」をタップし、「メール設定」へ進みます。</p>
        <br>
        <img src="{{ asset('frontend/images/channel/login/iphone_01.png') }}"><br>
        <br>
        <p>3.「メール設定」画面から「IMAP用ID・パスワードの確認」を選択し、パスワード確認画面で『spモードパスワード』を入力・確認します。</p>
        <p>&nbsp;</p>
        <img src="{{ asset('frontend/images/channel/login/iphone_02.png') }}"><br>
        <br>
        <p>4.「IMAP用ID・パスワードの確認」画面で設定状況が確認できます。赤枠の項目名でIMAP用のパスワードが設定されているか確認することができます。</p>
        <p><span style="color:#ff0000;">未設定の場合→パスワード<br>
                設定済みの場合→IMAP専用パスワード</span></p>
        <p>未設定の場合は下にスクロールし「IMAP専用パスワード新規発行」をタップします。</p>
        <p>&nbsp;</p>
        <img src="{{ asset('frontend/images/channel/login/iphone_03.png') }}"><br>

        <br>
        <p>5.「設定を確定する」、「次へ」をタップします。</p>
        <p>&nbsp;</p>
        <img src="{{ asset('frontend/images/channel/login/iphone_04.png') }}"><br>
        <br>
        <p>6.ネットワーク暗証番号を入力して「次へ進む」をタップします。</p>
        <p>&nbsp;</p>
        <img src="{{ asset('frontend/images/channel/login/iphone_05.png') }}"><br>
        <br>
        <p>7.設定するドコモのメールアドレス(@docomo.ne.jp)および注意事項を確認したら「次へ」をタップします。<br>
            プロファイル表示の確認画面が表示されるので「許可」をタップして、プロファイルのインストール画面を表示します。</p>
        <p>&nbsp;</p>
        <img src="{{ asset('frontend/images/channel/login/iphone_06.png') }}"><br>
        <br>
        <p>8.「iPhone利用設定」プロファイルのインストール画面から「インストール」をタップして、「ドコモメール(@docomo.ne.jp)」「メッセージR/S」を設定するためのプロファイルをインストールします。</p>
        <p>&nbsp;</p>
        <img src="{{ asset('frontend/images/channel/login/iphone_07.png') }}"><br>
        <br>
        <p>9.プロファイルのインストールが完了したら「完了」をタップして、iPhoneでのドコモメールの利用設定は完了です。</p>
        <p>&nbsp;</p>
        <img src="{{ asset('frontend/images/channel/login/iphone_08.png') }}"><br>
        <br>
        <p>10.標準の「メール」アプリで「ドコモメール(@docomo.ne.jp)」の送受信が可能になります。</p>

        <p>設定を確認するには、手順4の「メール設定」画面にいきます。<br>
            一番下の項目が「パスワード」から「IMAP専用パスワード」に変わっていれば設定は正常に完了しています。</p>
        <br>

        <p>※必ず<span style="color:#ff0000;">IMAP専用パスワードを発行～プロファイルのインストールまでを一気に完了</span>させてください。<br>
            <span style="color:#ff0000;">変更されないまま一定時間経過しますと、dアカウントがロック</span>されます。</p>

        <br>
        <p class="imap">サードパーティのメールアプリでご利用の方</p>

        <p>ドコモ提供以外の3rdパーティのメールアプリご利用の方は、下記手順にてIMAP専用パスワード発行後、ご利用のアプリにIMAP専用パスワードを設定してください。</p>

        <p>1.マイドコモにログインし、「メール設定（迷惑メール・SMS対策など）」をタップし、spモードパスワードを入力して「認証する」をタップします。</p>
        <p>&nbsp;</p>
        <img src="{{ asset('frontend/images/channel/login/3rd_01.png') }}"><br>
        <br>
        <p>2.「IMAP用ID・パスワードの確認」をタップし、「IMAP専用パスワード新規発行」をタップします。</p>
        <p>&nbsp;</p>
        <img src="{{ asset('frontend/images/channel/login/3rd_02.png') }}"><br>
        <br>
        <p>3.「設定を確定する」をタップし、「IMAP用ID・パスワードの確認」をタップして内容をご確認ください。</p>
        <p>&nbsp;</p>
        <img src="{{ asset('frontend/images/channel/login/3rd_03.png') }}"><br>
        <br>
        <p>4.IMAP専用パスワードをご利用のアプリに設定してください。<br>
            設定方法は、以下から「Androidスマートフォンアプリでの設定方法」をご確認ください。</p>

        <p><a href="https://www.nttdocomo.co.jp/service/docomo_mail/other/#p02" target="_blank"
                rel="noopener noreferrer" style="text-decoration:underline;">≫その他のメールアプリからのご利用</a></p>

        <p><span style="color:#ff0000;">※IMAP専用パスワードを発行後、必ずご利用いただいているアプリ・サービスの設定を変更</span>してください。<br>
            <span style="color:#ff0000;">変更されないまま一定時間経過しますと、dアカウントがロック</span>されます。</p>

        <br>
    </div>

</div>
@endsection