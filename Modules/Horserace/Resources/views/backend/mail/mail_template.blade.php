@extends('horserace::backend.layouts.design')
@section('title', __('horserace::be_sidebar.mail_template'))
@section('content')

  <!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.mail_template"))
@section('breadcrumb_item')
  <li class="breadcrumb-item">{{ __("horserace::be_sidebar.mail_template") }}</li>
@endsection

  <div class="page-content fade-in-up">
    <div class="ibox">
      <div class="ibox-head">
        <div class="ibox-title">
          {{ __('horserace::be_sidebar.mail_template') }}
        </div>
        <div class="">
          <a href="{{ route("admin.mail_template.add") }}">
            <button class="btn btn-primary">
              {{ __('horserace::be_form.add_new') }}
            </button>
          </a>
        </div>
      </div>

      <div class="ibox-body">
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
              <option value="{{ __("horserace::be_form.mail_template_type_register") }}">
                {{ __("horserace::be_form.mail_template_type_register") }}
              </option>
              <option value="{{ __("horserace::be_form.mail_template_type_payment") }}">
                {{ __("horserace::be_form.mail_template_type_payment") }}
              </option>
              <option value="{{ __("horserace::be_form.mail_template_type_deposit") }}">
                {{ __("horserace::be_form.mail_template_type_deposit") }}
              </option>
              <option value="{{ __("horserace::be_form.mail_template_type_bulk") }}">
                {{ __("horserace::be_form.mail_template_type_bulk") }}
              </option>
              <option value="{{ __("horserace::be_form.mail_template_type_schedule")  }}">
                {{ __("horserace::be_form.mail_template_type_schedule") }}
              </option>
              <option value="{{ __("horserace::be_form.mail_template_type_contact")  }}">
                {{ __("horserace::be_form.mail_template_type_contact") }}
              </option>
              <option value="{{  __("horserace::be_form.mail_template_type_order") }}">
                {{ __("horserace::be_form.mail_template_type_order") }}
              </option>
              <option value="{{  __("horserace::be_form.mail_template_type_change_mail_pc") }}">
                {{ __("horserace::be_form.mail_template_type_change_mail_pc") }}
              </option>
              <option value="{{  __("horserace::be_form.mail_template_type_change_mail_mobile") }}">
                {{ __("horserace::be_form.mail_template_type_change_mail_mobile") }}
              </option>
              <option value="{{  __("horserace::be_form.mail_template_type_forget_password") }}">
                {{ __("horserace::be_form.mail_template_type_forget_password") }}
              </option>
              
            </select>
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
              <th>{{ __("horserace::be_form.name_mail_template") }}</th>
              <th>{{ __("horserace::be_form.type_mail_template") }}</th>
              <th>{{ __("horserace::be_form.edit") }}</th>
              <th>{{ __("horserace::be_form.delete") }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data["list_mail_template"] as $item)
              <tr>
                <td width="10">{{ $item->id }}</td>
                <td>
                  <a href="{{ route("admin.mail_template.edit", $item->id) }}">
                    {{ $item->name }}
                  </a>
                </td>
                <td>
                  {{ typeMailTemplateStr($item->type) }}
                </td>
                <td width="50">
                  <a class="btn btn-outline-info btn-rounded"
                     href="{{ route('admin.mail_template.edit', $item->id) }}">
                    <span class="btn-icon">
                      <i class="ti ti-pencil"></i>
                      {{ __("horserace::be_form.edit") }}
                    </span>
                  </a>
                </td>
                <td width="50">
                  <button type="button" class="btn btn-outline-danger btn-rounded"
                          data-id-delete="{{ $item->id }}"
                          data-title="{{ $item->name }}"
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
        table.column(2).search($(this).val()).draw();
      });
    });

    // Delete mailtemplate
    // using model delete job
    $(document).on('click', 'button.btn-rounded', function () {
      $('#id_delete').val($(this).attr('data-id-delete'));
      let nameDelete = $(this).attr('data-title');
      $('#exampleModalLabel').html(nameDelete);
      document.frmDelete.action = "{{ route('admin.mail_template.delete') }}";
    });
  </script>
@endsection