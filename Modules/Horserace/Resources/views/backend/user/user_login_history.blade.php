@extends('horserace::backend.layouts.design')
@section('title' ,__("horserace::be_sidebar.list_user_login_history"))
@section('content')

  <!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.list_user_login_history"))
@section('breadcrumb_item')
  <li class="breadcrumb-item">
    <a href="{{ route('admin.user.search_login_history') }}">
      {{ __("horserace::be_sidebar.search_user_login_history") }}
    </a>
  </li>
  <li class="breadcrumb-item">{{ __("horserace::be_sidebar.list_user_login_history") }}</li>
@endsection

<!-- START PAGE CONTENT-->
<div class="page-content fade-in-up">
  <div class="ibox">
    <!-- Head -->
    <div class="ibox-head">
      <div class="ibox-title">
        {{ __("horserace::be_sidebar.list_user_login_history") }}
      </div>
      @if (Session::has('flash_message'))
        <div class="alert alert-{!! Session::get('flash_level') !!}">
          {!! Session::get('flash_message') !!}
        </div>
      @endif
    </div>

    <!-- List user -->
    <div class="ibox-body">
      {{--<div class="flexbox mb-4">--}}
      {{--<div class="input-group-icon input-group-icon-left mr-3">--}}
      {{--<span class="input-icon input-icon-right font-16"><i class="ti-search"></i></span>--}}
      {{--<input class="form-control form-control-rounded form-control-solid" id="key-search" type="text"--}}
      {{--placeholder="{{ __("horserace::be_form.placeholder_search") }}">--}}
      {{--</div>--}}

      {{--</div>--}}
      <div class="table-responsive row">
        <table class="table table-bordered table-hover" id="dataAjax">
          <thead class="thead-default thead-lg">
          <tr>
            <th></th>
            <th>{{ __("horserace::be_form.login_id") }}</th>
            <th>{{ __("horserace::be_form.login_time") }}</th>
            <th>{{ __("horserace::be_form.number_login") }}</th>
          </tr>
          </thead>
          <tbody>
          {{-- @foreach ($data['history'] as $item)
            <tr>
              <td width="5">{{ $item->id }}</td>
              <td>
                <a class="text-blue"
                   href="{{ route('admin.user.edit',$item->user_id ) }}">
                  {{ $item->login_id }}
                </a>
              </td>
              <td>{{ date("Y-m-d", strtotime($item->login_date)) }}</td>
              <td>{{ number_format($item->login_number) }}</td>
            </tr>
          @endforeach --}}
          </tbody>
        </table>
      </div>
    </div>

    <div class="ibox-footer">
      <div class="row">
        <div class="col-md-3">
          <a class="btn btn-secondary" href="{{ route('admin.user.search_login_history')}}">
            {{ __("horserace::be_form.btn_back") }}
          </a>
        </div>

      </div>
    </div>
  </div>
</div>
<!-- END PAGE CONTENT-->
@endsection
@section('javascript')
  <script>
    $(function () {
      var table = $('#dataAjax').DataTable({
        "scrollX": "1200px",
        "bProcessing": true,
        "bServerSide": true,
        "searching": false,
        "sPaginationType": "full_numbers",
        "sAjaxSource": "{{ route('admin.user.login_history.ajax') }}",
        "iDisplayLength": 20,
        "aoColumns": [
          { "sName": "id", "bSortable": false},
          { "sName": "login_id", "bSortable": false},
          { "sName": "login_time", "bSortable": false},
          { "sName": "number_login", "bSortable": false},
        ],
        "fnServerParams": function ( aoData ) {
          aoData.push({ "name": "login_id", "value": "{{ $data["search"]["login_id"] }}" } );
          aoData.push({ "name": "login_time_start", "value": "{{ $data["search"]["login_time_start"] }}" } );
          aoData.push({ "name": "login_time_end", "value": "{{ $data["search"]["login_time_end"] }}" } );
        },
        language: {
          paginate: {
              first: '<<',
              previous: '前',
              next:     '次',
              last: '>>',
          },
          zeroRecords: "データはありません。",
        }
      });
      $('#key-search').keypress(function(event) {
        if (event.key === "Enter") {
          table.draw();
        }
      });
    });
  </script>
@endsection