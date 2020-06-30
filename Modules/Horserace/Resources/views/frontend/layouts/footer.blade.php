<!--Footer-->
{{--<div id="footer">
  <div class="footer-area">
    <ul id="footer-menu">
      <li><a href="{{route('mypage')}}">マイページ</a></li>
<li><a href="{{route('point')}}">ポイント購入</a></li>
<li><a href="{{route('mail_box')}} ">メールBOX</a></li>
<li><a href="{{route('result')}} ">的中実績</a></li>
<li><a href="{{route('free')}} ">今日の無料予想</a></li>
<li><a href="{{route('agree')}} ">ご利用規約</a></li>
<li><a href="{{route('privacy')}} ">プライバシーポリシー</a></li>
<li><a href="{{route('trans')}} ">特定商取引</a></li>
<li><a href="{{route('contact')}} ">お問い合わせ</a></li>
</ul>
<div class="clearfix fade">
    <div class="footer-logo">
        <a href="{{route('home')}}">
            <img src="{{ asset('frontend/images/channel/login/logo.png') }}" width="311" height="108">
        </a>
    </div>
    <div class="footer-com">
        ・勝者投票券（以下「車券」という。）の購入は個人の責任において行ってください。<br>
        ・自転車競技法により、20歳未満の未成年者は車券を購入し、又は譲り受ける事 は禁止されております。<br>
        ・弊社の情報料はあくまでも分析的調査費用であり、的中を保証するものではありません。<br>
        ・弊社の情報利用により生じたいかなる損害について、一切の責任は負いかねますのでご了承下さい。<br>
    </div>
</div>
<address>&copy; <script type="text/javascript">
    myDate = new Date();
    myYear = myDate.getFullYear();
    document.write(myYear);
    </script> 競輪チャンネル All Rights Reserved.</address>
</div>
</div>
<!--Footer-->--}}




<!--Footer-->
<p id="page-top"><a href="#body"><img src="{{ asset('frontend/images/channel/login/up.png')}}" alt="ページの一番上へ" width="60"
            height="60" /></a></p>
<div id="footer">
    <div class="footer-area">
        <ul id="footer-menu">
            <li><a href="{{route('home')}}">トップページ</a></li>
            <li><a href="{{route('agree')}}">ご利用規約</a></li>
            <li><a href="{{route('privacy')}}">プライバシーポリシー</a></li>
            <li><a href="{{route('trans')}}">特定商取引</a></li>
            <li><a href="{{route('contact')}}">お問い合わせ</a></li>
        </ul>
        @yield('docomomail')

        <div class="clearfix">
            <div class="footer-logo"><img src="{{ asset('frontend/images/channel/login/logo.png') }}" width="350"
                    height="108"></div>
            <div class="footer-com">
                ・勝者投票券（以下「車券」という。）の購入は個人の責任において行ってください。<br>
                ・自転車競走により、20歳未満の未成年者は車券を購入し、又は譲り受ける事 は禁止されております。<br>
                ・弊社提供の買い目情報やキャンペーン情報の内容は100%の的中や払い戻し金を保障するものではありません。<br>
                ・弊社の情報利用により生じたいかなる損害について、一切の責任は負いかねますのでご了承下さい。<br>
            </div>
        </div>
        <address>&copy; <script type="text/javascript">
            myDate = new Date();
            myYear = myDate.getFullYear();
            document.write(myYear);
            </script> 競輪チャンネル All Rights Reserved.</address>
    </div>
</div>
<!--Footer-->

</div>
<nav class="pc-none">
    <ul class="fclearfix">

        <a href="{{route('home')}}">
            <li><img src="{{ asset('frontend/images/channel/login/icon1.svg')}}" />
                <p>トップページ</p>
            </li>
        </a>
        <a href="{{route('point')}}">
            <li><img src="{{ asset('frontend/images/channel/login/icon2.svg')}}" />
                <p>チップ購入</p>
            </li>
        </a>
        <a href="{{route('mail_box')}}">
            <li><img src="{{ asset('frontend/images/channel/login/icon3.svg')}}" />
                <p>メールBOX</p>
            </li>
        </a>
        <a href="{{route('about')}}">
            <li><img src="{{ asset('frontend/images/channel/login/icon4.svg')}}" />
                <p>必勝ガイド</p>
            </li>
        </a>
        <a href="{{route('course')}}">
            <li><img src="{{ asset('frontend/images/channel/login/icon5.svg')}}" />
                <p>コース一覧</p>
            </li>
        </a>
        <a href="{{route('result')}}">
            <li><img src="{{ asset('frontend/images/channel/login/icon6.svg')}}" />
                <p>的中実績</p>
            </li>
        </a>
        <a href="{{route('voice')}}">
            <li><img src="{{ asset('frontend/images/channel/login/icon7.svg')}}" />
                <p>感謝の声</p>
            </li>
        </a>
        <a href="{{route('mypage')}}">
            <li><img src="{{ asset('frontend/images/channel/login/icon8.svg')}}" />
                <p>マイページ</p>
            </li>
        </a>
        <a href="{{route('contact')}}">
            <li><img src="{{ asset('frontend/images/channel/login/icon9.svg')}}" />
                <p>お問い合わせ</p>
            </li>
        </a>
        <a href="{{route('agree')}}">
            <li><img src="{{ asset('frontend/images/channel/login/icon10.svg')}}" />
                <p>ご利用規約</p>
            </li>
        </a>
        <a href="{{route('privacy')}}">
            <li><img src="{{ asset('frontend/images/channel/login/icon11.svg')}}" />
                <p>プライバシーポリシー</p>
            </li>
        </a>
        <a href="{{route('trans')}}">
            <li><img src="{{ asset('frontend/images/channel/login/icon12.svg')}}" />
                <p>特定商取引</p>
            </li>
        </a>

    </ul>
</nav>