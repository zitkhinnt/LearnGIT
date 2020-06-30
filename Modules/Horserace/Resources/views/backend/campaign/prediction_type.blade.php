@extends('horserace::backend.layouts.design')
@section('title', __("horserace::be_sidebar.prediction_type"))
@section('content')
  <!-- START PAGE CONTENT-->
  <div class="page-content fade-in-up">
    <div class="ibox">
      <!-- Head -->
      <div class="ibox-head">
        <div class="ibox-title">
          {{ __("horserace::be_sidebar.prediction_type") }}
        </div>
        <!-- <div class="">
          <a class="mb-0 ml-2 btn btn-success"
             href="{{ route('admin.prediction_type.add') }}">
            {{ __("horserace::be_form.add_new") }}
          </a>
        </div> -->
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
              <th>{{ __("horserace::be_form.code") }}</th>
              <th>{{ __("horserace::be_form.name") }}</th>
              <th>{{ __("horserace::be_form.image") }}</th>
              <th>{{ __("horserace::be_form.edit") }}</th>
              <!-- <th>{{ __("horserace::be_form.delete") }}</th> -->
            </tr>
            </thead>
            <tbody>
            @foreach($data["prediction_type"] as $item)
              <tr>
                <td width="10">{{ $item->id }}</td>
                <td>{{ $item->code }}</td>
                <td>{{ $item->name }}</td>
                <td>
                  @if(!is_null($item->image))
                    <img src="{{ asset($item->image) }}" height="150">
                  @endif
                </td>
                <td width="50">
                  <a class="btn btn-outline-info btn-rounded"
                     href="{{ route('admin.prediction_type.edit', $item->id) }}"><span
                      class="btn-icon"><i class="ti ti-pencil"></i>{{ __("horserace::be_form.edit") }}</span></a>
                </td>
                <!-- <td width="50">
                  <button type="button" class="btn btn-outline-danger btn-rounded"
                          data-id-delete="{{ $item->id }}"
                          data-title="{{ $item->name }}"
                          data-toggle="modal" data-target="#ModalDelete">
                    <span class="btn-icon">
                      <i class="ti-trash"></i>
                      {{ __("horserace::be_form.delete") }}
                    </span>
                  </button>
                </td> -->
              </tr>
            @endforeach
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

      var table = $('#datatable').DataTable();
      $('#key-search').on('keyup', function () {
        table.search(this.value).draw();
      });
      $('#type-filter').on('change', function () {
        table.column(2).search($(this).val()).draw();
      });
    });

    // using model delete job
    $(document).on('click', 'button.btn-rounded', function () {
      $('#id_delete').val($(this).attr('data-id-delete'));
      let nameDelete = $(this).attr('data-title');
      $('#exampleModalLabel').html(nameDelete);
      document.frmDelete.action = "{{ route('admin.prediction_type.delete') }}";
    });
  </script>
@endsection