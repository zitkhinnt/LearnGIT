@extends('horserace::backend.layouts.design')
@section('title', __("horserace::be_sidebar.entrance"))
@section('content')

  <!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.entrance"))
@section('breadcrumb_item')
  <li class="breadcrumb-item"> {{ __("horserace::be_sidebar.entrance") }} </li>
@endsection

<div class="entrance-content fade-in-up">
  <div class="ibox">

    <div class="ibox-head">
      <div class="ibox-title">
        {{ __("horserace::be_sidebar.entrance_list") }}
      </div>
      <div>
        <a class="mb-0 ml-2 btn btn-success"
           href="{{ route('admin.entrance.add') }}">
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

    <!-- List entrance -->
      <div class="table-responsive row">
        <table class="table table-bordered table-hover" id="datatable">
          <thead class="thead-default thead-lg">
          <tr>
            <th>#</th>
            <th>{{ __("horserace::be_form.entrance_name") }}</th>
            <th>{{ __("horserace::be_form.entrance_default_point") }}</th>
            <th>{{ __("horserace::be_form.entrance_default_user_stage") }}</th>
            <th>{{ __("horserace::be_form.entrance_default_flg") }}</th>
            <th>{{ __("horserace::be_form.edit") }}</th>
            <th>{{ __("horserace::be_form.delete") }}</th>
          </tr>
          </thead>
          <tbody>
          <?php khanh_log('$data admin/entrance'.print_r($data, true)); ?>
          @foreach($data['list'] as $item)
            <tr>
              <td width="10">{{ $item->id }}</td>
              <td>{{ $item->name }}</td>
              <td>{{ number_format($item->default_point) . " pt" }}</td>
              <td>{{ $data["user_stage"][$item->default_user_stage]->name ?? '' }}</td>
              <td>
                @if( $item->default_flg == ENTRANCE_DEFAULT_ENABLE)
                  {{ __("horserace::be_form.entrance_default_flg") }}
                @endif
              </td>
              <td width="50">
                <a class="btn btn-outline-info btn-rounded" href="{{ route('admin.entrance.edit', $item->id) }}"><span
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
      document.frmDelete.action = "{{ route('admin.entrance.delete') }}";
    });
  </script>
@endsection