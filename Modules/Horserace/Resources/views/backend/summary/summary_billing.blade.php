@extends('horserace::backend.layouts.design')
@section('title',__("horserace::be_sidebar.summary_billing"))
@section('content')

  <!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.summary_billing"))
@section('breadcrumb_item')
  <li class="breadcrumb-item">{{ __("horserace::be_sidebar.summary_billing") }}</li>
@endsection

<!-- START PAGE CONTENT-->
<div class="page-content fade-in-up">
  <!-- Year -->
  <div class="row">
    <div class="col-md-12">
      <div class="ibox">
        <div class="ibox-head">
          <div class="ibox-title">
            {{ __('horserace::be_form.total_year') }}
          </div>
        </div>
        <div class="ibox-body">
          <form action="{{ route("admin.summary.billing") }}" method="GET">
            <label>{{ __("horserace::be_form.total_year") }}</label>
            <select name="year" class="custom-select">
              <option value="" selected="selected">
                {{ __('horserace::be_form.unset') }}
              </option>
              @for($i = 2018; $i <= 2030; $i++)
                <option value="{{ $i }}"
                  {{ $data["year"] == $i ? "selected" : "" }}>
                  {{ $i }}
                </option>
              @endfor
            </select>
            <button type="submit" class="btn btn-dark">
              {{ __("horserace::be_form.btn_search") }}
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Table list user stage-->
  <div class="row">
    <div class="col-xl-12">
      <div class="ibox">
        <div class="ibox-head">
          <div class="ibox-title">
            <h5>{{ __('horserace::be_form.daily') }}</h5>
          </div>
        </div>
        <div class="ibox-body">
          <table id="table-report-day-access" class="table table-bordered  mb-5">
            <thead>
            <tr class="bg-city-lights">
              <th rowspan="2">{{ __('horserace::be_form.year_month') }}</th>
              <th rowspan="2">{{ __('horserace::be_form.sales') }}</th>
              <th rowspan="2">{{ __('horserace::be_form.summary_number_people_deposit') }}</th>
              <th class="text-center" colspan="8">{{ __('horserace::be_form.purchase_rate') }}</th>
              <th rowspan="2">{{ __('horserace::be_form.user_register') }}</th>
              <th rowspan="2">{{ __('horserace::be_form.new_deposit') }}</th>
              <th rowspan="2">{{ __('horserace::be_form.charging_rate') }}</th>
            </tr>
            <tr class="bg-city-lights">
              <th colspan="2">0円～30,000円</th>
              <th colspan="2">30,001円～60,000円</th>
              <th colspan="2">60,001円～100,000円</th>
              <th colspan="2">100,001円～</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data["summary"] as $month => $item)
              @if($month != "summary")
                <tr>
                  <td>{{ $data["year"] . " - " . ($item["month"] < 10 ? (0 . $item["month"]) : $item["month"])  }}</td>
                  <td>{{ "¥ " . number_format($item["number_amount"]) }}</td>
                  <td>{{ number_format($item["user_deposit"]) . " (" .  number_format($item["number_trans"]) . ") "}}</td>
                  <td>{{ $item["user_deposit_1"] }}</td>
                  <td>{{ $item["user_deposit_rate_1"] . "%" }}</td>
                  <td>{{ $item["user_deposit_2"] }}</td>
                  <td>{{ $item["user_deposit_rate_2"] . "%" }}</td>
                  <td>{{ $item["user_deposit_3"] }}</td>
                  <td>{{ $item["user_deposit_rate_3"] . "%" }}</td>
                  <td>{{ $item["user_deposit_4"] }}</td>
                  <td>{{ $item["user_deposit_rate_4"] . "%" }}</td>
                  <td>{{ $item["user_register"] }}</td>
                  <td>{{ $item["user_deposit_first"] }}</td>
                  <td>{{ $item["charging_rate"] . "%" }}</td>
                </tr>
              @else
                <tr>
                  <td class="bg-yellow">合計</td>
                  <td>{{ "¥ " . number_format($item["number_amount"]) }}</td>
                  <td>{{ number_format($item["user_deposit"]) . " (" .  number_format($item["number_trans"]) . ") "}}</td>
                  <td>{{ $item["user_deposit_1"] }}</td>
                  <td>{{ $item["user_deposit_rate_1"] . "%" }}</td>
                  <td>{{ $item["user_deposit_2"] }}</td>
                  <td>{{ $item["user_deposit_rate_2"] . "%" }}</td>
                  <td>{{ $item["user_deposit_3"] }}</td>
                  <td>{{ $item["user_deposit_rate_3"] . "%" }}</td>
                  <td>{{ $item["user_deposit_4"] }}</td>
                  <td>{{ $item["user_deposit_rate_4"] . "%" }}</td>
                  <td>{{ $item["user_register"] }}</td>
                  <td>{{ $item["user_deposit_first"] }}</td>
                  <td>{{ $item["charging_rate"] . "%" }}</td>
                </tr>
              @endif
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END PAGE CONTENT-->
@endsection
@section('javascript')
@endsection
