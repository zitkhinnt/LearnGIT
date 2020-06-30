<!-- Modal Delete Post  -->
<div class="modal fade" id="ModalDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">
            <span>{{ __("horserace::be_form.delete_record") }} </span>
            <span id="exampleModalLabel"></span>
          </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <h4>{{ __("horserace::be_msg.confirm_delete") }}</h4>
        </div>
        <form id="formDelete" role="modal" action="" method="POST" name="frmDelete">
          <input type="hidden" name="_token" value="{!! csrf_token() !!}">
          <input type="hidden" name="id_delete" id="id_delete" value="" >
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("horserace::be_form.close") }}</button>
            <button type="submit" class="btn btn-primary">{{ __("horserace::be_form.confirm") }}</button>
          </div>
        </form>
      </div>
    </div>
  </div>