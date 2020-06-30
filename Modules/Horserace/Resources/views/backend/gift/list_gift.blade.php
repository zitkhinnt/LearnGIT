@extends('horserace::backend.layouts.design')
@section('title', __("horserace::be_sidebar.gift"))
@section('content')

  <!-- breadcumb -->
  @section('page_title', __("horserace::be_sidebar.gift"))
  @section('breadcrumb_item')
    <li class="breadcrumb-item">{{ __("horserace::be_sidebar.gift_list") }}</li>
  @endsection

  <div class="page-content fade-in-up">
    <div class="ibox">

      <div class="ibox-head">
        <div class="ibox-title">
          {{ __("horserace::be_sidebar.gift_list") }}
        </div>
        <div class="">
          <a class="mb-0 ml-2 btn btn-success"
             href="{{ route('admin.gift.add') }}">
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
          <div class="flexbox">
            <label class="mb-0 mr-2">
              {{ __("horserace::be_form.type_mail_template") }}
            </label>
            <select class="selectpicker show-tick form-control" id="type-filter"
                    title="{{ __("horserace::be_form.please_select") }}"
                    data-style="btn-solid" data-width="150px">
              <option value="">
                {{ __("horserace::be_form.search_all") }}
              </option>
              <option value="{{ __("horserace::be_form.gift_type_register") }}">
                {{ __("horserace::be_form.gift_type_register") }}
              </option>
              <option value="{{ __("horserace::be_form.gift_type_event") }}">
                {{ __("horserace::be_form.gift_type_event") }}
              </option>
            </select>
          </div>
          <div class="input-group-icon input-group-icon-left mr-3">
            <span class="input-icon input-icon-right font-16"><i class="ti-search"></i></span>
            <input class="form-control form-control-rounded form-control-solid" id="key-search" type="text"
                   placeholder="{{ __("horserace::be_form.placeholder_search") }}">
          </div>
        </div>


        <!-- list gift -->
        <div class="table-responsive row">
          <table class="table table-bordered table-hover" id="datatable">
            <thead class="thead-default thead-lg">
            <tr>
              <th>#</th>
              <th>{{ __("horserace::be_form.name") }}</th>
              <th>{{ __("horserace::be_form.gift_type") }}</th>
              <th>{{ __("horserace::be_form.point") }}</th>
              <th>{{ __("horserace::be_form.date_start") }}</th>
              <th>{{ __("horserace::be_form.date_end") }}</th>
              <th>{{ __("horserace::be_form.edit") }}</th>
              <th>{{ __("horserace::be_form.delete") }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $item)
              <tr>
                <td width="10">{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ typeGiftStr($item->type) }}</td>
                <td>{{ $item->point }}</td>
                <td width="60">
                  <span
                    class="badge badge-success badge-pill">{!! date("Y-m-d", strtotime($item->start_time)) !!}</span>
                </td>
                <td width="60">
                  <span class="badge badge-danger badge-pill">{!! date("Y-m-d", strtotime($item->end_time)) !!}</span>
                </td>
                <td width="50">
                  <a class="btn btn-outline-info btn-rounded" href="{{ route('admin.gift.edit', $item->id) }}"><span
                      class="btn-icon"><i class="ti ti-pencil"></i>{{ __("horserace::be_form.edit") }}</span></a>
                </td>
                <td width="50">
                  <button type="button" class="btn btn-outline-danger btn-rounded"
                          data-id-delete="{{ $item->id }}"
                          data-title="{{ $item->name }}"
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
  @include('horserace::backend.popup.confirm_delete')

@endsection
@section('javascript')
  <script>
    $(function () {


      var table = $('#datatable').DataTable();
      $('#key-search').on('keyup', function () {
        table.search(this.value).draw();
      });
      $('#type-filter').on('change', function () {
        table.column(4).search($(this).val()).draw();
      });
    });

    // using model delete job 
    $(document).on('click', 'button.btn-rounded', function () {
      $('#id_delete').val($(this).attr('data-id-delete'));
      let nameDelete = $(this).attr('data-title');
      $('#exampleModalLabel').html(nameDelete);
      document.frmDelete.action = "{{ route('admin.gift.delete') }}";
    });
  </script>
@endsection