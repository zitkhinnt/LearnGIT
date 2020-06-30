@extends('horserace::backend.layouts.design')
@section('title','Dashboard')
@section('content')
  <!-- START PAGE CONTENT-->
  <div class="page-content fade-in-up">
    <div class="ibox">
      <!-- Head -->
      <div class="ibox-head">
        <div class="ibox-title">
          {{ __("horserace::be_sidebar.prediction_result") }}
        </div>
      </div>

      @if (Session::has('flash_message'))
        <div class="alert alert-{!! Session::get('flash_level') !!}">
          {!! Session::get('flash_message') !!}
        </div>
    @endif

    <!-- List user -->
      <div class="ibox-body">
        <div class="flexbox mb-4">
          <div class="input-group-icon input-group-icon-left mr-3">
            <span class="input-icon input-icon-right font-16"><i class="ti-search"></i></span>
            <input class="form-control form-control-rounded form-control-solid" id="key-search" type="text"
                   placeholder="{{ __("horserace::be_form.placeholder_search") }}">
          </div>

        </div>
        <div class="table-responsive row">
          <table class="table table-bordered table-hover" id="datatable">
            <thead class="thead-default thead-lg">
            <tr>
              <th>#</th>
              <th>{{ __("horserace::be_form.prediction_name") }}</th>
              <th>{{ __("horserace::be_form.race_name") }}</th>
              <th>{{ __("horserace::be_form.venue") }}</th>
              <th>{{ __("horserace::be_form.race_no") }}</th>
              <th>{{ __("horserace::be_form.hit_race") }}</th>
              <th>{{ __("horserace::be_form.prediction_result_amount") }}</th>
              <th>{{ __("horserace::be_form.prediction_type") }}</th>
              <th>{{ __("horserace::be_form.race_date") }}</th>
              <th>{{ __("horserace::be_form.reserve_datetime") }}</th>
              <th>{{ __("horserace::be_form.add_prediction_result") }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data["list_pre"] as $item)
              @if(is_null($item->result))
                <tr>
                  <td></td>
                  <td>{{ $item->name }}</td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>
                    <a href="{{ route("admin.prediction_result.add", $item->id) }}" class="btn btn-info">
                      {{  __("horserace::be_form.btn_add") }}
                    </a>
                  </td>
                </tr>
              @else
                <tr>
                  <td>
                    <a class="text-muted font-16"
                       href="{{ route('admin.prediction_result.edit',$item->result->id ) }}">
                      <i class="ti-pencil-alt"></i>
                    </a>
                  </td>
                  <td>{{ $item->name }}</td>
                  <td>{{ $item->result->race_name }}</td>
                  <td>{{ $data["venue"][$item->result->venue_id]->name }}</td>
                  <td>{{ raceNoStr($item->result->race_no) }}</td>
                  <td>{{ $item->result->hit_race }}</td>
                  <td>{{ $item->result->amount }}</td>
                  <td>{{ predictionTypeStr($item->result->prediction_type) }}</td>
                  <td>{{ date_format(date_create($item->result->race_date), 'Y-m-d') }}</td>
                  <td>{{ date_format(date_create($item->result->reserve_datetime), 'Y-m-d') }}</td>
                  <td></td>
                </tr>
              @endif

            @endforeach
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
  <!-- END PAGE CONTENT-->
@endsection
@section('javascript')
  <script>
    $(function () {

      var table = $('#datatable').DataTable();
      $('#key-search').on('keyup', function () {
        table.search(this.value).draw();
      });
      $('#type-filter').on('change', function () {
        table.column(2).search($(this).val()).draw();
      });
    });
  </script>
@endsection