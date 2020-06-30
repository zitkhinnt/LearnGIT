@extends('horserace::frontend.layouts.design')
@section('title','Column')
@section('content')


  {{--<div class="plan-head">
    <img src="{{ asset('frontend/images/channel/login/title-result.png') }}" width="860" height="92">
  </div>--}}
  <div class="title">的中実績</div> 
  @if(isset($data['result']["items"]))
    <div id="result">
      <div class="clearfix">
        <ul>           

          @foreach($data['result']["items"] as $key => $item)
            @switch($item["double"])
              @case(DOUBLE_OFF)
               
            <li>
                @if($item["ticket_type"] == TICKET_TYPE_1)
                  <p class="ren cam0{{$item['course']}}">{{ ticketToStr($item["ticket_type"]) }}{{ $item["bike_number_1"] }}-{{ $item["bike_number_2"] }}</p>
                @else
                  <p class="ren cam0{{$item['course']}}">{{ ticketToStr($item["ticket_type"]) }}{{ $item["bike_number_1"] }}-{{ $item["bike_number_2"] }}-{{ $item["bike_number_3"] }}</p>
                @endif
                <div class="result">
                  <p>{{ date_format(date_create($item["date"]), "Y-m-d") }}</p>              
                  <p>{{ $item["course_text"] }} </p>
                  <p class="place">{{array_key_exists($item["place_1"],$data['venue'])?$data['venue'][$item["place_1"]]['name'].$item["race_no_1_num"].'R':''}}</p>                  
                  <p>成功</p>{{--$item["korogashi"] }}成功</p>--}}
                  <p class="acquisition">獲得金額{{ $item["won_man"] . "万" . $item["won_yen"]."円"}}</p>
                </div>
            </li>

              {{--<li>
                <div class="result">
                  <p class="p-race">{{ $item["course_text"] }}</p>
                  <p class="s-race">{{ $item["race_no_1_title"] }}</p>
                  <p class="place">
                    <img src="{{ asset('frontend/images/venue/' . $item["place_1_img"]) }}"/>
                  </p>
                  <p class="race">
                    <img src="{{ asset(raceNoToImg($item["race_no_1_num"])) }} "/>
                  </p>
                  <p class="r-date">"{{ date_format(date_create($item["date"]), "y年m月d日") }}<br>{{ $item["korogashi"] }}
                  </p>
                  <p class="aom">{{ $item["won_man"] . "万" . $item["won_yen"] }}円達成!!</p>
                  <p class="trs01">{{ ticketToStr($item["ticket_type"]) }}</p>
                  @if($item["ticket_type"] == TICKET_TYPE_1)
                    <p class="rank01t">1着</p>
                    <p class="rank01">{{ $item["bike_number_1"] }}</p>
                    <p class="rank02t">2着</p>
                    <p class="rank02">{{ $item["bike_number_2"] }}</p>
                  @else
                    <p class="rank01t">1着</p>
                    <p class="rank01">{{ $item["bike_number_1"] }}</p>
                    <p class="rank02t">2着</p>
                    <p class="rank02">{{ $item["bike_number_2"] }}</p>
                    <p class="rank03t">3着</p>
                    <p class="rank03">{{ $item["bike_number_3"] }}</p>
                  @endif
                </div>
              </li>--}}
              @break

              @case(DOUBLE_ON)
              {{--<li>
                <div class="result">
                  <p class="r-arrow">
                    <img src="{{ asset('frontend/images/channel/login/r-arrow.png') }}" width="70"
                         height="50"/>
                  </p>
                  <p class="p-race">{{ $item["course_text"] }}</p>
                  <p class="s-race">{{ $item["race_no_1_title"] }}</p>
                  <p class="place">
                    <img src="{{ asset('frontend/images/venue/' . $item["place_1_img"]) }}"/>
                  </p>
                  <p class="race2">
                    <img src="{{ asset(raceNoToImg($item["race_no_1_num"])) }} "/>
                  </p>
                  <p class="r-date">"{{ date_format(date_create($item["date"]), "y年m月d日") }}<br>{{ $item["korogashi"] }}
                  </p>
                  <p class="aom">{{ $item["won_man"] . "万" . $item["won_yen"] }}円達成!!</p>
                  <p class="trs02">{{ ticketToStr($item["ticket_type"]) }}</p>
                  <p class="s-race2">{{ $item["race_no_2_title"] }}</p>
                  <p class="place2">
                    <img src="{{ asset('frontend/images/venue/' . $item["place_2_img"]) }}"/>
                  </p>
                  <p class="race3">
                    <img src="{{ asset(raceNoToImg($item["race_no_2_num"])) }} "/>
                  </p>
                </div>
              </li>--}}

              <li>
                @if($item["ticket_type"] == TICKET_TYPE_1)
                  <p class="ren cam0{{$item['course']}}">{{ ticketToStr($item["ticket_type"]) }}{{ $item["bike_number_1"] }}-{{ $item["bike_number_2"] }}=>{{ $item["bike_number_1_2"] }}-{{ $item["bike_number_2_2"] }}</p>
                @else
                  <p class="ren cam0{{$item['course']}}">{{ ticketToStr($item["ticket_type"]) }}{{ $item["bike_number_1"] }}-{{ $item["bike_number_2"] }}-{{ $item["bike_number_3"] }}=>{{ $item["bike_number_1_2"] }}-{{ $item["bike_number_2_2"] }}-{{ $item["bike_number_3_2"] }}</p>
                @endif
                  <div class="result">                     
                    <p>{{ date_format(date_create($item["date"]), "Y-m-d") }}</p>              
                    <p>{{ $item["course_text"] }} </p>
                    <p class="place">{{array_key_exists($item["place_1"],$data['venue'])?$data['venue'][$item["place_1"]]['name'].$item["race_no_1_num"].'R':''}}<span class="red">⇒</span> {{array_key_exists($item["place_2"],$data['venue'])?$data['venue'][$item["place_2"]]['name'].$item["race_no_2_num"].'R':''}}</p>      
                    <p>{{ $item["korogashi"] }}成功</p>                   

                    <p class="acquisition">獲得金額{{ $item["won_man"] . "万" . $item["won_yen"]."円"}}</p>
                  </div>
              </li>
              @break

            @endswitch
          @endforeach

        </ul>
      </div>
    </div>
    <div>
    @if($data['result']['lastPage'] != 0)
    <ul class="pageNav01">
      @if($data['result']['currentPage'] != 0)
        <li>
          <a href="{{ route("result", ["page" => ($data['result']['currentPage'] - 1)]) }}">&laquo; 前</a>
        </li>
      @endif
      @for ($i = 0 ; $i <= $data['result']['lastPage'] ; $i++)
        <!-- dat limit show only 3 page -->
        @if($i <= 2)
          @if($data['result']['currentPage'] == $i)
            <li><span>{{ $i + 1 }}</span></li>
          @else
            <li class="{!! ($data['result']['currentPage'] == $i) ? 'active' : '' !!}">
              <a href="{{ route("result", ["page" => $i]) }}">{!! $i + 1  !!}</a>
            </li>
          @endif
        @endif
      @endfor
      <!-- dat limit show only 3 page -->
      @if($data['result']['currentPage'] <= 1)
        @if ($data['result']['currentPage'] != $data['result']['lastPage'])
          <li>
            <a href="{{ route("result", ["page" => ($data['result']['currentPage'] + 1)]) }}">次 &raquo;</a>
          </li>
        @endif
      @endif
    </ul>
  @endif
    </div>

  @endif
@endsection