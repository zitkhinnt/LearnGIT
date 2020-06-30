<!-- Modal Delete Post  -->

<div class="modal fade" id="reviewContent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body">
          <form id="frmAdminMailBulkApply" method="POST"  action="{{route(isset($data['mail_schedule'])? 'admin.mail_schedule.apply' :'admin.mail_bulk.apply') }}">       
            {{ csrf_field() }}
            <input type="hidden" class="id_mail" name="id" value="">
            <div class="row">
              <div class="col-md-6 mb-3">
                <!-- Mail form address -->
                <label>{{ __("horserace::be_form.mail_from_address") }}</label>
                <input class="form-control mail_from_address"
                      type="email" id="mail_from_address"  name="mail_from_address"
                      value="">
              </div>
              <div class="col-md-6 mb-3">
                <!-- Mail form name -->
                <label>{{ __("horserace::be_form.mail_from_name") }}</label>
                <input class="form-control mail_from_name"
                      type="text" id="mail_from_name" name="mail_from_name"
                      value="">
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <!-- mail_title -->
                <label>{{ __("horserace::be_form.mail_title") }}</label>
                <input class="form-control mail_title"
                      type="text" id="mail_title" name="mail_title"
                      value="">
              </div>
             {{-- <div class="col-md-6 mb-3" data-provide="datepicker">                
                <!-- reserve_datetime -->
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <label>{{ __("horserace::be_form.reserve_datetime") }}</label>
                <input class="form-control reserve_datetime"
                      type="text" id="reserve_datetime" name="reserve_datetime"
                      value="">
              </div>  --}}

              <!-- register_time end -->
              <div class="col-md-6 mb-3 form-group" style="display: {{isset($data['mail_schedule'])? 'none;':''}}">
                  <label>{{ __("horserace::be_form.reserve_datetime") }}</label>
                  <div class="input-group datetime">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input class="form-control reserve_datetime {{ $errors->has('reserve_datetime') ? ' is-invalid' : '' }}"
                           type="text" id="reserve_datetime" name="reserve_datetime" value="{{ old("reserve_datetime") }}">
                  </div>
                  @if ($errors->has('reserve_datetime'))
                    <span class="invalid-feedback" style="color: red; display: block">
                        <strong>{{ $errors->first('reserve_datetime') }}</strong>
                      </span>
                  @endif
              </div>


            </div>
            <label>{{ __("horserace::be_form.mail_body") }}</label>
            
            <!-- <textarea id="summernote" data-plugin="summernote" data-air-mode="true" class="mail_body summernote"
                      id="mail_body" name="mail_body"></textarea> -->
            <textarea data-air-mode="true" class="mail_body form-control" rows="15"
                      id="mail_body" name="mail_body"></textarea>
            <div class="modal-footer">
              <button class="btn btn-warning">
                  {{ __("horserace::be_form.update_mail_bulk") }}
                </button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">
                {{ __("horserace::be_form.close") }}
              </button>
            </div>           
          </form>
        </div>
    </div>
  </div>
</div>



