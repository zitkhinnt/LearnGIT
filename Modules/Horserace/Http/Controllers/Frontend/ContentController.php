<?php
/**
 * Date: 2018-10-09
 */

namespace Modules\Horserace\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;
use Modules\Horserace\Repositories\BlogRepositories;
use Modules\Horserace\Repositories\ResultRepositories;
use Modules\Horserace\Repositories\VenueRepositories;
use Session, Auth;

class ContentController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:web');
    $this->middleware('user_activity');
  }

  /*  public function getColumn(Request $request,
                              BlogRepositories $blogRepositories)
    {
      $data['blog'] = $blogRepositories->getListBlogPublic();
      return view('horserace::frontend.content.column', compact('data'));
    }*/

  public function getFree(Request $request,
                          BlogRepositories $blogRepositories)
  {
    $user_id = Auth::user()->id;

    $data['blog'] = $blogRepositories->getFristBlogPublic();
    if($data['blog']!=null)
    {
      $data['blog_detail'] = $blogRepositories->feGetBlogDetail($user_id, $data['blog']->id);
      return view('horserace::frontend.content.free', compact('data'));
    }
    else
    {
      $data['no_blog'] = true;
      return view('horserace::frontend.content.free', compact('data'));
    }
  }

  public function getBlogDetail(Request $request,
                                BlogRepositories $blogRepositories, $id)
  {
    $user_id = Auth::user()->id;
    $data['blog_detail'] = $blogRepositories->feGetBlogDetail($user_id, $id);
    $data['blog'] = $blogRepositories->getListBlogPublic();

    if (is_null($data["blog_detail"])) {
      return redirect()->route("column");
    } else {
      return view('horserace::frontend.content.blog_detail', compact('data'));
    }
  }

  

  public function result(Request $request,
                         ResultRepositories $resultRepositories,
                         VenueRepositories $venueRepositories)
  {
    $input = $request->all();    
    $data = $resultRepositories->getListResultPublic($input);    
    $list_venue = $venueRepositories->getListVenue();
    $arr_venue = array();
    foreach ($list_venue as $item) 
      $arr_venue[$item->id] = (array)$item;
    $data['venue'] = $arr_venue;
    
    return view('horserace::frontend.content.result', compact('data'));
  }

  public function getResultDetail(Request $request,
                                  ResultRepositories $resultRepositories, $id)
  {
    $input = $request->all();
    $user_id = Auth::user()->id;
    $data['result_detail'] = $resultRepositories->feGetBlogDetail($user_id, $id);
    $data['result'] = $resultRepositories->getListResultPublic($input);

    if (is_null($data["result_detail"])) {
      return redirect()->route("result");
    } else {
      return view('horserace::frontend.content.result_detail', compact('data'));
    }
  }

}
