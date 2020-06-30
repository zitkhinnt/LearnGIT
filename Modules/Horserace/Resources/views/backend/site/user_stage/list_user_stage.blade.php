@extends('horserace::backend.layouts.design')
@section('title',__("horserace::be_sidebar.user_stage"))
@section('content')

  <!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.user_stage"))
@section('breadcrumb_item')
  <li class="breadcrumb-item">{{ __("horserace::be_sidebar.user_stage") }}</li>
@endsection

<div class="page-content fade-in-up">
  <div class="ibox">
    <div class="ibox-body">
      <h5 class="font-strong mb-4">
        {{ __("horserace::be_sidebar.user_stage_add") }}
      </h5>
      <!-- Show message -->
      @if (Session::has('flash_message'))
        <div class="alert alert-{!! Session::get('flash_level') !!}">
          {!! Session::get('flash_message') !!}
        </div>
    @endif

    <!-- add user_stage -->
      <form class="form-category" action="{{ route('admin.user_stage.store') }}" method="POST">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        <input type="hidden" name="id" value="0">
        <div class="row">
          <!-- name -->
          <div class="col-sm-5">
            <div class="form-group">
              <label> {{ __("horserace::be_form.stage_name") }} </label>
              <input class="form-control form-control-solid {{ $errors->has('name') ? ' is-invalid' : '' }}"
                     type="text"
                     placeholder="{{ __("horserace::be_form.name") }}" name="name"
                     value="{{ old("name") }}">
              @if ($errors->has('name'))
                <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('name') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          <!-- stage -->
          <div class="col-sm-5">
            <div class="form-group">
              <label> {{ __("horserace::be_form.stage_description") }} </label>
              <input class="form-control form-control-solid {{ $errors->has('stage') ? ' is-invalid' : '' }}"
                     type="text"
                     placeholder="{{ __("horserace::be_form.stage_description") }}" name="stage"
                     value="{{ old("stage") }}">
              @if ($errors->has('stage'))
                <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('stage') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          <div class="col-sm-2" style="margin: auto">
            <button class="ml-2 mt-3 btn btn-success" type="submit">
              {{ __("horserace::be_form.btn_add") }}
            </button>
          </div>
        </div>
      </form>
    </div>
    <hr>

    <!-- List user_stage -->
    <div class="ibox-body">
      <div class="flexbox mb-4">
        <div class="flexbox">
          <h5 class="font-strong mb-4">
            {{ __("horserace::be_sidebar.user_stage_list") }}
          </h5>
        </div>
        <div class="input-group-icon input-group-icon-left mr-3">
          <span class="input-icon input-icon-right font-16"><i class="ti-search"></i></span>
          <input class="form-control form-control-rounded form-control-solid" id="key-search" type="text"
                 placeholder="{{ __("horserace::be_form.search") }}">
        </div>
      </div>
      <div class="table-responsive row">
        <table class="table table-bordered table-hover" id="datatable">
          <thead class="thead-default thead-lg">
          <tr>
            <th>#</th>
            <th>{{ __("horserace::be_form.stage_name") }}</th>
            <th>{{ __("horserace::be_form.stage_description") }}</th>
            <th>{{ __("horserace::be_form.edit") }}</th>
            <th>{{ __("horserace::be_form.delete") }}</th>
          </tr>
          </thead>
          <tbody>
          @foreach($data['list'] as $item)
            <tr>
              <td width="10">{{ $item->id }}</td>
              <td>{{ $item->name }}</td>
              <td>{{ $item->stage }}</td>
              <td width="50">
                <a class="btn btn-outline-info btn-rounded" href="{{ route('admin.user_stage.edit', $item->id) }}">
                    <span class="btn-icon">
                      <i class="ti ti-pencil"></i>
                      {{ __("horserace::be_form.edit") }}
                    </span>
                </a>
              </td>
              <td width="50">
                <button type="button" class="btn btn-outline-danger btn-rounded"
                        data-idDelete="{{ $item->id }}"
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
      $('#id_delete').val($(this).attr('data-idDelete'));
      let nameDelete = $(this).attr('data-title');
      $('#exampleModalLabel').html(nameDelete);
      document.frmDelete.action = "{{ route('admin.user_stage.delete') }}";
    });
  </script>
@endsection