@extends('horserace::backend.layouts.design')
@section('title', __("horserace::be_sidebar.prediction"))
@section('content')
  <style>

  </style>
  <!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.prediction"))
@section('breadcrumb_item')
  <li class="breadcrumb-item"> {{ __("horserace::be_sidebar.prediction") }} </li>
@endsection

<div class="page-content fade-in-up">
  <div class="ibox">
    <div class="ibox-head">
      <div class="ibox-title">
        {{ __("horserace::be_sidebar.prediction") }}
      </div>
      <div class="">
        <a class="mb-0 ml-2 btn btn-success"
           href="{{ route('admin.prediction.add') }}">
          {{ __("horserace::be_form.add_new") }}
        </a>
      </div>
    </div>

    <div class="ibox-body">
      @if (Session::has('flash_message'))
        <div class="alert alert-{!! Session::get('flash_level') !!}">
          {!! Session::get('flash_message') !!}
        </div>
      @endif

      <div class="flexbox mb-4">
        <div class="flexbox">
          <label class="mb-0 mr-2">{{ __("horserace::be_form.status") }}</label>
          <select class="selectpicker show-tick form-control" id="type-filter-1"
                  title="{{ __("horserace::be_form.please_select") }}"
                  data-style="btn-solid" data-width="150px">
            <option value="">
              {{ __("horserace::be_form.search_all") }}
            </option>
            <option value="{{ PREDICTION_STATUS_OPEN }}">
              {{ __("horserace::be_form.prediction_status_open") }}
            </option>
            <option value="{{ PREDICTION_STATUS_REMAIN }}">
              {{ __("horserace::be_form.prediction_status_remain") }}
            </option>
            <option value="{{ PREDICTION_STATUS_DONE }}">
              {{ __("horserace::be_form.prediction_status_done") }}
            </option>
          </select>
		</div>		
        <div class="flexbox">
          <label class="mb-0 mr-2">{{ __("horserace::be_form.type") }}</label>
          <select class="selectpicker show-tick form-control" id="type-filter-2"
                  title="{{ __("horserace::be_form.please_select") }}"
                  data-style="btn-solid" data-width="150px">
            <option value="">
              {{ __("horserace::be_form.search_all") }}
			</option>
             @foreach($data['prediction_type'] as $item)
              <option value="{{ $item["name"] }}">
                {{ $item["name"] }}
              </option>
            @endforeach
          </select>
		</div>	
        <div class="input-group-icon input-group-icon-left mr-3">
          <span class="input-icon input-icon-right font-16"><i class="ti-search"></i></span>
          <input class="form-control form-control-rounded form-control-solid" id="key-search" type="text"
                 placeholder="{{ __("horserace::be_form.search") }}">
        </div>
      </div>
      <div class="table-responsive row fix-w">
        <table class="table table-bordered table-hover display"
               cellspacing="0" width="100%" id="dataAjax">
          <thead class="thead-default thead-lg">
          <tr>
            <th>#</th>
            <th>{{ __("horserace::be_form.id") }}</th>
            <th>{{ __("horserace::be_form.name") }}</th>
            <th>{{ __("horserace::be_form.default_point") }}</th>
            <th>{{ __("horserace::be_form.type") }} </th>
            <th>{{ __("horserace::be_form.status") }} </th>
            <!-- <th>{{ __("horserace::be_form.member_level") }} </th> -->
            <th>{{ __("horserace::be_form.user_stage") }} </th>
            <th>{{ __("horserace::be_form.number_buyer") }} </th>
            <th>{{ __("horserace::be_form.buy_number") }} </th>
            <th>{{ __("horserace::be_form.purchase_user_search") }} </th>
            <th>{{ __("horserace::be_form.number_access") }} </th>
            <th>{{ __("horserace::be_form.open_period") }}</th>
            <!-- <th>{{ __("horserace::be_form.review_prediction_content") }}</th> -->
            <th>{{ __("horserace::be_form.review_after_buy") }}</th>
            <th>{{ __("horserace::be_form.review_result") }}</th>
          </tr>
          </thead>
          <tbody>
          {{-- @foreach ($data['prediction'] as $item)
            <tr class="{{ backgroundColorPre($item->status) }}">
              <td>
                <a class="text-muted font-16" href="{{ route('admin.prediction.edit',$item->id ) }}">
                  <i class="ti-pencil-alt"></i>
                </a>
              </td>
              <td>{{ $item->id }}</td>
              <td>{{ $item->name }}</td>
              <td>{{ number_format($item->default_point) . " pt" }}</td>            
              <td>{{ $item->prediction_type_name }}</td>
              <td>{{ predictionStatusStr($item->status) }}</td>
            	<!-- <td>{{ memberLevelStr($item->member_level) }}</td> -->
              <td>{{ $item->user_stage_str }}</td>

              <!-- Child rows detail -->
              <td>
                <a href="{{ route("admin.user.buy_prediction", $item->id) }}"
                   style="color: #e55039;">
                  {{ $item->number_buyer }}
                </a>
              </td>
              <td>
                @if( $item->number_buyer > 0)
                  <div class="w-100">
                    <form action="{{ route("admin.user.search_buy_prediction") }}" method="GET">
                      <input type="hidden" name="prediction_id" value="{{ $item->id }}">
                      <label>{{ __("horserace::be_form.view_purchase") }}</label>
                      <select class="form-control p-0"
                              name="buy_prediction">
                        <option value="{{ null }}">
                          {{ __("horserace::be_form.unset") }}
                        </option>
                        <option value="{{ USER_BUY_PREDICTION_SUCCESS }}">
                          {{ __("horserace::be_form.user_buy_prediction_success") }}
                        </option>
                        <option value="{{ USER_BUY_PREDICTION_ERROR }}">
                          {{ __("horserace::be_form.user_buy_prediction_error") }}
                        </option>
                        <option value="{{ USER_ACCESS_RESULT_SUCCESS }}">
                          {{ __("horserace::be_form.user_access_result_success") }}
                        </option>
                        <option value="{{ USER_ACCESS_RESULT_NOT }}">
                          {{ __("horserace::be_form.user_access_result_not") }}
                        </option>
                      </select>
                      <button class="btn btn-dark mt-2">
                        {{ __("horserace::be_form.btn_search_user_buy") }}
                      </button>
                    </form>
                  </div>
                @endif
              </td>
              <td>
                <a href="{{ route("admin.user.access_prediction", $item->id) }}"
                   style="color: #4a69bd;">
                  {{ $item->number_access }}
                </a>
              </td>
              <td>
                {{ date_format(date_create($item->start_time), 'Y-m-d')  . ' ～ ' . date_format(date_create($item->end_time), 'Y-m-d') }}
              </td>
              <!-- <td>
                <a class="btn btn-info" target="_blank"
                   href="{{ route("admin.prediction.review", ["id_prediction" => $item->id, "content" => PREDICTION_TYPE_CONTENT_CONTENT]) }}">
                  {{ __("horserace::be_form.btn_review") }}
                </a>
              </td> -->

              <td>
                <a class="btn btn-info" target="_blank"
                   href="{{ route("admin.prediction.review", ["id_prediction" => $item->id, "content" => PREDICTION_TYPE_CONTENT_AFTER_BUY]) }}">
                  {{ __("horserace::be_form.btn_review") }}
                </a>
              </td>
              <td>
                <a class="btn btn-info" target="_blank"
                   href="{{ route("admin.prediction.review", ["id_prediction" => $item->id, "content" => PREDICTION_TYPE_CONTENT_RESULT]) }}">
                  {{ __("horserace::be_form.btn_review") }}
                </a>
              </td>
              <!-- Child rows detail -->
            </tr>
          @endforeach --}}

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- END PAGE CONTENT-->
<!-- Popup -->
@include('horserace::backend.popup.confirm_delete')
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
        "sAjaxSource": "{{ route('admin.prediction.ajax') }}",
        "iDisplayLength": 20,
        "aaSorting": [0, "desc" ],
        "aoColumns": [
          { "sName": "edit"},
          { "sName": "id"},
          { "sName": "name"},
          { "sName": "default_point"},
          { "sName": "type"},
          { "sName": "status"},
          { "sName": "user_stage"},
          { "sName": "number_buyer"},
          { "sName": "buy_number"},
          { "sName": "purchase_user_search"},
          { "sName": "number_access"},
          { "sName": "open_period"},
          { "sName": "review_after_buy"},
          { "sName": "review_result"},
        ],
        "fnServerParams": function ( aoData ) {
          aoData.push({ "name": "type_filter_1", "value": $('#type-filter-1').val() } );
          aoData.push({ "name": "type_filter_2", "value": $('#type-filter-2').val() } );
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
        },
        rowCallback: function (row, data) {
          $(row).addClass(data[14].class);
        },
      });
      $('#key-search').keypress(function(event) {
        if (event.key === "Enter") {
          table.draw();
        }
      });
      $('#type-filter-1').on('change', function () {
        table.column(5).search($(this).val()).draw();
      });
      $('#type-filter-2').on('change', function () {
        table.column(4).search($(this).val()).draw();
      });
      // $('#type-filter-3').on('change', function () {
      //   table.column(6).search($(this).val()).draw();
      // });
    });
    // using model delete job 
    $(document).on('click', 'button.btn-rounded', function () {
      $('#id_delete').val($(this).attr('data-idDelete'));
      let nameDelete = $(this).attr('data-title');
      $('#exampleModalLabel').html(nameDelete);
      document.frmDelete.action = "{{ route('admin.prediction.delete') }}";
    });
  </script>
@endsection