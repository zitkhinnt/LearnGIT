@extends('horserace::backend.layouts.design')
@section('title',__('horserace::be_sidebar.list_mail_contact'))
@section('content')

@section('page_title', __('horserace::be_sidebar.list_mail_contact'))
@section('breadcrumb_item')
    <li class="breadcrumb-item">{{ __('horserace::be_sidebar.list_mail_contact') }}</li>
@endsection
<style>
  .modal-dialog{
    max-width: 1000px !important;
  }
</style>
<div class="page-content fade-in-up">
    <div class="ibox">

      <div class="ibox-head">
        <div class="ibox-title">
          {{ __('horserace::be_sidebar.list_mail_contact') }}
        </div>
      </div>

      <div class="ibox-body">
        @if (Session::has('flash_message'))
          <div class="alert alert-{!! Session::get('flash_level') !!}">
            {!! Session::get('flash_message') !!}
          </div>
      @endif

      <!-- Search -->
        <div class="flexbox mb-4">
          <div class="input-group-icon input-group-icon-left mr-3">
            <span class="input-icon input-icon-right font-16"><i class="ti-search"></i></span>
            <input class="form-control form-control-rounded form-control-solid" id="key-search" type="text"
                   placeholder="{{  __('horserace::be_form.search') }}">
          </div>
        </div>
        <!-- List mail bulk -->
        <div class="table-responsive row">
          <table class="table table-bordered table-hover" id="dataAjax">
            <thead class="thead-default thead-lg">
            <tr>
              <th width="10%">{{ __('horserace::be_form.send_time') }}</th>
              <th width="5%">{{ __('horserace::be_form.send_id') }}</th>
              <th width="15%">{{ __('horserace::be_form.title') }}</th>
              <th>{{ __('horserace::be_form.mail_body') }}</th>      
            </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
      </div>
    </div>
</div>

<div id="modalBodyMail" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{ __('horserace::be_form.mail_body') }}</h5>
      </div>
      <div id="mail-body" class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('horserace::be_form.btn_close') }}</button>
      </div>
    </div>

  </div>
</div>

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
      "sAjaxSource": "{{ route('admin.list.mail.contact.ajax') }}",
      "iDisplayLength": 20,
      "bSort" : false,
      "aoColumns": [
        { "sName": "send_time"},
        { "sName": "send_id" },
        { "sName": "title" },
        { "sName": "mail_body"},
      ],
      "fnServerParams": function ( aoData ) {
        aoData.push({ "name": "key_search", "value": $('#key-search').val() } );
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

$('.body-msg').on('click', function(){
    var mail_body = $(this).attr('data-body');
    console.log('111');
    $('#mail-body').html(mail_body);
});
$(document).on('click', 'a.body-msg', function () {
  console.log('222');
      $('#mail-body').html($(this).attr('data-body'));
    });
</script>
@endsection