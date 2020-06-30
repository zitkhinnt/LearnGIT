@extends('horserace::backend.layouts.design')
@section('title',__("horserace::be_sidebar.summary_mail_schedule"))
@section('content')

  <!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.summary_mail_schedule"))
@section('breadcrumb_item')
  <li class="breadcrumb-item">{{ __("horserace::be_sidebar.summary_mail_schedule") }}</li>
@endsection

<!-- START PAGE CONTENT-->
<div class="page-content fade-in-up">
  <div class="ibox">
    <!-- Head -->
    <div class="ibox-head">
      <div class="ibox-title">
        {{ __("horserace::be_sidebar.summary_mail_schedule") }}
      </div>
    </div>

    <div class="ibox-body">
      @if (Session::has('flash_message'))
        <div class="alert alert-{!! Session::get('flash_level') !!}">
          {!! Session::get('flash_message') !!}
        </div>
      @endif

      <div class="table-responsive row">
        <table class="table table-bordered table-hover" id="datatable">
          <thead class="thead-default thead-lg">
          <tr>
            <th>#</th>
            <th>{{ __("horserace::be_form.schedule_type") }}</th>
            <th>{{ __("horserace::be_form.mail_title") }}</th>
            <th>{{ __("horserace::be_form.time_set") }}</th>
            <th>{{ __("horserace::be_form.send_datetime") }}</th>
            <th>{{ __("horserace::be_form.total_user") }}</th>
            <th>{{ __("horserace::be_form.send_mail") }}</th>
            <th>{{ __("horserace::be_form.read_number") }}</th>
            <th>{{ __("horserace::be_form.daemon") }}</th>
            <th>{{ __("horserace::be_form.title_review_condition") }}</th>
            <th>{{ __("horserace::be_form.title_review_content") }}</th>
          </tr>
          </thead>
          <tbody>
          @foreach($data['mail_schedule_done'] as $item)
            <tr>
              <td width="10">{{ $item["id"] }}</td>
              <td>{{ mailScheduleTypeStr($item["info"]["schedule_type"]) }}</td>
              <td>{{ $item["info"]["mail_title"]  }}</td>
              <td>{{ $item["time_set"]  }}</td>
              <td>{{ $item["created_at"]  }}</td>
              <td>{{ $item["total_user"] }}</td>
              <td>{{ $item["send_success_number"] }}</td>
              <td>{{ $item["read_number"] }}</td>
              <td>{{ $item["daemon_number"] . '(' . $item["daemon_rate"] . '%)' }}</td>
              <td>
                <button class="btn btn-info review-condition" 
                        data-id-mail="{{ $item["info"]["id"] }}" 
                        data-condition="{{ $item["info"]["condition"] }}"
                        data-toggle="modal" 
                        data-target="#reviewCondition"> 
                        {{ __("horserace::be_form.btn_review_condition") }} 
                </button>
              </td>
              <td>
                <button class="btn btn-info review-mail"
                        data-id-mail="{{ $item["info"]["id"] }}"
                        data-reserve-datetime="{{ date_format(date_create($item["info"]["reserve_datetime"]), "Y-m-d H:i:s")  }}"
                        data-mail-from-address="{{ $item["info"]["mail_from_address"] }}"
                        data-mail-from-name="{{ $item["info"]["mail_from_name"] }}"
                        data-mail-title="{{ $item["info"]["mail_title"] }}"
                        data-mail-body="{{ $item["info"]["mail_body"] }}"
                        data-toggle="modal"
                        data-target="#reviewContent">
                  {{ __("horserace::be_form.btn_review_content") }}
                </button>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- Popup -->
@include('horserace::backend.popup.review_content')
@include('horserace::backend.popup.review_condition')
@endsection
@section('javascript')
  <script>
    $(function () {

      var table = $('#datatable').DataTable();
      table.column('5:visible')
        .order('desc')
        .draw();
      $('#key-search').on('keyup', function () {
        table.search(this.value).draw();
      });
      $('#type-filter').on('change', function () {
        table.column(4).search($(this).val()).draw();
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
    });
  </script>
@endsection
