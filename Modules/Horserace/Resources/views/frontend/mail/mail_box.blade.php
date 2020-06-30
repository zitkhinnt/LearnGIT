@extends('horserace::frontend.layouts.design')
@section('title','Mail')
@section('content')
  {{--<div class="plan-head">
    <img src="{{ asset('frontend/images/boat/login/title-mail.png') }}" width="860" height="92"/>
  </div>--}}
  <div class="title">メールBOX</div>

  <div id="txt-area">
    {{--<div class="mail">--}}
      @if (Session::has('flash_message'))
        <div class="alert alert-{!! Session::get('flash_level') !!}"
             style="height: 50px; font-size: 20px; text-align: center">
          {!! Session::get('flash_message') !!}
        </div>
      @endif

    {{-- <div class="mail"> --}}

        <!-- List mail -->
        <?php
        $start = ($data['mailbox']['currentPage'] - 1) * $data['mailbox']['perPage'];
        $item_one_page = ($data['mailbox']['currentPage'] * $data['mailbox']['perPage']);
        $end = $item_one_page > $data['mailbox']['total'] ? ($data['mailbox']['total']) : $item_one_page;
        ?>
        {{--<form action="{{ route("deleted_mail") }}" method="post">
          {{ csrf_field() }}--}}

          {{--<table>--}}
            @for($i = $start; $i < $end; $i++)
              <?php
              $check_read = false;
              if (isset($data['mailbox']['item'][$i]["read_at"]) && !is_null($data['mailbox']['item'][$i]["read_at"])) {
                $check_read = true;
              }
              if (isset($data['mailbox']['item'][$i]["user_read_at"]) && !is_null($data['mailbox']['item'][$i]["user_read_at"])) {
                $check_read = true;
              }
              ?>
              <a
                @switch($data['mailbox']['item'][$i]["mail_type"])                
                @case(MAIL_CONTACT)
                               
                    href="{{ route("mail_info", ["type" => MAIL_CONTACT, "id_mail" => $data['mailbox']['item'][$i]["id"]]) }}"            
                  
                @break

                @case(MAIL_BULK)
                    href="{{ route("mail_info", ["type" => MAIL_BULK, "id_mail" => $data['mailbox']['item'][$i]["id"]]) }}"
                 
                @break
                @case(MAIL_SCHEDULE)
                    href="{{ route("mail_info", ["type" => MAIL_SCHEDULE, "id_mail" => $data['mailbox']['item'][$i]["id"]]) }}"
                 
                @break

                @case(MAIL_PAYMENT)
                    href="{{ route("mail_info", ["type" => MAIL_PAYMENT, "id_mail" => $data['mailbox']['item'][$i]["id"]]) }}"
                   
                @break

                @case(MAIL_DEPOSIT)
                    href="{{ route("mail_info", ["type" => MAIL_DEPOSIT, "id_mail" => $data['mailbox']['item'][$i]["id"]]) }}"
                 
                @break

                @case(MAIL_GIFT)
                    href="{{ route("mail_info", ["type" => MAIL_GIFT, "id_mail" => $data['mailbox']['item'][$i]["id"]]) }} "
                
                @break

                @case(MAIL_PREDICTION_OPEN)
                    href="{{ route("mail_info", ["type" => MAIL_PREDICTION_OPEN, "id_mail" => $data['mailbox']['item'][$i]["id"]]) }}"
                  
                @break

                @case(MAIL_PREDICTION_RESULT)
                    href="{{ route("mail_info", ["type" => MAIL_PREDICTION_RESULT, "id_mail" => $data['mailbox']['item'][$i]["id"]]) }}"
                  
                @break

                @case(MAIL_REGISTER)
                    href="{{ route("mail_info", ["type" => MAIL_REGISTER, "id_mail" => $data['mailbox']['item'][$i]["id"]]) }}"
                
                @break

                @case(MAIL_INTERIM)
                    href="{{ route("mail_info", ["type" => MAIL_INTERIM, "id_mail" => $data['mailbox']['item'][$i]["id"]]) }}"                   
                
                @break
                          
              @endswitch
              >
              
              <div class="mail">
                  <p>{{ $data['mailbox']['item'][$i]["mail_title"] }}</p>
                  <dl class="clearfix"><dt><span class="{{$check_read?'':'red'}}">{{$check_read?'既読':'未読'}}</span></dt><dd> {{ date_format(date_create($data['mailbox']['item'][$i]["created_at"]), "Y-m-d") }} </dd></dl>
              </div>
            </a>
           
          @endfor


          @if ($data['mailbox']!=null && $data['mailbox']['lastPage'] >1)
            <ul class="pageNav01" style="max-width: 100%; max-height: 200px;">
                <?php $search["page"]= 1; ?>
                <li class="">
                    <a href="{{ route("mail_box", $search) }}">先頭</a>
                </li>

                @if($data['mailbox']['currentPage'] == 1)
                <li class="page-item disabled" aria-disabled="true" aria-label="« Previous">
                    <span class="page-link" aria-hidden="true">前</span>
                </li>
                @else
                <?php $search["page"] = $data['mailbox']['currentPage']-1; ?>
                <li class="page-item">
                    <a class="page-link" href="{{ route("mail_box", $search) }}" rel="prev"
                        aria-label="« Previous">前</a>
                </li>
                @endif

                @if($data['mailbox']['currentPage'] != 2 && $data['mailbox']['currentPage'] != 1)
                <?php $search["page"]= $data['mailbox']['currentPage']-2; ?>
                <li class="">
                    <a href="{{ route("mail_box", $search) }}">{{$data['mailbox']['currentPage']-2}}</a>
                </li>
                @endif

                @if($data['mailbox']['currentPage'] != 1)
                <?php $search["page"]= $data['mailbox']['currentPage']-1; ?>
                <li class="">
                    <a href="{{ route("mail_box", $search) }}">{{$data['mailbox']['currentPage']-1}}</a>
                </li>
                @endif

                <?php $search["page"]= $data['mailbox']['currentPage']; ?>
                <li class="active">
                    <a href="{{ route("mail_box", $search) }}">{{$data['mailbox']['currentPage']}}</a>
                </li>

                @if($data['mailbox']['currentPage'] != $data['mailbox']['lastPage'])
                <?php $search["page"]= $data['mailbox']['currentPage']+1; ?>
                <li class="">
                    <a href="{{ route("mail_box", $search) }}">{{$data['mailbox']['currentPage']+1}}</a>
                </li>
                @endif

                @if($data['mailbox']['currentPage'] != $data['mailbox']['lastPage'] && $data['mailbox']['currentPage'] !=
                ($data['mailbox']['lastPage']-1))
                <?php $search["page"]= $data['mailbox']['currentPage']+2; ?>
                <li class="">
                    <a href="{{ route("mail_box", $search) }}">{{$data['mailbox']['currentPage']+2}}</a>
                </li>
                @endif

                @if($data['mailbox']['currentPage'] == $data['mailbox']['lastPage'])
                <li class="page-item disabled" aria-disabled="true" aria-label="Next »">
                    <span class="page-link" aria-hidden="true">次</span>
                </li>
                @else
                <?php $search["page"] = $data['mailbox']['currentPage'] + 1; ?>
                <li class="page-item">
                    <a class="page-link" href="{{ route("mail_box", $search) }}" rel="next"
                        aria-label="Next »">次</a>
                </li>
                @endif

                <?php $search["page"]= $data['mailbox']['lastPage']; ?>
                <li class="">
                    <a href="{{ route("mail_box", $search) }}">最終</a>
                </li>
              </ul>
              @endif
      </div>
    </div>
  </div>
  </div>
@endsection

<style>
.pageNav01 .active a{
    display: inline-block;
    margin-bottom: 5px;
    padding: 6px 12px;
    background: #aaa;
    border: 1px solid #aaa;
    text-decoration: none;
    vertical-align: middle;
}
</style>
            