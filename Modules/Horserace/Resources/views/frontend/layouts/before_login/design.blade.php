<!doctype html>
<html>

<!-- Mirrored from over-the-wall.jp/oneandonly1130/about.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 30 Nov 2018 02:48:03 GMT -->
<head>
  <meta charset="utf-8">
  <title>競輪チャンネル</title>
  <meta name="format-detection" content="telephone=no">
  <meta http-equiv="content-style-type" content="text/css">
  <meta http-equiv="content-script-type" content="text/javascript">
  <meta name="Coverage" content="Japan">
  <?php $route =  Route::current()->getName()?>
  @if ($route == 'before_trans' || $route == 'before_service' || $route == 'before_privacy')
  <meta name="robots" content="noindex">
  @endif
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

  <link rel="shortcut icon"  href="{{ asset('frontend/images/channel/favicon.ico') }}?{{UPDATE}}">
  <link rel="apple-touch-icon" href="{{ asset('frontend/images/channel/apple-touch-icon.png') }}?{{UPDATE}}">
  <link rel="shortcut icon" href="{{ asset('frontend/images/channel/android-home-icon.png') }}?{{UPDATE}}">
  <!--CSS-->
  <link rel="stylesheet" type="text/css"
  href="{{ asset('frontend/css/channel/pc.css') }}?{{UPDATE}}"/>
  <link rel="stylesheet" type="text/css"
  href="{{ asset('frontend/css/channel/smp.css') }}?{{UPDATE}}"/>
  <!--CSS-->

  <!-- <link rel="stylesheet" type="text/css"
    href="{{ asset('frontend/css/custom.css') }}?{{UPDATE}}"/> -->

  @if(strpos(\Request::getRequestUri(), MEDIA_CODE_NEW_GTAG) !== false)
    <!-- Global site tag (gtag.js) - Google Ads: 625474901 --> 
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-625474901"></script> 
    <script> 
      window.dataLayer = window.dataLayer || []; 
      function gtag(){dataLayer.push(arguments);} 
      gtag('js', new Date()); 
    
      gtag('config', 'AW-625474901'); 
    </script>
  @else
    <!-- Global site tag (gtag.js) - Google Ads: 978215535 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{env('GTAG_ID')}}"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', '{{env('GTAG_ID')}}');
    </script>
  @endif
  
<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window,document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
 fbq('init', '1303381386533136'); 
fbq('track', 'PageView');
</script>
<noscript>
 <img height="1" width="1" 
src="https://www.facebook.com/tr?id=1303381386533136&ev=PageView
&noscript=1"/>
</noscript>
<!-- End Facebook Pixel Code -->

  </head>
  <body id="wrap">
    @include('horserace::frontend.layouts.before_login.header')
    <!-- main  -->
    @yield('content')
    <!-- end main -->
    <p id="page-top" style="display: block;">
    <a href="#body"><img src="{{ asset('frontend/images/channel/up.png') }}" alt="ページの一番上へ" width="60" height="60"></a>
   </p>
    <!-- footer -->
    {{--<div id="page-top" style="display:block">
      <a href="#body">
        <img src="{{ asset('frontend/images/channel/up.png') }}" alt="ページの一番上へ" width="60" height="60">
      </a>
    </div>--}}
    @include('horserace::frontend.layouts.before_login.footer')
    <!-- end footer -->
    <script type="text/javascript" src="{{ asset('frontend/js/channel/custom.js') }}?{{UPDATE}}"></script>
    <script src="{{ asset('frontend/js/channel/smartRollover.js') }}?{{ UPDATE }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/channel/slides.js') }}?{{UPDATE}}"></script>
    @yield('javascript')
  </body>

  <!-- Mirrored from over-the-wall.jp/oneandonly1130/about.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 30 Nov 2018 02:48:03 GMT -->
  </html>