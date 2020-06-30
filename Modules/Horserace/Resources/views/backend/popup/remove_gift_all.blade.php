<!-- Modal Delete Post  -->
<div class="modal fade" id="removeGiftAll" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <form method="POST" action="{{ route("admin.gift_all.remove") }}">
          {{ csrf_field() }}
          <input type="hidden" name="type" value="{{ TRANSACTION_GIFT_TYPE_BONUS }}">
          <input type="hidden" id="remove-condition" name="condition" value="">
          <div class="row">
            <div class="col-md-6 mb-3">
              <!-- name -->
              <label>{{ __("horserace::be_form.title") }}</label>
              <input class="form-control name"
                     type="text" name="name" required
                     value="">
            </div>
            <div class="col-md-6 mb-3">
              <!-- point -->
              <label>{{ __("horserace::be_form.point") }}</label>
              <input class="form-control point"
                     type="number" min="0" id="point" name="point" required
                     value="">
            </div>
          </div>
          <div class="row">

          </div>
          <div class="row">
            <div class="col-md-12 mb-3">
              <label>{{ __("horserace::be_form.note") }}</label>
              <textarea class="summernote" id="summernote" data-plugin="summernote"
                        data-air-mode="true" name="note" class="mail_body"></textarea>
            </div>
          </div>
          <div class="row">
            <div style="margin-left: 40%;">
              <button class="btn btn-danger">
                {{ __("horserace::be_form.btn_remove_bonus_point") }}
              </button>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          {{ __("horserace::be_form.close") }}
        </button>
      </div>
    </div>
  </div>
</div>
