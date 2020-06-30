@extends('horserace::backend.layouts.design')
@section('title', __("horserace::be_sidebar.mail_replace"))
@section('content')

  <!-- breadcumb -->
  @section('page_title', __("horserace::be_sidebar.mail_replace"))
  @section('breadcrumb_item')
    <li class="breadcrumb-item">{{ __("horserace::be_sidebar.mail_replace") }}</li>
  @endsection

  <div class="page-content fade-in-up">
    <div class="ibox">
      <!-- Head -->
      <div class="ibox-head">
        <div class="ibox-title">
          {{ __("horserace::be_sidebar.mail_replace") }}
        </div>
        <div class="">
          <a class="mb-0 ml-2 btn btn-success"
             href="{{ route('admin.mail_replace.add') }}">
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

        <div class="table-responsive row">
          <table class="table table-bordered table-hover" id="datatable">
            <thead class="thead-default thead-lg">
            <tr>
              <th>#</th>
              <th>{{ __("horserace::be_form.mail_replace_name") }}</th>
              <th>{{ __("horserace::be_form.mail_replace_source") }}</th>
              <th>{{ __("horserace::be_form.edit") }}</th>
              <th>{{ __("horserace::be_form.delete") }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data['mail_replace'] as $item)
              <tr>
                <td width="10">{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td>{!! $item->source !!}</td>
                <td width="50">
                  <a class="btn btn-outline-info btn-rounded"
                     href="{{ route('admin.mail_replace.edit', $item->id) }}">
                    <span class="btn-icon">
                      <i class="ti ti-pencil"></i>
                      {{ __("horserace::be_form.edit") }}
                    </span>
                  </a>
                </td>
                <td width="50">
                  <button type="button" class="btn btn-outline-danger btn-rounded"
                          data-idDelete="{{ $item->id }}"
                          data-name="{{ $item->name }}"
                          data-toggle="modal"
                          data-target="#ModalDelete">
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
      $('#id_delete').val($(this).attr('data-idDelete'));
      let nameDelete = $(this).attr('data-name');
      $('#exampleModalLabel').html(nameDelete);
      document.frmDelete.action = "{{ route('admin.mail_replace.delete') }}";
    });
  </script>
@endsection