@extends('horserace::backend.layouts.design')
@section('title',__('horserace::be_form.list_query'))
@section('content')

@section('page_title', __('horserace::be_form.list_query'))
@section('breadcrumb_item')
  <li class="breadcrumb-item">{{ __('horserace::be_form.list_query') }}</li>
@endsection
<style>
.modal-lg{
  max-width: 1000px;
}
</style>
<div class="page-content fade-in-up">
    <div class="ibox">

      <div class="ibox-head">
        <div class="ibox-title">
          {{ __('horserace::be_form.list_query') }}
        </div>
      </div>

      <div class="ibox-body">
        @if (Session::has('flash_message'))
          <div class="alert alert-{!! Session::get('flash_level') !!}">
            {!! Session::get('flash_message') !!}
          </div>
      @endif

      <!-- Search -->
        <div class="flexbox mb-4">
          <div class="input-group-icon input-group-icon-left mr-3">
            <span class="input-icon input-icon-right font-16"><i class="ti-search"></i></span>
            <input class="form-control form-control-rounded form-control-solid" id="key-search" type="text"
                   placeholder="{{  __('horserace::be_form.search') }}">
          </div>
        </div>
        <!-- List mail bulk -->
        <div class="table-responsive row fix-w">
          <table class="table table-bordered table-hover dataTableScroll" id="dataQuerySearchUser">
            <thead class="thead-default thead-lg">
            <tr>
              <th>#</th>
              <th>{{ __('horserace::be_form.name') }}</th>
              <th>{{ __('horserace::be_form.created_at') }}</th>
              <th width="7%">{{ __('horserace::be_form.action') }}</th>
            </tr>
            </thead>
            <tbody>
                @foreach($data['list_query'] as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>
                            <button class="btn btn-info edit-query-search"
                                    data-id="{{ $item->id }}"
                                    data-query="{{ $item->query }}"
                                    data-name="{{ $item->name }}"
                                    data-toggle="modal"
                                    data-target="#querySearchUser">
                                    <i class="fa fa-pencil-square-o"></i>
                            </button>
                            <a href="{{ route('delete.query.search.user', ['id' => $item->id ]) }}" onclick="return confirm('この検索条件を削除しますか？')" class="btn btn-warning"><i class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
</div>
<script>
    $(document).on('click', 'button.btn-remove-all', function () {
      var uncheck = document.getElementsByClassName('user_stage');
      for (var i = 0; i < uncheck.length; i++) {
        if (uncheck[i].type == 'radio') {
          uncheck[i].checked = false;
        }
      }
    });

    $(function () {
      // var table1 = $('#dataQuerySearchUser').DataTable();

      // table1.column('0:visible').order('desc').draw();
      
      // $('#key-search').on('keyup', function () {
      //   table.search(this.value).draw();
      // });
      
      // $('#type-filter').on('change', function () {
      //   table.column(2).search($(this).val()).draw();
      // });
    });

    $('.edit-query-search').on('click', function(){
        let data_query = $(this).attr('data-query');
        let id = $(this).attr('data-id');
        let name = $(this).attr('data-name');
        $('.name_query').val(name);
        $('#id_query_search').val(id);

        let value = JSON.parse(data_query);
        let result = [];

        for(let i in value){
            result[i] = value[i];
        }
        let array_select = ['member_level', 'age', 'prediction_type', 
        'entrance_id', 'stop_mail', 'sns_register', 'media_code', 'search_match_type'];

        $('input[name*=user_stage_id').prop('checked',false);
        $('input[name*=gender').prop('checked',false);

        for(let i in result){
            if (i == 'user_stage_id'){
              for(let k in result[i]){
                $('input[value="' + result[i][k] + '"]').prop('checked',true);
              }
            }
            else if (i == 'gender'){
              for(let j in result[i]){
                $('input[name="gender[' + result[i][j] + ']"]').prop('checked', true);
              }
            }
            else if (i == 'option_summer'){
              $('input[name="option_summer"][value="'+ result[i] +'"]').prop('checked', true);
            }
            else if (i == 'option_summer_not'){
              $('input[name="option_summer_not"][value="'+ result[i] +'"]').prop('checked', true);
            }
            else if (array_select.includes(i)){
              $('select[name="' + i + '"]').val(result[i]);
            }
            else{
              $('input[name="' + i + '"]').val(result[i]);
            }
        }

        $('.selectpicker').selectpicker('refresh');
    });
</script>

@include('horserace::backend.popup.edit_query_search')
@endsection