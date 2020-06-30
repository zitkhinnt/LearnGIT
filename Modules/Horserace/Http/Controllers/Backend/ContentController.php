<?php

namespace Modules\Horserace\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Horserace\Repositories\BlogRepositories;
use Modules\Horserace\Repositories\GiftRepositories;
use Modules\Horserace\Repositories\ResultRepositories;
use Modules\Horserace\Http\Requests\BlogRequest;
use Modules\Horserace\Http\Requests\GiftRequest;
use Modules\Horserace\Http\Requests\ResultRequest;
use Modules\Horserace\Repositories\VenueRepositories;
use Modules\Horserace\Repositories\PredictionTypeRepositories;

class ContentController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:admin');
    $this->middleware('admin');
  }

  public function blog(Request $request,
                       BlogRepositories $blogRepositories)
  {
    $data = $blogRepositories->getListBlog();
    return view('horserace::backend.blog.list_blog', compact('data'));
  }

  public function addBlog(Request $request)
  {
    return view('horserace::backend.blog.add_blog');
  }

  public function editBlog(Request $request,
                           BlogRepositories $blogRepositories, $id)
  {
    $data['edit'] = $blogRepositories->getEditBlog($id);
    return view('horserace::backend.blog.edit_blog', compact('data'));
  }

  public function storeBlog(BlogRequest $request,
                            BlogRepositories $blogRepositories)
  {
    $input = $request->all();
    $input['status'] = BLOG_STATUS_0; //0 star 🌟 
    $result = $blogRepositories->blogStore($input);
    return redirect()->route('admin.blog')->with([
      'flash_level' => $result["status"],
      'flash_message' => $result["message"],
    ]);
  }

  public function deleteBlog(Request $request,
                             BlogRepositories $blogRepositories)
  {
    $blog_id = $request->id_delete;
    $result = $blogRepositories->blogDelete($blog_id);
    return redirect()->route('admin.blog')->with([
      'flash_level' => $result["status"],
      'flash_message' => $result["message"],
    ]);
  }

  public function reviewBlog(Request $request,
                             BlogRepositories $blogRepositories, $id)
  {
    $data = $blogRepositories->getEditBlog($id);
    return view('horserace::backend.review_fe.content', compact('data'));
  }

  /** Gift **/
  public function gift(Request $request,
                       GiftRepositories $giftRepositories)
  {
    $data = $giftRepositories->getListGift();
    return view('horserace::backend.gift.list_gift', compact('data'));
  }

  public function addGift(Request $request)
  {
    return view('horserace::backend.gift.add_gift');
  }

  public function editGift(Request $request,
                           GiftRepositories $giftRepositories, $id)
  {
    $data['gift'] = $giftRepositories->getEditGift($id);
    return view('horserace::backend.gift.edit_gift', compact('data'));
  }

  public function storeGift(GiftRequest $request,
                            GiftRepositories $giftRepositories)
  {
    $input = $request->all();
    $result = $giftRepositories->giftStore($input);
    return redirect()->route('admin.gift')->with([
      'flash_level' => $result["status"],
      'flash_message' => $result["message"],
    ]);
  }

  public function deleteGift(Request $request,
                             GiftRepositories $giftRepositories)
  {
    $gift_id = $request->id_delete;
    $result = $giftRepositories->giftDelete($gift_id);
    return redirect()->route('admin.gift')->with([
      'flash_level' => $result["status"],
      'flash_message' => $result["message"],
    ]);
  }

  // result
  public function result(Request $request,
  ResultRepositories $resultRepositories,
                         VenueRepositories $venueRepositories)
  {
    $list_venue = $venueRepositories->getListVenue();
    $arr_venue = array();
    $arr_venue[0]["name"] = "";
    foreach ($list_venue as $item) {
      $arr_venue[$item->id] = (array)$item;
    }
    $data = $resultRepositories->getListResult();
    $venue = $arr_venue;
    
    return view('horserace::backend.result.result_list', compact('data', 'venue'));
  }

  public function resultAjax(Request $request,  ResultRepositories $resultRepositories, VenueRepositories $venueRepositories)
  {
    $input = $request->all();
    $result = $resultRepositories->getListSearchResult($input);

    $data = [
      "draw" => 0,
      "recordsTotal" => $result['total'],
      "recordsFiltered" => $result['total'],
    ];
    // 
    $list_venue = $venueRepositories->getListVenue();
    $arr_venue = array();
    $arr_venue[0]["name"] = "";
    foreach ($list_venue as $item) {
      $arr_venue[$item->id] = (array) $item;
    }
    $venue = $arr_venue;
    // 
    $data['data'] = array();
    foreach ($result['result'] as $item) {
      $data['data'][] = [
        $item->id,
        $item->course_text,
        doubleToStr('horserace', $item->double),
        $item->race_no_1_title . " - " . raceNoStr('horserace', $item->race_no_1_num) . " - " . $venue[$item->place_1]["name"],
        $item->race_no_2_title . " - " . raceNoStr('horserace', $item->race_no_2_num) . " - " . $venue[$item->place_2]["name"],
        $item->korogashi,
        ticketToStr('horserace', $item->ticket_type),
        "1着:" . $item->bike_number_1 . "; 2着: " . $item->bike_number_2 . "; 3着: " . $item->bike_number_3,
        $item->won_man . "万" .  $item->won_yen . "円",
        date_format(date_create($item->date), "Y-m-d"),
        '<a class="btn btn-outline-info btn-rounded" href="' . route("admin.result.edit", $item->id) . '"><span class="btn-icon"> <i class="ti ti-pencil"></i> 編集</span></a>',
        '<button type="button" class="btn btn-outline-danger btn-rounded" data-idDelete="' . $item->id . '" data-title="' . $item->course . '" data-toggle="modal" data-target="#ModalDelete"><span class="btn-icon"><i class="ti-trash"></i>削除</span></button>',
      ];
    }
    return response()->json($data);
  }


  public function addResult(Request $request,
                            VenueRepositories $venueRepositories, 
                            PredictionTypeRepositories $predictionTypeRepositories)
  {
    $data["venue"] = $venueRepositories->getListVenue();
    $data['prediction_type'] = $predictionTypeRepositories->getPredictionType();
    return view('horserace::backend.result.result_add', compact("data"));
  }


 

  public function storeResult(ResultRequest $request,
                              ResultRepositories $resultRepositories,
                              PredictionTypeRepositories $predictionTypeRepositories,
                              VenueRepositories $venueRepositories)
  {
    $input = $request->all();
    $pre_type = $predictionTypeRepositories->getPredictionTypeById($input['course']);
    $input['course_text'] = ($pre_type!=null?$pre_type->name:'');    

    if(isset($input['place_1']))
    {
      $venue = $venueRepositories->getEditVenue($input['place_1']);
      if($venue!=null)
      {
        $input['race_no_1_title'] = $venue->name;
        if(isset($input['race_no_1_num']))
        $input['race_no_1_title'].=$input['race_no_1_num'].'R';
      }
    }
    else
      $input['race_no_1_title'] = '';

    if(isset($input['place_2']))
    {
      $venue = $venueRepositories->getEditVenue($input['place_2']);
      if($venue!=null)
      {
        $input['race_no_2_title'] = $venue->name;
        if(isset($input['race_no_2_num']))
        $input['race_no_2_title'].=$input['race_no_2_num'].'R';
      }
    }
    else
      $input['race_no_2_title'] = '';


    $result = $resultRepositories->resultStore($input);
    return redirect()->route('admin.result')->with([
      'flash_level' => $result["status"],
      'flash_message' => $result["message"],
    ]);
  }

  public function editResult(Request $request,
                             ResultRepositories $resultRepositories,
                             VenueRepositories $venueRepositories,
                             PredictionTypeRepositories $predictionTypeRepositories, $id)
  {
    $data["venue"] = $venueRepositories->getListVenue();
    $data['result'] = $resultRepositories->getEditResult($id);
    $data['prediction_type'] = $predictionTypeRepositories->getPredictionType();
    return view('horserace::backend.result.result_edit', compact('data'));
  }

  public function deleteResult(Request $request,
                               ResultRepositories $resultRepositories)
  {
    $result_id = $request->id_delete;
    $result = $resultRepositories->resultDelete($result_id);
    return redirect()->route('admin.result')->with([
      'flash_level' => $result["status"],
      'flash_message' => $result["message"],
    ]);
  }
}
