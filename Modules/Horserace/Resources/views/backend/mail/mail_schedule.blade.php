@extends('horserace::backend.layouts.design')
@section('title', __('horserace::be_sidebar.mail_schedule'))
<style>
    .panel-heading
    {
      display:none;
    }
    .panel-body
    {
      white-space: pre-line;
    }
  </style>
@section('content')
  <div class="page-content fade-in-up">
    <div class="ibox">
      <div class="ibox-head">
        <div class="ibox-title">
          {{ __('horserace::be_sidebar.mail_schedule') }}
        </div>
        <div class="ibox-title text-right">
          <a href="{{ route("admin.mail_schedule.add") }}">
            <button class="btn btn-primary">
              {{ __('horserace::be_form.add_new') }}
            </button>
          </a>
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
                   placeholder=" {{ __('horserace::be_form.search') }}">
          </div>
        </div>
        <!-- List mail schedule -->
        <div class="table-responsive row">
          <table class="table table-bordered table-hover" id="datatable">
            <thead class="thead-default thead-lg">
            <tr>
              <th>#</th>
              <th>{{ __("horserace::be_form.mail_schedule_properties") }}</th>
              <th>{{ __("horserace::be_form.mail_title") }}</th>
              <th>{{ __("horserace::be_form.type") }}</th>
              <th>{{ __("horserace::be_form.time_set") }}</th>
              <th>{{ __("horserace::be_form.title_review_condition") }}</th>
              <th>{{ __("horserace::be_form.title_review_content") }}</th>
              <th>{{ __("horserace::be_form.delete") }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data["mail_schedule"] as $item)
              <tr>
                <td width="10">
                  <a class="text-muted font-16" href="{{ route('admin.mail_schedule.edit',$item->id ) }}">
                    <i class="ti-pencil-alt"></i>
                  </a>
                </td>
                <td>{{ mailPropertiesStr($item->properties) }}</td>
                <td>{{ $item->mail_title }}</td>
                <td>{{ $item->type }}</td>
                <td>{{ isset($item->time_set)?$item->time_set:'' }}</td>
                <td width="50">
                  <button class="btn btn-info review-condition"
                          data-id-mail="{{ $item->id }}"
                          data-condition="{{ $item->condition }}"
                          data-toggle="modal"
                          data-target="#reviewCondition">
                    {{ __("horserace::be_form.btn_review_condition") }}
                  </button>
                </td>
                <td width="50">
                  <button class="btn btn-info review-mail"
                          data-id-mail="{{ $item->id }}"
                          data-reserve-datetime="{{ date_format(date_create($item->reserve_datetime), "Y-m-d")  }}"
                          data-mail-from-address="{{ $item->mail_from_address }}"
                          data-mail-from-name="{{ $item->mail_from_name }}"
                          data-mail-title="{{ $item->mail_title }}"
                          data-mail-body="{{ $item->mail_body }}"
                          data-toggle="modal"
                          data-target="#reviewContent">
                    {{ __("horserace::be_form.btn_review_content") }}
                  </button>
                </td>
                <td width="50">
                  <button type="button" class="btn btn-outline-danger btn-rounded"
                          data-idDelete="{{ $item->id }}"
                          data-title="{{ $item->mail_title }}"
                          data-toggle="modal" data-target="#ModalDelete">
                    <span class="btn-icon">
                      <i class="ti-trash"></i>
                      {{ __("horserace::be_form.delete") }}
                    </span>
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
  @include('horserace::backend.popup.confirm_change_status_mail')
  @include('horserace::backend.popup.review_content')
  @include('horserace::backend.popup.review_condition')
  <!-- Popup -->
  @include('horserace::backend.popup.confirm_delete')
@endsection
@section('javascript')
  <script>
    $(function () {
      var table = $('#datatable').DataTable();
      table.column('0:visible')
        .order('desc')
        .draw();
      $('#key-search').on('keyup', function () {
        table.search(this.value).draw();
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

  <script>
    // using model delete mail schedule
    $(document).on('click', 'button.btn-rounded', function () {
      $('#id_delete').val($(this).attr('data-idDelete'));
      let nameDelete = $(this).attr('data-title');
      $('#exampleModalLabel').html(nameDelete);
      document.frmDelete.action = "{{ route('admin.mail_schedule.delete') }}";
    });
  </script>

<script>
    $(".summernote").summernote
    (
      { 
    
      }
    ).on("summernote.enter", function(we, e)
    { 
        $(this).summernote("pasteHTML", "<br><br>"); 
        e.preventDefault(); 
    });
  </script>
    
<script>
  $(".summernote").summernote
    (
      { 
          
      }
    ).on("summernote.paste", function(we, e)
    { 
        var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text'); 
       
        e.preventDefault();          
        // Firefox fix
        setTimeout(function () {
              bufferText = bufferText.replace(/\r?\n/gi, '<br>');
              document.execCommand("insertHTML", false, bufferText);
          }, 10);
    });
  
</script>

<script>    

 $('#frmAdminMailBulkApply').submit(function() 
  {
    var template_plaint_text = $("#frmAdminMailBulkApply .summernote").val();
    var index_begin =  template_plaint_text.indexOf("<style");
    var index_end = template_plaint_text.indexOf("</style>");   
    template_plaint_text =  template_plaint_text.replace(template_plaint_text.substring(index_begin, index_end), "");
    template_plaint_text = template_plaint_text.replace(/<\/p>/gi, "\n")
            .replace(/<br\/?>/gi, "\n")
            .replace(/<\/?[^>]+(>|$)/gi, "");
    $("#frmAdminMailBulkApply .summernote").val(template_plaint_text);
  });
</script>
@endsection