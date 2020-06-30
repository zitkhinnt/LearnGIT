@extends('horserace::backend.layouts.design')
@section('title', __("horserace::be_sidebar.admin_edit"))
@section('content')

  <!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.admin"))
@section('breadcrumb_item')
  <li class="breadcrumb-item">
    <a href="{{ route('admin.admin') }}"> {{ __("horserace::be_sidebar.admin") }} </a>
  </li>
  <li class="breadcrumb-item">{{ __("horserace::be_sidebar.admin_edit") }}</li>
@endsection
<!-- START PAGE CONTENT-->
<div class="page-content fade-in-up">
  <div class="ibox">
    <form action="{{ route('admin.admin.store') }}" method="POST">
      @csrf
      <input type="hidden" name="id" value="{{ $data["admin"]->id }}">
      <div class="ibox-head">
        <div class="ibox-title">
          {{ __("horserace::be_sidebar.admin_edit") }}
        </div>
      </div>
      <div class="ibox-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group mb-4">
              <label>{{ __("horserace::be_form.name") }}</label>
              <input class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" type="text"
                     value="{{ $data['admin']->name }}" name="name">
              @if ($errors->has('name'))
                <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('name') }}</strong>
                  </span>
              @endif
            </div>
            <div class="form-group mb-4">
              <label>{{ __("horserace::be_form.mail_address") }}</label>
              <input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                     type="email"
                     value="{{ $data['admin']->email }}" name="email">
              @if ($errors->has('email'))
                <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('email') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group mb-4">
              <label>{{ __("horserace::be_form.login_id") }}</label>
              <input class="form-control {{ $errors->has('login_id') ? ' is-invalid' : '' }}"
                     type="text"
                     value="{{ $data['admin']->login_id }}" name="login_id">
              @if ($errors->has('login_id'))
                <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('login_id') }}</strong>
                  </span>
              @endif
            </div>
            <div class="form-group mb-4">
              <label>{{ __("horserace::be_form.password") }}</label>
              <input class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                     type="text" value="{{ $data['admin']->password_text }}" name="password">
              @if ($errors->has('password'))
                <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('password') }}</strong>
                   </span>
              @endif
            </div>
          </div>
        </div>
        <div class="row">
          <!-- User stage -->
          <label class="ml-3">{{ __("horserace::be_form.user_stage") }}</label>
          <button class="btn btn-dark ml-3 mb-3 btn-all"
                  type="button">
            {{ __("horserace::be_form.btn_user_stage_all") }}
          </button>

          <button class="btn btn-dark ml-3 mb-3 btn-remove-all"
                  type="button">
            {{ __("horserace::be_form.btn_user_stage_remove_all") }}
          </button> 
      </div>
      @if((Auth::guard('admin')->user()->role_code)!= ROLE_STAFF)
          @foreach($menuLv1 as $key => $level1)
          <div class="row">
            <div class="col-md 12">
              <div class="portlet box red">
                <div class="portlet-title">
                    <div class="caption">{{ __("horserace::be_sidebar.$level1->title") }}</div>
                </div>
                <div class="portlet-body">
                  <div class="row">
                  @foreach($menuLv2 as $key => $level2)
                    @if($level1->id == $level2->groupid)
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="checkbox checkbox-primary">
                            <!-- check checked -->
                            <input class="user_stage" name="menu_id[]" type="checkbox" value="{{ $level2->id }}"
                            <?php foreach($role as $key => $item): ; ?>
                            <?php if($level2->id == $item->id ){ ?>
                            <?php echo "checked";} ?>
                            <?php endforeach ?>
                            >
                            <!--  -->
                          <span class="input-span"></span>{{ __("horserace::be_sidebar.$level2->title") }}
                        </label>
                      </div>
                    </div>
                    @endif
                  @endforeach
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        @else
          <div style="display:none;">
            @foreach($menuLv1 as $key => $level1)
            <div class="row">
              <div class="col-md 12">
                <div class="portlet box red">
                  <div class="portlet-title">
                      <div class="caption">{{ __("horserace::be_sidebar.$level1->title") }}</div>
                  </div>
                  <div class="portlet-body">
                    <div class="row">
                    @foreach($menuLv2 as $key => $level2)
                      @if($level1->id == $level2->groupid)
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="checkbox checkbox-primary">
                              <!-- check checked -->
                              <input class="user_stage" name="menu_id[]" type="checkbox" value="{{ $level2->id }}"
                              <?php foreach($role as $key => $item): ; ?>
                              <?php if($level2->id == $item->id ){ ?>
                              <?php echo "checked";} ?>
                              <?php endforeach ?>
                              >
                              <!--  -->
                            <span class="input-span"></span>{{ __("horserace::be_sidebar.$level2->title") }}
                          </label>
                        </div>
                      </div>
                      @endif
                    @endforeach
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        @endif
      </div>
      <div class="ibox-footer row mt-4">
        <div class="col-sm-10 ">
          <a class="btn btn-secondary" href="{{ route('admin.admin')}}">
            {{ __("horserace::be_form.btn_back") }}
          </a>
        </div>
        <div class="col-sm-2 ">
          <div class="text-right">
            <button type="submit" class="btn btn-primary btn-air mr-2">
              {{ __("horserace::be_form.btn_edit_deleted") }}
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- END PAGE CONTENT-->
@endsection
<style>
  .portlet.red, .portlet>.portlet-body.red {
    background-color: #333842;
  }
  .portlet {
    margin-top: 0;
  }
  .portlet-title {
    border-bottom: 0;
    padding: 0 10px;
    margin-bottom: 0;
    color: #fff;
}
  .portlet.box>.portlet-title>.caption {
    padding: 11px 0 9px;
  }
  .portlet>.portlet-title>.caption {
    float: left;
    display: inline-block;
    font-size: 18px;
    line-height: 18px;
    padding: 10px 0;
  }
  .portlet.box>.portlet-body {
    background-color: #fff;
    padding: 15px;
    clear: both;
}
</style>
@section('javascript')

<script>
  
    // Add bonus point
    $(document).on('click', 'button.btn-all', function () {
      var check = document.getElementsByClassName('user_stage');
      for (var i = 0; i < check.length; i++) {
        if (check[i].type == 'checkbox') {
          check[i].checked = true;
        }
      }
    });

    // Remove bonus point
    $(document).on('click', 'button.btn-remove-all', function () {
      var uncheck = document.getElementsByClassName('user_stage');
      for (var i = 0; i < uncheck.length; i++) {
        if (uncheck[i].type == 'checkbox') {
          uncheck[i].checked = false;
        }
      }
    });
  </script>
@endsection