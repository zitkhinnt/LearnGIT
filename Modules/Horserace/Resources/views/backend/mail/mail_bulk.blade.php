@extends('horserace::backend.layouts.design')
@section('title', __('horserace::be_sidebar.mail_bulk'))
@section('content')
  <div class="page-content fade-in-up">
    <div class="ibox">

      <div class="ibox-head">
        <div class="ibox-title">
          {{ __('horserace::be_sidebar.mail_bulk') }}
        </div>
        <div class="ibox-title text-right">
          {{--<a href="{{ route("admin.mail_bulk.add") }}">--}}
          {{--<button class="btn btn-primary">--}}
          {{--{{ __('horserace::be_form.add_new') }}--}}
          {{--</button>--}}
          {{--</a>--}}
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
        <div class="table-responsive row fix-w">
          <table class="table table-bordered table-hover" id="dataAjax">
            <thead class="thead-default thead-lg">
            <tr>
              <th>#</th>
              <th>{{ __("horserace::be_form.reserve_datetime") }}</th>
              <th>{{ __("horserace::be_form.send_datetime") }}</th>
              <th>{{ __("horserace::be_form.mail_title") }}</th>
              <th>{{ __("horserace::be_form.total_user") }}</th>
              <th>{{ __("horserace::be_form.send_success_number") }}</th>
              <th>{{ __("horserace::be_form.read_number") }}</th>
              <th>{{ __("horserace::be_form.daemon") }}</th>
              <th>{{ __("horserace::be_form.title_review_condition") }}</th>
              <th>{{ __("horserace::be_form.title_review_content") }}</th>
              <th>{{ __("horserace::be_form.change") }}</th>
            </tr>
            </thead>
            <tbody>
            {{-- @foreach($data["mail_bulk"] as $item)
              <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->reserve_datetime }}</td>
                <td>{{ $item->send_datetime }}</td>
                <td>{{ $item->mail_title }}</td>
                <td>{{ $item->total_user }}</td>
                <td>{{ $item->send_success_number }}</td>
                <td>{{ $item->read_number }}</td>
                <td>{{ $item->daemon . '(' . $item->rate_daemon . '%)' }}</td>
                <td>
                  <button class="btn btn-info review-condition"
                          data-id-mail="{{ $item->id }}"
                          data-condition="{{ $item->condition }}"
                          data-toggle="modal"
                          data-target="#reviewCondition">
                    {{ __("horserace::be_form.btn_review_condition") }}
                  </button>
                </td>
                <td>
                  <button class="btn btn-info review-mail"
                          data-id-mail="{{ $item->id }}"
                          data-reserve-datetime="{{ date_format(date_create($item->reserve_datetime), "Y-m-d H:i:s")  }}"
                          data-mail-from-address="{{ $item->mail_from_address }}"
                          data-mail-from-name="{{ $item->mail_from_name }}"
                          data-mail-title="{{ $item->mail_title }}"
                          data-mail-body="{{ $item->mail_body }}"
                          data-toggle="modal"
                          data-target="#reviewContent">
                    {{ __("horserace::be_form.btn_review_content") }}
                  </button>
                </td>
                <td>
                  @if($item->status == MAIL_BULK_STATUS_NOT_SEND)
                    <button type="button" class="btn btn-warning change-status-mail"
                            data-id-mail="{{ $item->id }}"
                            data-title="{{ $item->mail_title }}"
                            data-toggle="modal"
                            data-target="#changeStatusMail">
                      {{ __("horserace::be_form.btn_change_status") }}
                    </button>
                  @endif
                </td>
              </tr>
            @endforeach --}}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- Popup -->
  @include('horserace::backend.popup.confirm_change_status_mail')
  @include('horserace::backend.popup.review_content')
  @include('horserace::backend.popup.review_condition')
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
        "sAjaxSource": "{{ route('admin.mail_bulk.ajax') }}",
        "iDisplayLength": 20,
        "aaSorting": [0, "desc" ],
        "aoColumns": [
          { "sName": "bulk_id"},
          { "sName": "reserve_datetime"},
          { "sName": "send_datetime"},
          { "sName": "mail_title"},
          { "sName": "total_user"},
          { "sName": "send_success_number", "bSortable": false },
          { "sName": "read_number", "bSortable": false },
          { "sName": "daemon", "bSortable": false },
          { "sName": "title_review_condition",'render': function ( data, type, row ) {
                    return `<button class="btn btn-info review-condition" data-id-mail="${data.id}" data-condition=${data.condition} data-toggle="modal" data-target="#reviewCondition"> {{ __("horserace::be_form.btn_review_condition") }} </button>`;
                }, "bSortable": false },
          { "sName": "title_review_content", "bSortable": false },
          { "sName": "change", "bSortable": false },
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
      $('#type-filter').on('change', function () {
        table.column(2).search($(this).val()).draw();
      });
    });

    // Change status mail
    $(document).on('click', 'button.change-status-mail', function () {
      $('#id_mail').val($(this).attr('data-id-mail'));
      let mail_title = $(this).attr('data-title');
      $('#mail_title').html(mail_title);
      document.frmChangeMail.action = "{{ route('admin.mail_schedule.stop') }}";
    });

    // Review condition
    $(document).on('click', 'button.review-condition', function () {
      let condition = $(this).attr('data-condition');

      let value = JSON.parse(condition);
      let result = [];

      for(let i in value){
        result[i] = value[i];
      }
      let array_select = ['member_level', 'age', 'prediction_type', 
      'entrance_id', 'stop_mail', 'sns_register', 'media_code', 'search_match_type'];

      $('input[name*=user_stage_id').prop('checked',false);
      $('input[name*=gender').prop('checked',false);

      for(let i in result){
          if (i == 'user_stage_id'){
            for(let k in result[i]){
              $('input[value="' + result[i][k] + '"]').prop('checked',true);
            }
          }
          else if (i == 'gender'){
            for(let j in result[i]){
              $('input[name="gender[' + result[i][j] + ']"]').prop('checked', true);
            }
          }
          else if (i == 'option_summer'){
            $('input[name="option_summer"][value="'+ result[i] +'"]').prop('checked', true);
          }
          else if (i == 'option_summer_not'){
            $('input[name="option_summer_not"][value="'+ result[i] +'"]').prop('checked', true);
          }
          else if (array_select.includes(i)){
            $('select[name="' + i + '"]').val(result[i]);
          }
          else{
            $('input[name="' + i + '"]').val(result[i]);
          }
        }

        $('.selectpicker').selectpicker('refresh');
    });

    // Review mail
    $(document).on('click', 'button.review-mail', function () {
      $('.id_mail').val($(this).attr('data-id-mail'));
      $('.mail_from_address').val($(this).attr('data-mail-from-address'));
      $('.mail_from_name').val($(this).attr('data-mail-from-name'));
      $('.mail_title').val($(this).attr('data-mail-title'));
      $('.reserve_datetime').val($(this).attr('data-reserve-datetime'));
      $('.mail_body').html($(this).attr('data-mail-body'));
      $('#summernote').summernote('code', $(this).attr('data-mail-body'));
      document.frmChangeMail.action = "{{ route('admin.mail_schedule.stop') }}";
    });
  </script>

  <script>
    // using text area
    $(function () {
      $('#summernote').summernote();
      $('#summernote_air').summernote({
        airMode: true
      });
    });
  </script>
@endsection