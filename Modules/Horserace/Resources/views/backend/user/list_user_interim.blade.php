@extends('horserace::backend.layouts.design')
@section('title' ,__("horserace::be_sidebar.list_user_interim"))
@section('content')
  <!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.list_user_interim"))
@section('breadcrumb_item')
  <li class="breadcrumb-item">
    <a href="{{ route('admin.user.interim') }}">
      {{ __("horserace::be_sidebar.user_interim") }}
    </a>
  </li>
  <li class="breadcrumb-item">{{ __("horserace::be_sidebar.list_user_interim") }}</li>
@endsection

<!-- START PAGE CONTENT-->
<div class="page-content fade-in-up">
  <div class="ibox">
    <!-- Head -->
    <div class="ibox-head">
      <div class="ibox-title">
        {{ __("horserace::be_sidebar.list_user_interim") }}
      </div>
      @if (Session::has('flash_message'))
        <div class="alert alert-{!! Session::get('flash_level') !!}">
          {!! Session::get('flash_message') !!}
        </div>
      @endif
    </div>

    <!-- List user -->
    <div class="ibox-body">
      <div class="flexbox mb-4">
        <div class="input-group-icon input-group-icon-left mr-3">
          <span class="input-icon input-icon-right font-16"><i class="ti-search"></i></span>
          <input class="form-control form-control-rounded form-control-solid" id="key-search" type="text"
                 placeholder="{{ __("horserace::be_form.placeholder_search") }}">
        </div>

      </div>
      <form action="{{ route("admin.user_interim.delete") }}" method="POST">
        {{ csrf_field() }}

        <div class="table-responsive row">
          <table class="table table-bordered table-hover" id="dataAjax">
            <thead class="thead-default thead-lg">
            <tr>
              <th>{{ __("horserace::be_form.login_id") }}</th>
              <th>{{ __("horserace::be_form.mail_pc") }}</th>
              <th>{{ __("horserace::be_form.ip") }}</th>
              <th>{{ __("horserace::be_form.interim_register_time") }}</th>
              <th>{{ __("horserace::be_form.deleted") }}</th>
            </tr>
            </thead>
            <tbody>
            {{-- @foreach ($data['user'] as $item)
              <tr>
                <td>
                  {{ $item->login_id }}
                </td>
                <td>{{ $item->mail_pc }}</td>
                <td>{{ $item->ip }}</td>
                <td>{{ $item->interim_register_time }}</td>
                <td>
                  <label class="checkbox">
                    <input type="checkbox" name="deleted[{{$item->user_id}}]" value="{{$item->user_id}}">
                    <span class="input-span"></span>
                    {{ __("horserace::be_form.deleted") }}
                  </label>
                </td>
              </tr>
            @endforeach --}}
            </tbody>
          </table>
        </div>
        <button class="btn btn-danger" type="submit">
          {{ __("horserace::be_form.btn_deleted") }}
        </button>
      </form>
    </div>

    <div class="ibox-footer">
      <div class="row">
        <div class="col-md-3">
          <a class="btn btn-secondary" href="{{ route('admin.user.interim')}}">
            {{ __("horserace::be_form.btn_back") }}
          </a>
        </div>
        <div class="col-md-3">
          <!-- Send bulk -->
          <form method="POST" action="{{ route("admin.mail_bulk.add") }}">
          {{ csrf_field() }}
          <!-- Condition -->
            <input type="hidden" name="condition" value="{{ $data["condition"] }}">
            <button class="btn btn-primary" type="submit">
              {{ __("horserace::be_form.btn_send_mail_bulk_user_interim") }}
            </button>
          </form>
        </div>
        <!-- <div class="col-md-3"> -->
          <!-- Export csv -->
          <!-- <form method="GET" action="{{ route("admin.user_interim.export_csv") }}"> -->
          <!-- {{ csrf_field() }} -->
          <!-- Condition -->
            <!-- <input type="hidden" name="condition" value="{{ $data["condition"] }}"> -->
            <!-- <button class="btn btn-info" type="submit"> -->
              <!-- {{ __("horserace::be_form.btn_export_user") }} -->
            <!-- </button> -->
          <!-- </form> -->
        <!-- </div> -->
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
        "sAjaxSource": "{{ route('admin.user_interim.search.post.ajax') }}",
        "iDisplayLength": 20,
        "aaSorting": [0, "desc" ],
        "aoColumns": [
          { "sName": "login_id"},
          { "sName": "mail_pc"},
          { "sName": "ip"},
          { "sName": "interim_register_time"},
          { "sName": "deleted"},
        ],
        "fnServerParams": function ( aoData ) {
          aoData.push({ "name": "mail_pc", "value": "{{ json_decode($data["condition"])->mail_pc }}" } );
          aoData.push({ "name": "interim_register_time_start", "value": "{{ json_decode($data["condition"])->interim_register_time_start }}" } );
          aoData.push({ "name": "interim_register_time_end", "value": "{{ json_decode($data["condition"])->interim_register_time_end }}" } );
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
      $('#type-filter').on('change', function () {
        table.column(2).search($(this).val()).draw();
      });
    });
  </script>
@endsection