$(document).ready(function () {
  // message
  $("div.alert").delay(3000).slideUp();
});

$(function () {
  //datatable 
  $('#datatable').DataTable({
    pageLength: 20,
    fixedHeader: true,
    responsive: true,
    "sDom": 'rtip',
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

  $('.dataTableScroll').DataTable({
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

});

// using text area
$(function () {
  $('#summernote').summernote();
  $('.summernote').summernote();
  $('#summernote_air').summernote({
    airMode: true
  });

  // using datepicker
  var date = new Date();
  date.setDate(date.getDate());
  $('.input-group.date').datepicker({
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    calendarWeeks: false,
    autoclose: true,
    // startDate: date,
    format: 'yyyy-mm-dd',
    language: 'ja',
    weekStart: 1
  });

  //using datetimepicker
  $('.input-group.datetime').datetimepicker({
    locale: 'ja',
    allowInputToggle: true,
    format: 'YYYY-MM-DD HH:mm:00',
  });
});

// show fullcalendar summary
$(document.getElementById("click_hidden")).click(function () {
  var show = document.getElementById("hide_calendar");
  var icon = document.getElementById("icon_arrow");
  //show.style.display = (show.style.display === 'none') ? 'block' : 'none';
  if (show.style.display === 'none') {
    show.style.display = 'block';
    document.getElementById("icon_arrow").className = 'ti-arrow-up';
  } else {
    show.style.display = 'none';
    document.getElementById("icon_arrow").className = 'ti-arrow-down';
  }

});

$(document).ready(function () {
  var show = document.getElementById("hide_calendar");
  if (show != null) {
    show.style.display = 'none';
  }
});

$(".sidebar-toggler").click(function () {
  // $(".dataTables_scrollHeadInner").width();
  $(".fix-w .dataTables_scrollHeadInner").toggleClass("w-100");
  // $(this).toggleClass(function () {
  //   if ($(this).parent().is(".bar")) {
  //     return "happy";
  //   } else {
  //     return "sad";
  //   }
  // });
});

$(document).ajaxSend(function (event, request, settings) {
  $('.preloader-backdrop').show();
});

$(document).ajaxComplete(function (event, request, settings) {
  $('.preloader-backdrop').hide();
});

