<?php
/**
 * Date: 2018-10-09
 */

namespace Modules\Horserace\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;
use Session, Auth;
use Modules\Horserace\Repositories\BlogRepositories;
use Modules\Horserace\Repositories\PointRepositories;
use Modules\Horserace\Repositories\MailContactRepositories;
use Modules\Horserace\Repositories\PredictionRepositories;
use Modules\Horserace\Repositories\PredictionTypeRepositories;
use Modules\Horserace\Entities\Page;

class PageController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:web');
    $this->middleware('user_activity');
  }

  /*public function getHome(Request $request)
  {
    $input = $request->all();
    if (isset($input["deposit"])) {
      // Have deposit
      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.user_deposit_success"),
      ];
      $request->session()->flash('flash_level', $result["status"]);
      $request->session()->flash('flash_message', $result["message"]);
      return view('horserace::frontend.home');
    } else {

      return view('horserace::frontend.home');
    }
  }*/
  public function getHome(Request $request, PredictionTypeRepositories $prediction_typeRepositories)
  {
    $input = $request->all();
    $data = $prediction_typeRepositories->getPredictionType();
    if (isset($input["deposit"])) {
      // Have deposit
      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.user_deposit_success"),
      ];
      $request->session()->flash('flash_level', $result["status"]);
      $request->session()->flash('flash_message', $result["message"]);
      return view('horserace::frontend.home', compact('data'));
    } else {

      return view('horserace::frontend.home', compact('data'));
    }
  }

  public function getCourse(Request $request, PredictionTypeRepositories $prediction_typeRepositories)
  {
    $input = $request->all();
    $data = $prediction_typeRepositories->getPredictionType();
    return view('horserace::frontend.course.course', compact('data'));
    
  }

  public function getHomePost(Request $request)
  {
    $input = $request->all();
    if (isset($input["deposit"])) {
      // Have deposit
      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.user_deposit_success"),
      ];
      $request->session()->flash('flash_level', $result["status"]);
      $request->session()->flash('flash_message', $result["message"]);
      return view('horserace::frontend.home');
    } else {

      return view('horserace::frontend.home');
    }
  }

  public function aboutOne(Request $request)
  {
    return view('horserace::frontend.about.about_one');
  }

  public function aboutTwo(Request $request)
  {
    return view('horserace::frontend.about.about_two');
  }

  public function aboutThree(Request $request)
  {
    return view('horserace::frontend.about.about_three');
  }
  public function getAbout(Request $request)
  {
    $obj_page = new Page();    
    $about_page = $obj_page->getPageByCode('about');
    $data['page'] = (array)$about_page;
    return view('horserace::frontend.page.about',compact('data'));
  }

  public function getList(Request $request)
  {
    return view('horserace::frontend.page.list');
  }

  public function getFAQ(Request $request)
  {
    return view('horserace::frontend.page.faq');
  }

  public function getAgree(Request $request)
  {
    $obj_page = new Page();    
    $agree_page = $obj_page->getPageByCode('agree');
    $data['page'] = (array)$agree_page;
    return view('horserace::frontend.page.agree', compact('data'));
  }

  public function getPrivacy(Request $request)
  {
    $obj_page = new Page();    
    $privacy_page = $obj_page->getPageByCode('privacy');
    $data['page'] = (array)$privacy_page;
    return view('horserace::frontend.page.privacy', compact('data'));
  }

  public function getTrans(Request $request)
  {
    $obj_page = new Page();    
    $trans_page = $obj_page->getPageByCode('trans');
    $data['page'] = (array)$trans_page;
    return view('horserace::frontend.page.trans');
  }
  public function getVoice(Request $request)
  {
    $obj_page = new Page();    
    $voice_page = $obj_page->getPageByCode('voice');
    $data['page'] = (array)$voice_page;
    return view('horserace::frontend.page.voice', compact('data'));
  }
  public function getDocomoMail(Request $request)
  {
    $obj_page = new Page();    
    $trans_page = $obj_page->getPageByCode('trans');
    $data['page'] = (array)$trans_page;
    return view('horserace::frontend.page.docomomail');
  }

  // bicycle race
  public function mypage()
  {
    return view('horserace::frontend.layouts.page_home.mypage');
  }

  // end br

  /* point start */
  public function getPoint(Request $request,
   PointRepositories $pointRepositories)
  {
    $data['point'] = $pointRepositories->getListPoint();
    return view('horserace::frontend.point.point', compact('data'));
  }

  /* point end */

}