@extends('horserace::backend.layouts.design')
@section('title', __("horserace::be_sidebar.blog_list"))
@section('content')

  <!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.blog"))
@section('breadcrumb_item')
  <li class="breadcrumb-item">{{ __("horserace::be_sidebar.blog") }}
  </li>
@endsection

<div class="page-content fade-in-up">
  <div class="ibox">
    <div class="ibox-head">
      <div class="ibox-title">
        {{ __("horserace::be_sidebar.blog_list") }}
      </div>
       <div class="">
        <a class="mb-0 ml-2 btn btn-success"
           href="{{ route('admin.blog.add') }}">
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


      <!-- list blog -->
      <div class="table-responsive row">
        <table class="table table-bordered table-hover" id="datatable">
          <thead class="thead-default thead-lg">
          <tr>
            <th>#</th>
            <th>{{ __("horserace::be_form.blog_number_access") }}</th>
            <th>{{ __("horserace::be_form.blog_title") }}</th>
            <!-- <th>{{ __("horserace::be_form.rate") }}</th> -->
            <th>「公開」</th>
            <th>{{ __("horserace::be_form.public_at") }}</th>
            <th>{{ __("horserace::be_form.public_end") }}</th>
            <th>{{ __("horserace::be_form.edit") }}</th>
            <!-- <th>{{ __("horserace::be_form.delete") }}</th> -->
          </tr>
          </thead>
          <tbody>
          @foreach($data as $item)
            <tr>
              <td width="5%">{{ $item->id }}</td>
              <td width="5%">
                <a href="{{ route("admin.user.access_blog", $item->id) }}"
                   style="color: #00cec9">
                  {{ number_format($item->number_access) }}
                </a>
              </td>
              <td>{{ $item->title }}</td>
              <!-- <td width="30%">{{ blogStatusStr($item->status) }}</td> -->
              <td>{{(Carbon\Carbon::now()->gte(Carbon\Carbon::parse($item->public_at)) && Carbon\Carbon::now()->lte(Carbon\Carbon::parse($item->public_end)))?'公開中':''}}</td>
              <td>{{ date_format(date_create($item->public_at), "Y-m-d H:i:s") }}</td>
              <td>{{ date_format(date_create($item->public_end), "Y-m-d H:i:s") }}</td>
              <td width="10%" align="center">
                <a class="btn btn-outline-info btn-rounded" href="{{ route('admin.blog.edit', $item->id) }}"><span
                    class="btn-icon">
                      <i class="ti ti-pencil"></i>
                    {{ __("horserace::be_form.edit") }}
                    </span>
                </a>
              </td>
              <!-- <td width="10%" align="center">
                <button type="button" class="btn btn-outline-danger btn-rounded"
                        data-idDelete="{{ $item->id }}"
                        data-title="{{ $item->title }}"
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
      table.column('0:visible')
        .order('desc')
        .draw();
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
      let nameDelete = $(this).attr('data-title');
      $('#exampleModalLabel').html(nameDelete);
      document.frmDelete.action = "{{ route('admin.blog.delete') }}";
    });
  </script>
@endsection
