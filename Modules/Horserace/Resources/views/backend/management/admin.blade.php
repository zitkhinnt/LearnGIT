@extends('horserace::backend.layouts.design')
@section('title', __("horserace::be_sidebar.admin"))
@section('content')

  <!-- breadcumb -->
  @section('page_title', __("horserace::be_sidebar.admin"))
  @section('breadcrumb_item')
    <li class="breadcrumb-item">{{ __("horserace::be_sidebar.admin") }}</li>
  @endsection

  <div class="page-content fade-in-up">
    <div class="ibox">
      <!-- Head -->
      <div class="ibox-head">
        <div class="ibox-title">
          {{ __("horserace::be_sidebar.admin") }}
        </div>
        <div class="ibox-title text-right">
          <a class="mb-0 ml-2 btn btn-success"
             href="{{ route('admin.admin.add') }}">
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
              <th>{{ __("horserace::be_form.name") }}</th>
              <th>{{ __("horserace::be_form.login_id") }}</th>
              <th>{{ __("horserace::be_form.hidden_email") }}</th>
              <th>{{ __("horserace::be_form.edit") }}</th>
              <th>{{ __("horserace::be_form.delete") }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data['admin'] as $item)
              <tr>
                <td width="10">{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->login_id }}</td>
                <td>
                  <div class="ibox-title">
                    <label class="checkbox">
                      <input <?php if((Auth::guard('admin')->user()->role_code)!= ROLE_ADMIN){echo " disabled='disabled' ";} ?> onclick="hiddenViewMail(this,{{ $item->id }});" type="checkbox" class="user_id_checkbox" name="user_id"   <?php if($item->role_email == ROLE_EMAIL_HIDDEN){echo "checked";}?>>
                      <span class="input-span">
                    </label>
                  </div>
                </td>
                <td width="50">
                  <a class="btn btn-outline-info btn-rounded" href="{{ route('admin.admin.edit', $item->id) }}">
                    <span class="btn-icon">
                      <i class="ti ti-pencil"></i>
                      {{ __("horserace::be_form.edit") }}
                      </span>
                  </a>
                </td>

                <td width="50">
                <button type="button" class="btn btn-outline-danger btn-rounded" data-idDelete="{{ $item->id }}" 
                  data-name="{{ $item->name }}" data-toggle="modal" data-target="#ModalDelete">
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
    function hiddenViewMail($element, id) {
      let= 
      $.ajax({
        url: "{{   route('admin.update.hidden.mail') }}",
        type: "POST",
        dataType: "JSON",
        data: {
          _token: "{{ csrf_token() }}",
          id: id,
          checked : $element.checked ? 0: 1,
        },
        success: function(response) {
          alert(response['flash_message']);
        }
      });
    }
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
      document.frmDelete.action = "{{ route('admin.admin.delete') }}";
    });
  </script>
@endsection