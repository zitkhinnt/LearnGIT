<!-- Modal Delete Post  -->
<div class="modal fade" id="addUserBuyPrediction" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <h1> {{ __('horserace::be_form.btn_add_user_buy_prediction') }}</h1>
        <hr>
        <form method="POST" action="{{ route("admin.user.add_buy_prediction") }}">
          {{ csrf_field() }}
          <input type="hidden" class="prediction_detail_id" name="prediction_detail_id">
          <div class="row">
            <div class="col-md-6 mb-3">
              <!-- Login id -->
              <label>{{ __("horserace::be_form.login_id") }}</label>
              <input class="form-control login_id"
                     type="text" name="login_id" required
                     value="">
            </div>
            <div class="col-md-6 mb-3">
              <!-- point -->
              <label>{{ __("horserace::be_form.point") }}</label>
              <input class="form-control point"
                     type="number" min="0" id="point" name="point" required
                     value="0">
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label>{{ __("horserace::be_form.purchase_information") }}</label>
              <select class="selectpicker show-tick form-control" required
                      name="prediction_id" id="prediction_id">
                <option value="{{ null }}">
                  {{ __("horserace::be_form.unset") }}
                </option>
                @foreach($data["list_prediction_open"] as $item)
                  <option value="{{ $item->id }}">
                    {{ $item->name }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row">
            <div style="margin-left: 35%;">
              <button class="btn btn-warning">
                {{ __('horserace::be_form.btn_add_user_buy_prediction') }}
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
