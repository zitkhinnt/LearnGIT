<!-- Modal Delete Post  -->
<?php
$condition = !is_null(old('condition')) ? old('condition') : $data["condition"];
$arr_condition = conditionToText($condition);
?>
<div class="modal fade" id="confirmMailBulk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">
          <span>{{ __("horserace::be_form.confirm") }} </span>
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row m-2">
          <div class="col-md-12">
            <h5>下記の内容でユーザーにメールが送信されます。よろしいですか？</h5>
          </div>
        </div>
        <hr>

        <div class="row m-2">
          <div class="col-md-12">
            <h5>{{ __("horserace::be_form.title_review_condition") }}</h5>
          </div>

          @if(count($arr_condition) <= 0)
            <span>配信条件はありません。</span>
          @else
            @foreach($arr_condition as $item)
              <div class="col-md-4 p-2">
                <span class="mt-3">{{ $item["label"] }} : {{ $item["value"] }}</span>
              </div>
            @endforeach
          @endif

        </div>
        <hr>

        <div class="row">
          <div class="col-md-6">
            <!-- Mail form address -->
            <span>{{ __("horserace::be_form.mail_from_address") }} : </span>
            <span class="popup_mail_from_address"></span>
          </div>
          <div class="col-md-6">
            <!-- Mail form name -->
            <span>{{ __("horserace::be_form.mail_from_name") }} : </span>
            <span class="popup_mail_from_name"></span>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <!-- mail_title -->
            <span>{{ __("horserace::be_form.mail_title") }} : </span>
            <span class="popup_mail_title"></span>
          </div>
          <div class="col-md-6">
            <!-- reserve_datetime -->
            <span>{{ __("horserace::be_form.reserve_datetime") }} : </span>
            <span class="popup_reserve_datetime"></span>
          </div>
        </div>
        <label>{{ __("horserace::be_form.mail_body") }} : </label>
        <!-- <textarea id="summernote-popup" data-plugin="summernote" data-air-mode="true" disabled
                  class="mail_body summernote" readonly></textarea> -->
        <textarea id="summernote-popup"  data-air-mode="true" disabled
            class="form-control mail_body" rows="15" readonly></textarea>
        <div class="row mt-2">
          <div style="margin-left: 45%;">
            <button type="button" class="btn btn-warning btn-confirm">
              {{ __("horserace::be_form.confirm") }}
            </button>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          {{ __("horserace::be_form.close") }}
        </button>
      </div>
    </div>
  </div>
</div>

