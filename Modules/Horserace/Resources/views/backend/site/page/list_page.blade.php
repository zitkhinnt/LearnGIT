@extends('horserace::backend.layouts.design')
@section('title', __("horserace::be_sidebar.page"))
@section('content')

<!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.page"))
@section('breadcrumb_item')
<li class="breadcrumb-item"> {{ __("horserace::be_sidebar.page") }} </li>
@endsection

<div class="page-content fade-in-up">
  <div class="ibox">

    <div class="ibox-head">
      <div class="ibox-title">
        {{ __("horserace::be_sidebar.page_list") }}
      </div>
      <div class="hidden">
        <a class="mb-0 ml-2 btn btn-success"
        href="{{ route('admin.page.add') }}">
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

    <!-- List page -->
    <div class="table-responsive row">
      <table class="table table-bordered table-hover" id="datatable">
        <thead class="thead-default thead-lg">
          <tr>
            <th>#</th>
            <th>{{ __("horserace::be_form.name") }}</th>
            <th>{{ __("horserace::be_form.code") }}</th>
            <th>{{ __("horserace::be_form.link") }}</th>
            <th>{{ __("horserace::be_form.edit") }}</th>
            <!-- <th>{{ __("horserace::be_form.delete") }}</th> -->
          </tr>
        </thead>
        <tbody>
          @foreach($data['list'] as $item)
          <tr>
            <td width="10">{{ $item->id }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->code }}</td>
            <td>{{ $item->link }}</td>
            <td width="50">
              <a class="btn btn-outline-info btn-rounded" href="{{ route('admin.page.edit', $item->id) }}">
                <span class="btn-icon">
                  <i class="ti ti-pencil"></i>
                  {{ __("horserace::be_form.edit") }}
                </span>
              </a>
            </td>

           <!--  <td width="10%" align="center">
              <button type="button" class="btn btn-outline-danger btn-rounded"
              data-idDelete="{{ $item->id }}"
              data-name="{{ $item->name }}"
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
      table.column(3).search($(this).val()).draw();
    });
  });

    // using model delete job
    $(document).on('click', 'button.btn-rounded', function () {
      $('#id_delete').val($(this).attr('data-idDelete'));
      let nameDelete = $(this).attr('data-name');
      $('#exampleModalLabel').html(nameDelete);
      document.frmDelete.action = "{{ route('admin.page.delete') }}";
    });
  </script>
  @endsection
