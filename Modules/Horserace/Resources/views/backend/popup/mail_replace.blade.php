<div class="modal fade" id="mail-replace">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header px-4 py-3 bg-primary-400">
        <div>
          <h5 class="modal-title text-white user-name">
            {{ __("horserace::be_form.mail_replace") }}
          </h5>
        </div>
        <button class="close text-white" type="button"
                data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>

      <?php $mail_replace = array()  ?>

      @if(Session::has('mail_replace'))
        <?php $mail_replace = Session::get('mail_replace'); ?>
      @endif

      <div class="modal-body p-4 row">
        <div style="height: 450px; overflow-y: scroll; width: 100%;">
          <table class="table table-hover table-bordered">
            <thead>
            <tr>
              <th>{{ __("horserace::be_form.mail_replace_name") }}</th>
              <th>{{ __("horserace::be_form.mail_replace_source") }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($mail_replace as $item)
              <tr>
                <td>{{ $item->name }}</td>
                <td>{!! $item->source !!}</td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>

      </div>

      <div class="modal-footer bg-primary-50 text-right">
        <button class="btn btn-info btn-rounded mr-3" type="button" data-dismiss="modal">
          {{ __("horserace::be_form.btn_close") }}
        </button>

      </div>
    </div>
  </div>
</div>