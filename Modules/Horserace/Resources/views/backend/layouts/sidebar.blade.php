<!-- START SIDEBAR-->
<?php $number_mail_unread = (Session::has('number_mail_unread')) ? Session::get('number_mail_unread') : 0;?>
<nav class="page-sidebar" id="sidebar">
  <div id="sidebar-collapse">
    <ul class="side-menu metismenu">
    <?php $data_menu =session('data_menu'); ?>
      @if((Auth::guard('admin')->user()->role_code)!= ROLE_ADMIN)
          @foreach($data_menu['menuLv1'] as $key => $level1)
        <li class="{{ menuActiveTag('$level1->title') }}">
          <a href="javascript:;">
            <i class="{{ $level1->note }}"></i>
            <span class="nav-label">
              {{ __("horserace::be_sidebar.$level1->title") }}
            </span>
            @if($level1->id == 7)
              @foreach($data_menu['menu_user'] as $key => $level2)
                @if($level2->id == 41)
                  @if($number_mail_unread < 10)
                  <p class="pl-2 text-danger numberCircle">{{ $number_mail_unread }}</p>
                  @else
                  <p class="pl-1 text-danger numberCircle">{{ $number_mail_unread }}</p>
                  @endif
                @endif  
              @endforeach
            @endif
            <i class="fa fa-angle-left arrow"></i>
          </a>
          <ul class="nav-2-level collapse">

          @foreach($data_menu['menu_user'] as $key => $level2)
          @if($level1->id == $level2->groupid)
            <li>
              <a class="" href="{{ route("admin.$level2->link") }}">
                {{ __("horserace::be_sidebar.$level2->title") }}
                @if($level2->id == 41)
                  @if($number_mail_unread < 10)
                  <p class="pl-2 text-danger numberCircle">{{ $number_mail_unread }}</p>
                  @else
                  <p class="pl-1 text-danger numberCircle">{{ $number_mail_unread }}</p>
                  @endif
                @endif
              </a>
            </li>
          @endif
          @endforeach
          </ul>
        </li>
        @endforeach
      @else
      <li class="{{ menuActiveTag('user') }}">
        <a href="javascript:;">
          <i class="sidebar-item-icon ti-user"></i>
          <span class="nav-label">
            {{ __("horserace::be_sidebar.user") }}
          </span>
          <i class="fa fa-angle-left arrow"></i>
        </a>
        <ul class="nav-2-level collapse">
          {{--<li>--}}
          {{--<a href="{{ route("admin.user") }}">User</a>--}}
          {{--</li>--}}
          <li>
            <a class="" href="{{ route("admin.user.search") }}">
              {{ __("horserace::be_sidebar.search_user") }}
            </a>
          </li>
          <li>
            <a href="{{ route("admin.mail_bulk") }}">
              {{ __("horserace::be_sidebar.mail_bulk") }}
            </a>
          </li>
          {{--<li>--}}
          {{--<a href="{{ route("admin.summary_mail.bulk") }}">Summary mail bulk</a>--}}
          {{--</li>--}}
          <li>
            <a href="{{ route("admin.mail_schedule") }}">
              {{ __("horserace::be_sidebar.mail_schedule") }}
            </a>
          </li>
          {{--<li>--}}
          {{--<a href="{{ route("admin.summary_mail.schedule") }}">Summary mail schedule </a>--}}
          {{--</li>--}}
          <li>
            <a href="{{ route("admin.user.interim") }}">
              {{ __("horserace::be_sidebar.user_interim") }}
            </a>
          </li>
          <li>
            <a href="{{ route("admin.user.search_login_history") }}">
              {{ __("horserace::be_sidebar.search_user_login_history") }}
            </a>
          </li>
        </ul>
      </li>
      <li class="{{ menuActiveTag('payment') }}">
        <a href="javascript:;">
          <i class="sidebar-item-icon ti-money"></i>
          <span class="nav-label">
            {{ __("horserace::be_sidebar.payment_management") }}
          </span>
          <i class="fa fa-angle-left arrow"></i>
        </a>
        <ul class="nav-2-level collapse">
          <li>
            <a href="{{ route("admin.deposit") }}">
              {{ __("horserace::be_sidebar.deposit") }}
            </a>
          </li>
          <li>
            <a href="{{ route("admin.payment") }}">
              {{ __("horserace::be_sidebar.payment") }}
            </a>
          </li>
          <li>
            <a href="{{ route("admin.trans_gift") }}">
              {{ __("horserace::be_sidebar.payment_gift") }}
            </a>
          </li>
        </ul>
      </li>
      <li class="{{ menuActiveTag('site') }}">
        <a href="javascript:;">
          <i class="sidebar-item-icon ti-check-box"></i>
          <span class="nav-label">{{ __("horserace::be_sidebar.site") }}</span>
          <i class="fa fa-angle-left arrow"></i>
        </a>
        <ul class="nav-2-level collapse">
          <li>
            <a href="{{ route("admin.entrance") }}">
              {{ __("horserace::be_sidebar.entrance") }}
            </a>
          </li>
          <li>
            <a href="{{ route("admin.page") }}">
              {{ __("horserace::be_sidebar.page") }}
            </a>
          </li>
          <li>
            <a href="{{ route("admin.point") }}">
              {{ __("horserace::be_sidebar.point") }}
            </a>
          </li>
          <li>
            <a href="{{ route("admin.venue") }}">
              {{ __("horserace::be_sidebar.venue") }}
            </a>
          </li>
          <li>
            <a href="{{ route("admin.user_stage") }}">
              {{ __("horserace::be_sidebar.user_stage") }}
            </a>
          </li>
          <li>
            <a href="{{ route("admin.media") }}">
              {{ __("horserace::be_sidebar.media") }}
            </a>
          </li>
        </ul>
      </li>
      <li class="{{ menuActiveTag('campaign') }}">
        <a href="javascript:;">
          <i class="sidebar-item-icon ti-calendar"></i>
          <span class="nav-label">
            {{ __("horserace::be_sidebar.campaign") }}
          </span>
          <i class="fa fa-angle-left arrow"></i>
        </a>
        <ul class="nav-2-level collapse">
          <li>
            <a href="{{ route("admin.prediction") }}">
              {{ __("horserace::be_sidebar.prediction") }}
            </a>
          </li>

          <li>
            <a href="{{ route("admin.prediction.type") }}">
              {{ __("horserace::be_sidebar.prediction_type") }}
            </a>
          </li>
        </ul>
      </li>
      <li class="{{ menuActiveTag('content') }}">
        <a href="javascript:;">
          <i class="sidebar-item-icon ti-pencil"></i>
          <span class="nav-label">
            {{ __("horserace::be_sidebar.content") }}
          </span>
          <i class="fa fa-angle-left arrow"></i>
        </a>
        <ul class="nav-2-level collapse">
          <li>
            <a href="{{ route("admin.result") }}">
              {{ __("horserace::be_sidebar.result") }}
            </a>
          </li>
          <li>
            <a href="{{ route("admin.blog") }}">
              {{ __("horserace::be_sidebar.blog") }}
            </a>
          </li>
          <li>
            <a href="{{ route("admin.gift") }}">
              {{ __("horserace::be_sidebar.gift") }}
            </a>
          </li>
          <li>
          <a href="{{ route("admin.edit_frontend") }}">
              {{ __("horserace::be_sidebar.frontend_edit") }}
            </a>
          </li>
        </ul>
      </li>
      <li class="{{ menuActiveTag('summary') }}">
        <a href="javascript:;">
          <i class="sidebar-item-icon ti-bar-chart"></i>
          <span class="nav-label">
           {{ __("horserace::be_sidebar.summary") }}
         </span>
         <i class="fa fa-angle-left arrow"></i>
       </a>
       <ul class="nav-2-level collapse">
        <li>
          <a href="{{ route("admin.summary.user_stage") }}">
            {{ __("horserace::be_sidebar.summary_user_stage") }}
          </a>
        </li>
        {{--<li>--}}
        {{--<a href="{{ route("admin.summary.payment") }}">--}}
        {{--{{ __("horserace::be_sidebar.summary_payment") }}--}}
        {{--</a>--}}
        {{--</li>--}}
        <li>
          <a href="{{ route("admin.summary.deposit") }}">
            {{ __("horserace::be_sidebar.summary_deposit") }}
          </a>
        </li>
        <li>
          <a href="{{ route("admin.summary.gift") }}">
            {{ __("horserace::be_sidebar.summary_gift") }}
          </a>
        </li>
        {{--<li>--}}
        {{--<a href="{{ route("admin.summary.access") }}">--}}
        {{--{{ __("horserace::be_sidebar.summary_access") }}--}}
        {{--</a>--}}
        {{--</li>--}}
        <li>
          <a href="{{ route("admin.summary.media") }}">
            {{ __("horserace::be_sidebar.summary_media") }}
          </a>
        </li>
        <li>
          <a href="{{ route("admin.summary.entrance") }}">
            {{ __("horserace::be_sidebar.summary_entrance") }}
          </a>
        </li>
        <li>
          <a href="{{ route("admin.summary.mail_bulk") }}">
            {{ __("horserace::be_sidebar.summary_mail_bulk") }}
          </a>
        </li>
        <li>
          <a href="{{ route("admin.summary.mail_schedule") }}">
            {{ __("horserace::be_sidebar.summary_mail_schedule") }}
          </a>
        </li>
        <li>
          <a href="{{ route("admin.summary.billing") }}">
            {{ __("horserace::be_sidebar.summary_billing") }}
          </a>
        </li>
      </ul>
    </li>
    <li class="{{ menuActiveTag('mail') }}">
      <a href="javascript:;">
        <i class="sidebar-item-icon ti-email"></i>
        <span class="nav-label">
         {{ __("horserace::be_sidebar.mail") }}
       </span>
       @if($number_mail_unread < 10)
       <p class="pl-2 text-danger numberCircle">{{ $number_mail_unread }}</p>
       @else
       <p class="pl-1 text-danger numberCircle">{{ $number_mail_unread }}</p>
       @endif
       <i class="fa fa-angle-left arrow"></i>
     </a>
     <ul class="nav-2-level collapse">
      <li>
        <a href="{{ route("admin.mail_template") }}">
          {{ __("horserace::be_sidebar.mail_template") }}
        </a>
      </li>
      <li>
        <a href="{{ route("admin.mail_contact") }}">
          {{ __("horserace::be_sidebar.mail_contact") }}
          @if($number_mail_unread < 10)
          <p class="pl-2 text-danger numberCircle">{{ $number_mail_unread }}</p>
          @else
          <p class="pl-1 text-danger numberCircle">{{ $number_mail_unread }}</p>
          @endif
        </a>
      </li>
      <li>
        <a href="{{ route("admin.mail_ban") }}">
          {{ __("horserace::be_sidebar.mail_ban") }}
        </a>
      </li>
      <li>
        <a href="{{ route('admin.list.mail.contact') }}">
          {{ __("horserace::be_sidebar.list_mail_contact") }}
        </a>
      </li>
    </ul>
  </li>
  <li class="{{ menuActiveTag('management') }}">
    <a href="javascript:;">
      <i class="sidebar-item-icon ti-clipboard"></i>
      <span class="nav-label">
        {{ __("horserace::be_sidebar.management") }}
      </span>
      <i class="fa fa-angle-left arrow"></i>
    </a>
    <ul class="nav-2-level collapse">
      <li>
        <a href="{{ route("admin.admin") }}">
          {{ __("horserace::be_sidebar.admin") }}
        </a>
      </li>
    </ul>
    <ul class="nav-2-level collapse">
      <li>
        <a href="{{ route("admin.partner") }}">
          {{ __("horserace::be_sidebar.partner") }}
        </a>
      </li>
    </ul>
  </li>
  <li class="{{ menuActiveTag('system') }}">
    <a href="javascript:;">
      <i class="sidebar-item-icon ti-settings"></i>
      <span class="nav-label">
       {{ __("horserace::be_sidebar.system") }}
     </span>
     <i class="fa fa-angle-left arrow"></i>
   </a>
   <ul class="nav-2-level collapse">
    <li>
      <a href="{{ route("admin.mail_replace") }}">
        {{ __("horserace::be_sidebar.mail_replace") }}
      </a>
    </li>
  </ul>
</li>
<li class="{{ menuActiveTag('order') }}">
  <a href="javascript:;">
    <i class="sidebar-item-icon ti-infinite"></i>
    <span class="nav-label">
     {{ __("horserace::be_sidebar.order") }}
   </span>
   <i class="fa fa-angle-left arrow"></i>
 </a>
 <ul class="nav-2-level collapse">
  <li>
    <a href="{{ route("admin.dashboard") }}">
      {{ __("horserace::be_sidebar.home") }}
    </a>
  </li>
  <li>
    <a href="{{ route("admin.logout") }}">
      {{ __("horserace::be_sidebar.logout") }}
    </a>
  </li>
</ul>
</li>
@endif
</ul>
</div>
</nav>
<!-- END SIDEBAR-->