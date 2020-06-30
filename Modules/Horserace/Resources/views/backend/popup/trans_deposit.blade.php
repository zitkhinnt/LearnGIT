<!-- Modal Delete Post  -->
<div class="modal fade" id="transDeposit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <form method="POST" action="{{ route("admin.deposit.apply") }}">
          {{ csrf_field() }}
          <input type="hidden" class="user_id" name="user_id" value="">
          <div class="row">
            <div class="col-md-6 mb-3">
              <!-- ID -->
              <label>{{ __("horserace::be_form.id") }}</label>
              <input class="form-control id"
                     type="text" id="id" name="id"
                     value="" readonly>
            </div>
            <div class="col-md-6 mb-3">
              <!-- Login id -->
              <label>{{ __("horserace::be_form.login_id") }}</label>
              <input class="form-control login_id"
                     type="text" id="login_id" name="login_id"
                     value="" readonly>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <!-- point -->
              <label>{{ __("horserace::be_form.point") }}</label>
              <input class="form-control point"
                     type="text" id="point" name="point"
                     value="" readonly>
            </div>
            <div class="col-md-6 mb-3">
              <!-- amount -->
              <label>{{ __("horserace::be_form.amount") }}</label>
              <input class="form-control amount"
                     type="text" id="amount" name="amount"
                     value="" readonly>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <!-- Status -->
              <label>{{ __("horserace::be_form.status") }}</label>
              <select class="selectpicker show-tick form-control" name="status">
                <option value="{{ NOT_APPLY }}">
                  {{ __("horserace::be_form.payment_not_apply") }}
                </option>
                <option value="{{ APPLY }}">
                  {{ __("horserace::be_form.payment_apply") }}
                </option>
              </select>
            </div>
            <!-- method -->
            <div class="col-md-6 mb-3">
              <label>{{ __("horserace::be_form.method") }}</label>
              <select class="selectpicker show-tick form-control method"
                      name="method" disabled>
                <option value="{{ METHOD_BANK }}">
                  {{ __("horserace::be_form.method_bank") }}
                </option>
                <option value="{{ METHOD_CREDIT }}">
                  {{ __("horserace::be_form.method_credit") }}
                </option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <!-- Delete -->
              <label class="checkbox">
                <input class="form-control" type="checkbox" name="deleted_flg" value="{{ DELETED_ENABLE }}">
                <span class="input-span"></span>
                {{ __("horserace::be_form.deleted") }}
              </label>
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
