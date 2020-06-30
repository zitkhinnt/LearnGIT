<!-- Modal Delete Post  -->
<div class="modal fade" id="transGift" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true" style="overflow: scroll;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <form id="frmPopUpTransGift" method="POST" action="{{ route("admin.trans_gift_bonus.add") }}">
          {{ csrf_field() }}
          <input type="hidden" name="type" value="{{ TRANSACTION_GIFT_TYPE_BONUS }}">
          <div class="row">
            <div class="col-md-6 mb-3">
              <!-- Login id -->
              <label>{{ __("horserace::be_form.login_id") }}</label>
              <input class="form-control login_id"
                     type="text" name="login_id" required
                     value="">
            </div>
            <div class="col-md-6 mb-3">
              <!-- name -->
              <label>{{ __("horserace::be_form.title") }}</label>
              <input class="form-control name"
                     type="text" name="name" required
                     value="">
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <!-- point -->
              <label>{{ __("horserace::be_form.point") }}</label>
              <input class="form-control point"
                     type="number" min="0" id="point" name="point" required
                     value="">
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 mb-3">
              <label>{{ __("horserace::be_form.note") }}</label>
              <textarea class="summernote" id="summernote" data-plugin="summernote"
                        data-air-mode="true" name="note" class="mail_body"></textarea> 
              <span class="invalid-feedback" style="color: red; display: block">
                <strong id = "strStatusNote"></strong>
              </span>             
            </div>
          </div>
          <div class="row">
            <div style="margin-left: 40%;">
              <button class="btn btn-warning">
                {{ __("horserace::be_form.btn_manual_deposit") }}
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
<script>  
  $('#frmPopUpTransGift').submit(function() 
  {
   
    if($("#summernote").val().length>10000)
    {
      $('#strStatusNote').html('コンテンツのサイズが制限を超えています');   
      return false;
    }
  });  
</script>
