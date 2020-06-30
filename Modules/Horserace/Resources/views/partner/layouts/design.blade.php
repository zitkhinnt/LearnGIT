<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width initial-scale=1.0">
  <title>Partner - @yield('title')</title>
  <!-- GLOBAL MAINLY STYLES-->
  <link href="{{ asset('backend/lib/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet"/>
  <link href="{{ asset('backend/lib/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet"/>
  <link href="{{ asset('backend/lib/line-awesome/css/line-awesome.min.css') }}" rel="stylesheet"/>
  <link href="{{ asset('backend/lib/themify-icons/css/themify-icons.css') }}" rel="stylesheet"/>
  <link href="{{ asset('backend/lib/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet"/>
  <!-- PLUGINS STYLES-->
  <link href="{{ asset('backend/lib/dataTable-new/jquery.dataTables.min.css') }}" rel="stylesheet"/>
  <link href="{{ asset('backend/lib/dataTable-new/fixedColumns.dataTables.min.css') }}" rel="stylesheet"/>
  <link href="{{ asset('backend/lib/summernote/dist/summernote.css') }}" rel="stylesheet"/>
  <link href="{{ asset('backend/lib/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css') }}"
        rel="stylesheet"/>
  <!-- datetimepicker bootstrap 4 -->
  <link href="{{ asset('backend/lib/bootstrap-datetimepicker/dist/css/bootstrap-datetimepicker.min.css') }}"
        rel="stylesheet"/>

  <!-- PLUGINS STYLES-->
  <link href="{{ asset('backend/lib/fullcalendar/dist/fullcalendar.min.css') }}" rel="stylesheet"/>
  <link href="{{ asset('backend/lib/fullcalendar/dist/fullcalendar.print.min.css') }}" rel="stylesheet"
        media="print"/>
  <!-- THEME STYLES-->
  <link href="{{ asset('backend/css/main.min.css') }}" rel="stylesheet"/>
  <link href="{{ asset('backend/css/custom.css') }}" rel="stylesheet"/>
  <!-- PAGE LEVEL STYLES-->
  <script src="{{ asset('backend/lib/jquery/dist/jquery.min.js') }}"></script>

</head>

<body class="fixed-navbar">
<div class="page-wrapper">
  <!-- START HEADER-->
@include('horserace::partner.layouts.header')
<!-- END HEADER-->
  <!-- START SIDEBAR-->
@include('horserace::partner.layouts.sidebar')
<!-- END SIDEBAR-->
  <div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <!-- breadcumb start -->
    <div class="page-heading">
      <h1 class="page-title">@yield('page_title')</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ route('admin.dashboard') }}"><i class="la la-home font-20"></i></a>
        </li>
        @yield('breadcrumb_item')
      </ol>
    </div>


  @yield('content')
  <!-- END PAGE CONTENT-->
    @include('horserace::partner.layouts.footer')
  </div>
</div>
<!-- BEGIN PAGA BACKDROPS-->
<div class="sidenav-backdrop backdrop"></div>
<div class="preloader-backdrop">
  <div class="page-preloader">{{ __("horserace::be_form.loading") }}</div>
</div>
<!-- END PAGA BACKDROPS-->
<!-- CORE PLUGINS-->
<script src="{{ asset('backend/lib/popper.js/dist/umd/popper.min.js') }}"></script>
<script src="{{ asset('backend/lib/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('backend/lib/metisMenu/dist/metisMenu.min.js') }}"></script>
<script src="{{ asset('backend/lib/jquery-validation/dist/jquery.validate.min.js') }}"></script>
<script src="{{ asset('backend/lib/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('backend/lib/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('backend/lib/bootstrap-datepicker/bootstrap-datepicker.ja.min.js') }}"></script>
<!-- datetimepicker bootstrap 4 -->
<script src="{{ asset('backend/lib/bootstrap-datetimepicker/dist/moment.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/lib/bootstrap-datetimepicker/dist/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('backend/lib/bootstrap-datetimepicker/dist/ja.js') }}"></script>

<!-- PAGE LEVEL PLUGINS-->
<script src="{{ asset('backend/lib/chart.js/dist/Chart.min.js') }}"></script>
<script src="{{ asset('backend/lib/summernote/dist/summernote.min.js') }}"></script>
<script src="{{ asset('backend/lib/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('backend/lib/fullcalendar/dist/fullcalendar.min.js') }}"></script>
<script src="{{ asset('backend/lib/dataTable-new/jquery.dataTables.min.js') }} "></script>
<script src="{{ asset('backend/lib/dataTable-new/dataTables.fixedColumns.min.js') }} "></script>
<!-- CORE SCRIPTS-->
<script src="{{ asset('backend/js/app.min.js') }}"></script>
<!-- PAGE LEVEL SCRIPTS-->
<script src="{{ asset('backend/js/custom.js') }}"></script>
@yield('javascript')
</body>

</html>
