@extends('horserace::frontend.layouts.design')
@section('title','')
@section('content')

    <!-- group prediction type logo -->
    {{--<div class="plan-head">--}}
        <style>
            .r_color
            {
                background: #8e4ac1 !important;
            }
        </style>
        <?php $back_ground_color="";?>
    <div id="cam">
            {{--<div class="cam-area">--}}
                    <div class="cam-area">
                            @if (Session::has('flash_message'))
                        <div class="alert alert-{!! Session::get('flash_level') !!}"
                                style="height: 50px; font-size: 20px; text-align: center; background: white;">
                            {!! Session::get('flash_message') !!}
                        </div>
                        @endif                                    
                        <img src="{{ asset($data['prediction_type']->image) }} "/>
          
            <p class="cam-head">
        @switch($data['prediction_type']->code)
        @case(PREDICTION_TYPE_CODE_C1)
            <img src="{{ asset('frontend/images/channel/login/banner01.png') }}"/>
            <?php $back_ground_color="#000";?>
            @break
        @case(PREDICTION_TYPE_CODE_C2)
            <img src="{{ asset('frontend/images/channel/login/banner02.png') }}"/>
            <?php $back_ground_color="#000";?>
            @break
        @case(PREDICTION_TYPE_CODE_C3)
            <img src="{{ asset('frontend/images/channel/login/banner03.png') }}"/>
            <?php $back_ground_color="#000";?>
            @break
        @case(PREDICTION_TYPE_CODE_C4)
            <img src="{{ asset('frontend/images/channel/login/banner04.png') }}"/>
            <?php $back_ground_color="#000";?>
            @break
        @case(PREDICTION_TYPE_CODE_C5)
            <img src="{{ asset('frontend/images/channel/login/banner05.png') }}" />
            <?php $back_ground_color="#000";?>
            @break
        @case(PREDICTION_TYPE_CODE_C6)
            <img src="{{ asset('frontend/images/channel/login/banner06.png') }}"/>
            <?php $back_ground_color="#000";?>
            @break
        @case(PREDICTION_TYPE_CODE_C7)
            <img src="{{ asset('frontend/images/channel/login/banner07.png') }}"/>
            <?php $back_ground_color="#000";?>
            @break
        @case(PREDICTION_TYPE_CODE_C8)
            <img src="{{ asset('frontend/images/channel/login/banner08.png') }}"/>
            <?php $back_ground_color="#000";?>
            @break
        @case(PREDICTION_TYPE_CODE_C9)
            <img src="{{ asset('frontend/images/channel/login/banner09.png') }}" />
            <?php $back_ground_color="#fff";?>
            @break
        @case(PREDICTION_TYPE_CODE_C10)
            <img src="{{ asset('frontend/images/channel/login/banner10.png') }}" />
            <?php $back_ground_color="#fff";?>
            @break
        @default
            @break
        @endswitch
        </p>
    </div>
    {{--</div>--}}

    <!-- group prediction type detail -->
    {{--@if (Session::has('flash_message'))
        <div class="alert alert-{!! Session::get('flash_level') !!}"
             style="height: 50px; font-size: 20px; text-align: center">
            {!! Session::get('flash_message') !!}
        </div>
    @endif--}}
    {{--<div class="cam" style="background: {{$back_ground_color}}; border: 0px;">   
            @if (Session::has('flash_message'))
            <div class="alert alert-{!! Session::get('flash_level') !!}"
                    style="height: 50px; font-size: 20px; text-align: center; background: white;">
                {!! Session::get('flash_message') !!}
            </div>
            @endif
     
        <div class="column-info">
                        <div class="info">
                <p><img src="{{ asset($data['prediction_type']->image) }} " width="100%"/></p>
            </div>
         </div>
           
        </div>--}}
        <div class="cam">
            @switch($data['prediction_type']->code)
            @case(PREDICTION_TYPE_CODE_C1)
                <p>競輪チャンネルでは毎日「無料予想」を公開しております。<br>
                <br>
                弊社にて入手している情報の中で有料予想としての水準に満たないものを公開しております。的中率・回収率ともに有料情報よりは低くなってしまいますが、厳選した情報を提供致します。<br>
                まずは無料にて、弊社の「予想力」を体感<br>
                </p>
            @break
            @case(PREDICTION_TYPE_CODE_C2)
                <p>【B級】は競輪「初心者様向け」のプランとなります。<br>
                競輪予想がどんなものか知りたい、まずは的中させてみたい方は是非お試しください。<br>
                <br>
                提供は1回1レースで目標金額は50,000円となります。<br>
                競輪を知り、的中の楽しさを知ってください。<br>
                </p>
            @break
            @case(PREDICTION_TYPE_CODE_C3)
                <p>【A級3】は競輪「コロガシ予想」のプランとなります。<br>
                <br>
                競輪予想で配当を狙うには「コロガシ」と呼ばれる方法が主流です。<br>
                「コロガシ」とは1レース目で得た払戻をすべて2レース目の車券代に投資し、獲得金を大きくしていく手法です。<br>
                <br>
                提供は1回2レースで目標金額は100,000円となります。<br>
                コロガシ予想で成功体験を知ってください。<br>
                </p>
            @break
            @case(PREDICTION_TYPE_CODE_C4)
                <p>【A級2】は上位コロガシプランへの軍資金作り、また日常で少し贅沢をしたいと思える方向けのプランとなります。<br>
                あくまでもここは、コロガシ初級者からコロガシ中級者へのステップアップの過程‥<br>
                <br>
                提供は1回2レース、目標金額は200,000円となります。<br>
                A級1ワンへの軍資金稼ぎ、コンスタントな副収入を望む方々に大変ご好評をいただいているプランです。<br>
                </p>
            @break
            @case(PREDICTION_TYPE_CODE_C5)
                <p>【A級1】はコロガシ中級者向けのバランスプランとなります。<br>
                競輪コロガシ予想の妙味をご理解いただき、的中と配当の抜群の両立‥<br>
                <br>
                提供は1回2レース、目標金額は500,000円となります。<br>
                A級でも十分な結果を得られますが、この先にあるＳ級を知りたい方、この収益では満足いかない方も多いです。<br>
                リピート率ＮＯ.１のプランです。<br>
                </p>
            @break
            @case(PREDICTION_TYPE_CODE_C6)
                <p>【S級2】ここからは利益追求のＳ級、「回収率」に重きを置いたプランとなります。<br>
                新聞や雑誌には出ない裏情報、穴選手、会場からのリアルタイム速報、オッズの妙味を判断し配当を狙い撃ちます。<br>
                <br>
                提供は1回2レースで目標金額は1,000,000円となります。<br>
                生活が一変するほどの配当‥<br>
                札束の"帯"を掴む快感‥<br>
                競輪予想で100万以上の高配当を狙ってみたい方は必参です。<br>
                </p>
            @break
            @case(PREDICTION_TYPE_CODE_C7)
                <p>【S級1】その日行われるレースの中から選び抜いた厳選2レース。<br>
                高配当を狙う上で最も重要になるのが「情報精度」<br>
                当然「的中精度」も満たした至極のコロガシ情報をご提供致します。<br>
                <br>
                提供は1回2レースで目標金額は2,500,000円となります。<br>
                セレブが日常に‥<br>
                「圧倒的な高配当」情報で、欲しいと思った物を買える、行きたい場所にいつでも行ける生活を手にしてください。<br>
                ※オッズへの影響を踏まえ、ご参加をお断りさせていただく可能性がございますので予めご了承くださいませ。<br>
                </p>
            @break
            @case(PREDICTION_TYPE_CODE_C8)
                <p>【S級S】選ばれし競輪予想、完全不定期「参加枠制限あり」の最上級プラン。<br>
                独占契約を結んでいるプロ予想家、元選手、現役選手の情報網などとの独自コネクションを持っております。<br>
                <br>
                提供は1回2レースで目標金額は5,000,000円となります。<br>
                一流を知る者は一流を感じる‥<br>
                競輪チャンネル最高の必勝プランとなります。<br>
                競輪投資における「成功者」になるのは貴方です。<br>
                </p>
            @break
            @case(PREDICTION_TYPE_CODE_C9)
                <p>星マークがついた当プランが案内されたときは絶好のチャンス！<br>
                貴方時々で貴方にあったアレンジプランをご案内します。<br>
                「不定期」でのご案内となるので、お見逃すことなかれ。<br>
                <br>
                提供レース数、目標金額、参加枠、参加料金は随時ご連絡いたします。<br>
                </p>
            @break
            @case(PREDICTION_TYPE_CODE_C10)
                <p>【ミッドナイト】は全レース7車立てで的中率が高いので、初心者様でもおすすめです。<br>
                    21時～23時過ぎまで開催されているので、お仕事終わりでも参加できます。<br>
                <br>
                提供は1回2レース、目標金額は300,000円となります。<br>
                夜の時間でも稼ぎ、お忙しい方でも大満足いただけるプランです。<br>
                </p>
            @break
            @default
            @break
            @endswitch
        </div>
        <table  class="cam<?php
                switch ($data['prediction_type']->code) {
                    case PREDICTION_TYPE_CODE_C1:
                        echo '01';
                        break;
                    case PREDICTION_TYPE_CODE_C2:
                        echo '02';
                        break;
                    case PREDICTION_TYPE_CODE_C3:
                        echo '03';
                        break;
                    case PREDICTION_TYPE_CODE_C4:
                        echo '04';
                        break;
                    case PREDICTION_TYPE_CODE_C5:
                        echo '05';
                        break;
                    case PREDICTION_TYPE_CODE_C6:
                        echo '06';
                        break;
                    case PREDICTION_TYPE_CODE_C7:
                        echo '07';
                        break;
                    case PREDICTION_TYPE_CODE_C8:
                        echo '08';
                        break;
                    case PREDICTION_TYPE_CODE_C9:
                        echo '09';
                        break;
                    case PREDICTION_TYPE_CODE_C10:
                        echo '10';
                        break;
                    default:
                        break;
                }
            ?>">
            @if ($data['prediction_type']->code == PREDICTION_TYPE_CODE_C10)
            <tbody>
                <tr>
                    <th>提供レース数</th>
                    <td>{{$data['prediction_type']->table_params->number_of_offers}}</td>
                </tr>
                <tr>
                    <th>目標金額</th>
                    <td>{{$data['prediction_type']->table_params->target_amount}}</td>
                </tr>
                <tr>
                    <th>締切</th>
                    <td>{{$data['prediction_type']->table_params->deadline_for_participation}}</td>
                </tr>
                <tr>
                    <th >公開</th>
                    <td>{{$data['prediction_type']->table_params->release_time}}</td>
                </tr>
                <tr>
                    <th>対象</th>
                    <td>{{$data['prediction_type']->table_params->target_race}}</td>
                </tr>
                <tr>
                    <th>参加料金</th>
                    <td>{{$data['prediction_type']->table_params->participation_fee}}</td>
                </tr>
            </tbody>
            @else
            <tbody>
                <tr>
                    <th>提供数</th>
                    <td>{{$data['prediction_type']->table_params->number_of_offers}}</td>
                </tr>
                <tr>
                    <th>券種</th>
                    <td>{{$data['prediction_type']->table_params->denomination}}</td>
                </tr>
                <tr>
                    <th>点数</th>
                    <td>{{$data['prediction_type']->table_params->score}}</td>
                </tr>
                <tr>
                    <th>投資金</th>
                    <td>{{$data['prediction_type']->table_params->investment_money}}</td>
                </tr>
                <tr>
                    <th>目標金額</th>
                    <td>{{$data['prediction_type']->table_params->target_amount}}</td>
                </tr>
                <tr>
                    <th>参加締め切り</th>
                    <td>{{$data['prediction_type']->table_params->deadline_for_participation}}</td>
                </tr>
                <tr>
                    <th >公開時間</th>
                    <td>{{$data['prediction_type']->table_params->release_time}}</td>
                </tr>
                <tr>
                    <th>対象レース</th>
                    <td>{{$data['prediction_type']->table_params->target_race}}</td>
                </tr>
                <tr>
                    <th>参加費用</th>
                    <td>{{$data['prediction_type']->table_params->participation_fee}}</td>
                </tr>
            </tbody>
            @endif
            </table>

                <!-- group prediction list -->
                
            <div id="cam-btn">
                <div class="clearfix">
                    @foreach($data["list_prediction"] as $item)                    
                        <?php 
                            $day_of_week = date('w', strtotime($item->info_start_time));
                            if($day_of_week==0)
                                $day_of_week = 'sun';
                            elseif ($day_of_week==6)         
                                $day_of_week = 'sat';
                            else 
                                $day_of_week = '';   

                         ?>
                            <!-- Status -->
                            @switch($item->status)
                                @case(PREDICTION_STATUS_OPEN)
                                    @if($item->user_buy == NOT_BUY_PREDICTION)                                     
                                        
                                    
                                        <form id="buy-prediction" method="POST" action="{{ route("buy_prediction") }}">                                                
                                            {{ csrf_field() }}
                                            <dl>                                                
                                            <dt> {{ date('m月d日', strtotime($item->info_start_time)) }} <span class = "{{$day_of_week}}">({{DayOfWeekToJa(strtotime($item->info_start_time))}})</span></dt>
                                                    <dd>
                                                        <input type="hidden" name="prediction_id" value="{{ $item->id }}">

                                                        <div class="btn-area"><button  type="submit" class="btn01">販売中</button></div>
                                                    </dd>
                                            </dl>
                                            {{--<input type="hidden" name="prediction_id" value="{{ $item->id }}">
                                            <button  style="width:100%; border: none !important;" class="btn01" type="submit">
                                                {{ replaceDayOfWeekJa(date('m月d日', strtotime($item->info_start_time))) }}情報に「参加する」
                                            </button>--}}
                                        </form>
                                   
                                    @else
                                        @if(Carbon\Carbon::now()->gte(Carbon\Carbon::parse($item->info_start_time)))
                                            <dl>
                                                <dt> {{ date('m月d日', strtotime($item->info_start_time)) }}<span class = "{{$day_of_week}}">({{DayOfWeekToJa(strtotime($item->info_start_time))}})</span></dt>
                                                <dd>
                                                    <input type="hidden" name="prediction_id" value="{{ $item->id }}">
                                                    <div class="btn-area"><a class="btn01" href="{{route('prediction_detail', ['id_prediction' => $item->id])}}">買い目を見る </a></div>
                                                </dd>
                                            </dl>

                                               {{-- <a  style="width:100%; border: none !important;" class="btn01" href="{{route('prediction_detail', ['id_prediction' => $item->id])}}">
                                                    {{ replaceDayOfWeekJa(date('m月d日', strtotime($item->info_start_time))) }}<img style="height: 25px;" src="{{ asset('frontend/images/channel/login/kip.svg') }}" />「買い目を見る」
                                                </a>--}}
                                           
                                            @else
                                                <dl>
                                                    <dt> {{ date('m月d日', strtotime($item->info_start_time)) }}<span class = "{{$day_of_week}}">({{DayOfWeekToJa(strtotime($item->info_start_time))}})</span></dt>
                                                    <dd>
                                                        <input type="hidden" name="prediction_id" value="{{ $item->id }}">
                                                        <div class="btn-area"><a class="btn01">買い目を見る</a></div>
                                                    </dd>
                                                </dl>
                                            
                                                {{--<a style="width:100%; border: none !important;" class="btn04"> --}} {{-- href="{{route('prediction_detail', ['id_prediction' => $item->id])}}"> --}}
                                                    {{--{{ replaceDayOfWeekJa(date('m月d日', strtotime($item->info_start_time))) }}情報「購入済」--}}
                                                {{--</a>--}}
                                            
                                        @endif
                                    @endif
                                @break

                                @case(PREDICTION_STATUS_REMAIN)
                                    @if($item->user_buy == NOT_BUY_PREDICTION)
                                        <form id="buy-prediction" method="POST" action="{{ route("buy_prediction") }}">
                                            {{ csrf_field() }}
                                                <dl>
                                                    <dt> {{ date('m月d日', strtotime($item->info_start_time)) }}<span class = "{{$day_of_week}}">({{DayOfWeekToJa(strtotime($item->info_start_time))}})</span></dt>
                                                    <dd>
                                                        <input type="hidden" name="prediction_id" value="{{ $item->id }}">
                                                        <div class="btn-area"><button type="submit" class="btn01">残りわずか</button></div>                                                
                                                    </dd>
                                                </dl>
                                                
                                        </form>
                                
                                    @else
                                        @if(Carbon\Carbon::now()->gte(Carbon\Carbon::parse($item->info_start_time)))

                                            <dl>
                                                <dt> {{ date('m月d日', strtotime($item->info_start_time)) }}<span class = "{{$day_of_week}}">({{DayOfWeekToJa(strtotime($item->info_start_time))}})</span></dt>
                                                <dd>
                                                        <div class="btn-area"><a class="btn01" href="{{route('prediction_detail', ['id_prediction' => $item->id])}}">      
                                                                買い目を見る</a></div>
                                                </dd>
                                            </dl>
                                           
                                        @else
                                            <dl>
                                                <dt> {{ date('m月d日', strtotime($item->info_start_time)) }}<span class = "{{$day_of_week}}">({{DayOfWeekToJa(strtotime($item->info_start_time))}})</span></dt>
                                                <dd>
                                                        <div class="btn-area"><a class="btn01"> {{-- href="{{route('prediction_detail', ['id_prediction' => $item->id])}}"> --}}
                                                   
                                                                買い目を見る</a></div>
                                                </dd>
                                            </dl>
                                        @endif
                                    @endif
                                @break

                                @case(PREDICTION_STATUS_DONE)
                                    @if($item->user_buy == NOT_BUY_PREDICTION)
                                        <dl>
                                            <dt> {{ date('m月d日', strtotime($item->info_start_time)) }}<span class = "{{$day_of_week}}">({{DayOfWeekToJa(strtotime($item->info_start_time))}})</span></dt>
                                            <dd>
                                                    <div class="btn-area"><p class="btn02">完売</p></div>
                                            </dd>
                                        </dl>
                                     
                                    @else
                                        @if(Carbon\Carbon::now()->gte(Carbon\Carbon::parse($item->info_start_time)))
                                            <dl>
                                                <dt> {{ date('m月d日', strtotime($item->info_start_time)) }}<span class = "{{$day_of_week}}">({{DayOfWeekToJa(strtotime($item->info_start_time))}})</span></dt>
                                                <dd>
                                                        <div class="btn-area"><a class="btn01" href="{{route('prediction_detail', ['id_prediction' => $item->id])}}">                                                  
                                                                買い目を見る</a></div>
                                                </dd>
                                            </dl>
                                            
                                            
                                        @else
                                            <dl>
                                                <dt> {{ date('m月d日', strtotime($item->info_start_time)) }}<span class = "{{$day_of_week}}">({{DayOfWeekToJa(strtotime($item->info_start_time))}})</span></dt>
                                                <dd>
                                                    <div class="btn-area"><a class="btn01">{{-- href="{{route('prediction_detail', ['id_prediction' => $item->id])}}">--}}
                                                
                                                    買い目を見る</a></div>
                                                </dd>
                                            </dl>
                                           
                                        @endif
                                    @endif
                                @break
                                @default
                                @break
                            @endswitch
                        @endforeach
                    </div>
                </div>
            </div>
        {{--<div class="btn-area2"><a  style="{{$data['prediction_type']->code == PREDICTION_TYPE_CODE_C4? 'background: #f7db42;':'background: white;'}}"  href="{{route('course')}}" class="btn05">一覧を見る</a></div>--}}
        {{--</div>--}}    
        
    
    </div>

@endsection
<script>
    
    window.addEventListener( "pageshow", function ( event )
    {
        var historyTraversal = event.persisted || 
                            ( typeof window.performance != "undefined" && 
                                window.performance.navigation.type === 2 );
        if ( historyTraversal )
        {
        // Handle page restore.;
        window.location.reload();
        }
    });
 </script>