<?php

namespace Modules\Horserace\Http\Controllers\Partner;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Horserace\Repositories\MediaRepositories;
use Modules\Horserace\Repositories\UserDailyAccessHistoryRepositories;
use Modules\Horserace\Repositories\UserDailyLoginHistoryRepositories;

class PartnerControllers extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:admin');
    $this->middleware('partner');
  }

  public function summaryAccessPartner(Request $request,
                                       UserDailyAccessHistoryRepositories $userDailyAccessHistoryRepositories)
  {
    $media_code = Auth::user()->media_code;
    $data["media_code"] = $media_code;
    return view('horserace::partner.summary.summary_media', compact("data"));
  }

  public function summaryAccessPartnerAjax(Request $request,
                                           UserDailyAccessHistoryRepositories $userDailyAccessHistoryRepositories)
  {
    $billing_flg = Auth::user()->billing_flg;
    $data = $request->all();
    $media_code = trim($data["media_code"]);
    $timestamp = strtotime($data['start_month']);

    $month = date('m', $timestamp);
    $year = date('Y', $timestamp);
    $day = date('d', $timestamp);

    // Summary
    $result["access"] = $userDailyAccessHistoryRepositories->partnerSummaryAccess($year, $month, $media_code, $billing_flg);

    $result['month'] = $month;
    $result['year'] = $year;
    $result['day'] = $day;

    // Last day of month
    $last_day = date("Y-m-t", strtotime($data['start_month']));
    $result['month_end'] = date('m', strtotime($last_day));
    $result['year_end'] = date('Y', strtotime($last_day));
    $result['day_end'] = date('d', strtotime($last_day));

    return json_encode($result);
  }

  public function summaryAccessPartnerSortAjax(Request $request,
                                               UserDailyAccessHistoryRepositories $userDailyAccessHistoryRepositories)
  {
    $data = $request->all();
    $sort = [
      "year_start" => $data["year_start"],
      "month_start" => $data["month_start"],
      "day_start" => $data["day_start"],
      "year_end" => $data["year_end"],
      "month_end" => $data["month_end"],
      "day_end" => $data["day_end"],
      'media_code' => trim($data["media_code"]),
      'billing_flg' => Auth::user()->billing_flg,
    ];

    $result["access"] = $userDailyAccessHistoryRepositories->partnerSummaryAccessSort($sort);

    $result['month'] = $data["month_start"];
    $result['year'] = $data["year_start"];
    $result['day'] = $data["day_start"];

    // Last day of month
    $result['month_end'] = $data["month_end"];
    $result['year_end'] = $data["year_end"];
    $result['day_end'] = $data["day_end"];

    return json_encode($result);
  }

  public function summaryAccessDetailPartner(Request $request,
                                             MediaRepositories $mediaRepositories,
                                             UserDailyAccessHistoryRepositories $userDailyAccessHistoryRepositories,
                                             $media_code)
  {
    $data["media_code"] = $media_code;
    $data["media"] = $mediaRepositories->getMediaByCode($media_code);
    return view('horserace::partner.summary.summary_media_detail', compact("data"));
  }

  public function summaryAccessDetailPartnerAjax(Request $request,
                                                 UserDailyAccessHistoryRepositories $userDailyAccessHistoryRepositories)
  {
    $data = $request->all();
    $media_code = trim($data["media_code"]);
    $timestamp = strtotime($data['start_month']);

    $month = date('m', $timestamp);
    $year = date('Y', $timestamp);
    $day = date('d', $timestamp);

    // Summary
    $result["access"] = $userDailyAccessHistoryRepositories->partnerSummaryAccessDaily($year, $month, $media_code);

    $result['month'] = $month;
    $result['year'] = $year;
    $result['day'] = $day;

    return json_encode($result);
  }
}
