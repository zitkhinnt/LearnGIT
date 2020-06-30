<!-- START SIDEBAR-->
<nav class="page-sidebar" id="sidebar">
  <div id="sidebar-collapse">
    <ul class="side-menu metismenu">
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
            <a href="{{ route("partner.summary.access") }}">
              {{ __("horserace::be_sidebar.summary_media") }}
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
            <a href="{{ route("admin.logout") }}">
              {{ __("horserace::be_sidebar.logout") }}
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>
<!-- END SIDEBAR-->