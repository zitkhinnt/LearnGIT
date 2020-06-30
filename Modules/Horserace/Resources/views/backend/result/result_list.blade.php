@extends('horserace::backend.layouts.design')
@section('title', __("horserace::be_sidebar.result_list"))
@section('content')

  <!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.result"))
@section('breadcrumb_item')
  <li class="breadcrumb-item">{{ __("horserace::be_sidebar.result") }}
  </li>
@endsection

<div class="page-content fade-in-up">
  <div class="ibox">
    <div class="ibox-head">
      <div class="ibox-title">
        {{ __("horserace::be_sidebar.result_list") }}
      </div>
      <div class="">
        <a class="mb-0 ml-2 btn btn-success"
           href="{{ route('admin.result.add') }}">
          {{ __("horserace::be_form.add_new") }}
        </a>
      </div>
    </div>

    <div class="ibox-body">
      <!-- Show message -->
      @if (Session::has('flash_message'))
        <div class="alert alert-{!! Session::get('flash_level') !!}">
          {!! Session::get('flash_message') !!}
        </div>
      @endif
      <div class="flexbox mb-4">
        <div class="input-group-icon input-group-icon-left mr-3">
          <span class="input-icon input-icon-right font-16"><i class="ti-search"></i></span>
          <input class="form-control form-control-rounded form-control-solid" id="key-search" type="text"
                 placeholder="{{ __("horserace::be_form.search") }}">
        </div>
      </div>

      <!-- list blog -->
      <div class="table-responsive row">
        <table class="table table-bordered table-hover" id="dataAjax">
          <thead class="thead-default thead-lg">
          <tr>
            <th>#</th>
            <th>{{ __("horserace::be_form.course") }}</th>
            <th>{{ __("horserace::be_form.double") }}</th>
            <th>{{ __("horserace::be_form.race_no_1_title") }}</th>
            <th>{{ __("horserace::be_form.race_no_2_title") }}</th>
            <th>{{ __("horserace::be_form.korogashi") }}</th>
            <th>{{ __("horserace::be_form.ticket_type") }}</th>
            <th>{{ __("horserace::be_form.bike_number") }}</th>
            <th>{{ __("horserace::be_form.won") }}</th>
            <th>{{ __("horserace::be_form.date") }}</th>
            <th>{{ __("horserace::be_form.edit") }}</th>
            <th>{{ __("horserace::be_form.delete") }}</th>
          </tr>
          </thead>
          <tbody>
          {{-- @foreach($data as $item)
            <tr>
              <td width="5%">{{ $item->id }}</td>
              <td>{{ $item->course_text }}</td>
              <td>{{doubleToStr($item->double)}}</td>
              <td>
                {{  $item->race_no_1_title . " - " .
                    raceNoStr($item->race_no_1_num) . " - " .
                    $venue[$item->place_1]["name"] }}
              </td>
              <td>
                {{  $item->race_no_2_title . " - " .
                   raceNoStr($item->race_no_2_num) . " - " .
                    $venue[$item->place_2]["name"] }}
              </td>
              <td>{{ $item->korogashi }}</td>
              <td>{{ ticketToStr($item->ticket_type) }}</td>
              @if($item->double == DOUBLE_ON)
                <td>{{ "1着: " . $item->bike_number_1 . "; 2着: " . $item->bike_number_2 . "; 3着: " . $item->bike_number_3}}=>{{ "1着: " . $item->bike_number_1_2 . "; 2着: " . $item->bike_number_2_2 . "; 3着: " . $item->bike_number_3_2}}</td>               
              @else
                <td>{{ "1着: " . $item->bike_number_1 . "; 2着: " . $item->bike_number_2 . "; 3着: " . $item->bike_number_3}}</td> 
              @endif
              <td>{{ $item->won_man ."万".  $item->won_yen . "円"}}</td>
              <td width="15%">{{ date_format(date_create($item->date), "Y-m-d") }}</td>
              <td width="13%" align="center">
                <a class="btn btn-outline-info btn-rounded" href="{{ route('admin.result.edit', $item->id) }}"><span
                    class="btn-icon">
                      <i class="ti ti-pencil"></i>
                    {{ __("horserace::be_form.edit") }}
                    </span>
                </a>
              </td>
              <td width="13%" align="center">
                <button type="button" class="btn btn-outline-danger btn-rounded"
                        data-idDelete="{{ $item->id }}"
                        data-title="{{ $item->course }}"
                        data-toggle="modal" data-target="#ModalDelete">
                    <span class="btn-icon">
                      <i class="ti-trash"></i>
                      {{ __("horserace::be_form.delete") }}
                    </span>
                </button>
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
        "sAjaxSource": "{{ route('admin.result.ajax') }}",
        "iDisplayLength": 20,
        "aaSorting": [0, "desc" ],
        "aoColumns": [
          { "sName": "id"},
          { "sName": "course"},
          { "sName": "double"},
          { "sName": "race_no_1_title"},
          { "sName": "race_no_2_title"},
          { "sName": "korogashi"},
          { "sName": "ticket_type"},
          { "sName": "bike_number"},
          { "sName": "won"},
          { "sName": "date"},
          { "sName": "edit"},
          { "sName": "delete"}
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

    // using model delete job 
    $(document).on('click', 'button.btn-rounded', function () {
      $('#id_delete').val($(this).attr('data-idDelete'));
      let nameDelete = $(this).attr('data-title');
      $('#exampleModalLabel').html(nameDelete);
      document.frmDelete.action = "{{ route('admin.result.delete') }}";
    });
  </script>
@endsection