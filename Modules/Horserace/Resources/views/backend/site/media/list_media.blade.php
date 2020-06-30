@extends('horserace::backend.layouts.design')
@section('title', __("horserace::be_sidebar.media"))
@section('content')

  <!-- breadcumb -->
@section('media_title', __("horserace::be_sidebar.media"))
@section('breadcrumb_item')
  <li class="breadcrumb-item"> {{ __("horserace::be_sidebar.media") }} </li>
@endsection

<div class="media-content fade-in-up">
  <div class="ibox">

    <div class="ibox-head">
      <div class="ibox-title">
        {{ __("horserace::be_sidebar.media_list") }}
      </div>
      <div class="">
        <a class="mb-0 ml-2 btn btn-success"
           href="{{ route('admin.media.add') }}">
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

    <!-- List media -->
      <div class="table-responsive row fix-w">
        <table class="table table-bordered table-hover" id="dataMedia">
          <thead class="thead-default thead-lg">
          <tr>
            <th>#</th>
            <th>{{ __("horserace::be_form.media_name") }}</th>
            <th>{{ __("horserace::be_form.media_code") }}</th>
            <th>{{ __("horserace::be_form.ad_type") }}</th>
            <th>{{ __("horserace::be_form.cost") }}</th>
            <th>{{ __("horserace::be_form.media_url") }}</th>
            <th>{{ __("horserace::be_form.register_time") }}</th>
            <th>{{ __("horserace::be_form.btn_review") }}</th>
            <th>{{ __("horserace::be_form.delete") }}</th>
          </tr>
          </thead>
          <tbody>
          @foreach($data['list'] as $item)
            <tr>
              <td>
                <a class="text-muted font-16" href="{{ route('admin.media.edit',$item->id ) }}">
                  <i class="ti-pencil-alt"></i>
                </a>
              </td>
              <td>
                @if($item->id == 1 )
                  {{ $item->name }}
                @else
                  <a target="_blank"
                     href="{!! $item->link  !!}"
                     style="color: #3498db;">
                    {{ $item->name }}
                  </a>
                @endif
              </td>
              <td>{{ $item->code }}</td>
              @if ($item->ad_type == ADVERTISE_TYPE_AF)
                <td>{{ __("horserace::be_form.ad_type_af")  }}</td>
              @elseif ($item->ad_type == ADVERTISE_TYPE_SHARE)
                <td>{{ __("horserace::be_form.ad_type_share")  }}</td>
              @else
                <td>{{ __("horserace::be_form.ad_type_pernament")  }}</td>
              @endif
              <td>{{$item->ad_type == ADVERTISE_TYPE_SHARE ? number_format($item->cost) . '％' : '¥' . number_format($item->cost)}}</td>
              <td>{{ $item->url }}</td>
              <td>{{ $item->created_at }}</td>
              <td width="50">
                <a class="btn btn-info" target="_blank"
                   href="{{ $item->url }}">
                  {{ __("horserace::be_form.btn_review") }}
                </a>
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

      $('#dataMedia').DataTable({
        pageLength: 20,
        fixedHeader: true,
        responsive: true,
        "scrollX": true,
        "sDom": 'rtip',
        fixedColumns: {
          leftColumns: 1,
        },
        columnDefs: [{
          targets: 'no-sort',
          orderable: false
        }],
        language: {
          "sEmptyTable": "データはありません。",
          "sInfo": " _TOTAL_ 件中 _START_ から _END_ まで表示",
          "sInfoEmpty": " 0 件中 0 から 0 まで表示",
          "sInfoFiltered": "（全 _MAX_ 件より抽出）",
          "sInfoPostFix": "",
          "sInfoThousands": ",",
          "sLengthMenu": "_MENU_ 件表示",
          "sLoadingRecords": "読み込み中...",
          "sProcessing": "処理中...",
          "sSearch": "検索:",
          "sZeroRecords": "一致するレコードがありません",
          "oPaginate": {
            "sFirst": "先頭",
            "sLast": "最終",
            "sNext": "次",
            "sPrevious": "前"
          },
          "oAria": {
            "sSortAscending": ": 列を昇順に並べ替えるにはアクティブにする",
            "sSortDescending": ": 列を降順に並べ替えるにはアクティブにする"
          }
        }
      });

      var table = $('#dataMedia').DataTable();
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
      document.frmDelete.action = "{{ route('admin.media.delete') }}";
    });
  </script>
@endsection