<?php

namespace Modules\Horserace\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Horserace\Entities\User;
use Modules\Horserace\Entities\UserAccessPrediction;
use Modules\Horserace\Entities\UserDailyLoginHistory;
use Modules\Horserace\Http\Controllers\Auth\LoginController;
use Modules\Horserace\Http\Requests\UserRequest;
use Modules\Horserace\Repositories\BlogRepositories;
use Modules\Horserace\Repositories\EntranceRepositories;
use Modules\Horserace\Repositories\MediaRepositories;
use Modules\Horserace\Repositories\PredictionRepositories;
use Modules\Horserace\Repositories\PredictionTypeRepositories;
use Modules\Horserace\Repositories\UserAccessBlogRepositories;
use Modules\Horserace\Repositories\UserAccessPredictionRepositories;
use Modules\Horserace\Repositories\UserDailyLoginHistoryRepositories;
use Modules\Horserace\Repositories\UserRepositories;
use Modules\Horserace\Repositories\UserActivityRepositories;
use Modules\Horserace\Repositories\QuerySearchUserRepository;
use Excel;
use Modules\Horserace\Repositories\UserStageRepositories;
use Modules\Horserace\Entities\MailRegisterDetail;
use Auth;
class UserController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:admin');
    $this->middleware('admin');
  }

  public function user(Request $request,
                       UserRepositories $userRepositories)
  {
    $input = $request->all();
    $data['user'] = $userRepositories->getListUser();
    $data["condition"] = isset($input["condition"]) ? $input["condition"] : null;
    return view('horserace::backend.user.list_user', compact('data'));
  }

  public function searchUser(Request $request,
                             UserStageRepositories $userStageRepositories,
                             EntranceRepositories $entranceRepositories,
                             MediaRepositories $mediaRepositories,
                             PredictionTypeRepositories $predictionTypeRepositories,
                             QuerySearchUserRepository $querySearchUserRep)
  {
    $data["user_stage"] = $userStageRepositories->getListUserStage();
    $data["media"] = $mediaRepositories->getListMedia();
    $data["entrance"] = $entranceRepositories->getListEntrance();
    $data['prediction_type'] = $predictionTypeRepositories->getPredictionType();
    $data['list_query'] = $querySearchUserRep->getListQuery();

// dd($data['user_stage']);
khanh_log(print_r($data, true));

    return view('horserace::backend.user.search_user', compact("data"));
  }

  public function searchUserPost(Request $request,
                                 UserStageRepositories $userStageRepositories,
                                 UserRepositories $userRepositories)
  {
    $input = $request->all();
    
    if (isset($input['user_stage_id'])) {
      $input['user_stage_id'] = $input['user_stage_id'];
    } else {
      $input['user_stage_id'] = '';
    }

    $data['gender'] = isset($input['gender']) ? $input['gender'] : null;

    unset($input["_token"]);
    $input["user_register"] = true;
    // $data['user'] = $userRepositories->getSearchUser($input);
    $data["condition"] = json_encode($input);
    $data["user_stage"] = $userStageRepositories->getListUserStage();
    return view('horserace::backend.user.list_user', compact('data'));

  }


  public function listQuerySearchUser(
    Request $request,
    QuerySearchUserRepository $querySearchUserRep,
    PredictionTypeRepositories $predictionTypeRepositories,
    MediaRepositories $mediaRepositories,
    UserStageRepositories $userStageRepositories,
    EntranceRepositories $entranceRepositories
  ) {

    $data['list_query'] = $querySearchUserRep->getListQuery();
    $data['prediction_type'] = $predictionTypeRepositories->getPredictionType();
    $data["media"] = $mediaRepositories->getListMedia();
    $data["user_stage"] = $userStageRepositories->getListUserStage();
    $data["entrance"] = $entranceRepositories->getListEntrance();
    //dd($data['user_stage']);
    return view('horserace::backend.user.query_search', compact("data"));
  }


  public function addQuerySearchUser(
    Request $request,
    QuerySearchUserRepository $querySearchUserRep,
    UserStageRepositories $userStageRepositories,
    EntranceRepositories $entranceRepositories,
    MediaRepositories $mediaRepositories,
    PredictionTypeRepositories $predictionTypeRepositories
  ) {

    $input = $request->all();
    $name = $input['name_query'];
    unset($input['name_query']);
    unset($input['_token']);
    unset($input['query_search']);
    $query = json_encode($input);

    $data["user_stage"] = $userStageRepositories->getListUserStage();
    $data["media"] = $mediaRepositories->getListMedia();
    $data["entrance"] = $entranceRepositories->getListEntrance();
    $data['prediction_type'] = $predictionTypeRepositories->getPredictionType();

    if ($querySearchUserRep->addQuerySearch($name, $query)) {

      $data['list_query'] = $querySearchUserRep->getListQuery();
      return redirect()->route('admin.user.search')->with([
        'data' => $data,
        'flash_level_add' => 'success',
        'flash_msg_text' => '追加出来しました。',
      ]);
    }

    return redirect()->route('admin.user.search')->with([
      'data' => $data,
      'flash_level_add' => 'danger',
      'flash_msg_text' => 'エーラ',
    ]);
  }


  public function updateQuerySearchUser(
    Request $request,
    QuerySearchUserRepository $querySearchUserRep,
    PredictionTypeRepositories $predictionTypeRepositories,
    MediaRepositories $mediaRepositories,
    UserStageRepositories $userStageRepositories,
    EntranceRepositories $entranceRepositories
  ) {
    $input = $request->all();
    $name = $input['name_query'];
    $id = $input['id_query_search'];

    unset($input['name_query']);
    unset($input['id_query_search']);
    unset($input['_token']);

    $query = json_encode($input);

    $data['list_query'] = $querySearchUserRep->getListQuery();
    $data['prediction_type'] = $predictionTypeRepositories->getPredictionType();
    $data["media"] = $mediaRepositories->getListMedia();
    $data["user_stage"] = $userStageRepositories->getListUserStage();
    $data["entrance"] = $entranceRepositories->getListEntrance();

    if ($querySearchUserRep->updateQuerySearch($id, $name, $query)) {
      return redirect()->route('admin.list.query.search.user')->with([
        'data' => $data,
        'flash_level' => 'success',
        'flash_message' => 'update success',
      ]);
    }
    return redirect()->route('admin.list.query.search.user')->with([
      'data' => $data,
      'flash_level' => 'danger',
      'flash_message' => 'update error'
    ]);
  }

  public function deleteQuerySearchUser(
    $id,
    QuerySearchUserRepository $querySearchUserRep,
    PredictionTypeRepositories $predictionTypeRepositories,
    MediaRepositories $mediaRepositories,
    UserStageRepositories $userStageRepositories,
    EntranceRepositories $entranceRepositories
  ) {

    $data['list_query'] = $querySearchUserRep->getListQuery();
    $data['prediction_type'] = $predictionTypeRepositories->getPredictionType();
    $data["media"] = $mediaRepositories->getListMedia();
    $data["user_stage"] = $userStageRepositories->getListUserStage();
    $data["entrance"] = $entranceRepositories->getListEntrance();

    if ($querySearchUserRep->deleteQuery((int) $id)) {
      return redirect()->route('admin.list.query.search.user')->with([
        'data' => $data,
        'flash_level' => 'success',
        'flash_message' => 'delete success',
      ]);
    }
    return redirect()->route('admin.list.query.search.user')->with([
      'data' => $data,
      'flash_level' => 'danger',
      'flash_message' => 'delete error'
    ]);
  }

  public function searchUserPostAjax(Request $request, UserStageRepositories $userStageRepositories, UserRepositories $userRepositories)
  {
    $input = $request->all();
    $input["user_register"] = true;
    $input['user_stage_id'] = json_decode(htmlspecialchars_decode($input['user_stage']), true);
    $result = $userRepositories->getSearchUserAjax($input);
    $data = [
      "draw" => 0,
      "recordsTotal" => $result['total'],
      "recordsFiltered" => $result['total'],
    ];

    $data['data'] = array();
    foreach ($result['result'] as $item) {
      if ((Auth::guard('admin')->user()->role_email) == ROLE_EMAIL_HIDDEN) {
        $mail_pc = replaceStringEmail($item->mail_pc);
      } else {
        $mail_pc = $item->mail_pc;
      }

      $data['data'][] = [
        '<a class="text-muted font-16" href="' . route('admin.user.edit', $item->user_id) . '"><i class="ti-pencil-alt"></i></a>',
        //login_id
        '<a href="' . route('admin.user.edit', $item->user_id) . '">' . $item->login_id . '</a>',
        // mail_pc
        $mail_pc,
        // media_code
        $item->media_code,
        // point
        number_format($item->point) . " pt",
        // amount_user_paid
        "¥" . $item->deposit_amount,
        // number_user_paid
        $item->deposit_number . " 回",
        // register_time
        $item->register_time,
        // number_login
        $item->login_number . " 回",
        // initial_paid_time
        $item->first_deposit_time,
        // last_paid_time
        $item->last_deposit_time,
        // last_login
        $item->last_login_time,
        // member_level
        memberLevelStr($item->member_level),
        $item->user_stage_str,
      ];
    }
    return response()->json($data);
  }

  public function addUser(Request $request,
                          UserStageRepositories $userStageRepositories,
                          EntranceRepositories $entranceRepositories,
                          MediaRepositories $mediaRepositories)
  {
    $data['login_id'] = getUniqueCodeNumber(LENGTH_LOGIN_ID, 'users', 'login_id');
    $data['user_key'] = getUniqueString(LENGTH_USER_KEY, 'users', 'user_key');
    $data['password'] = generatePassword(LENGTH_PASSWORD);
    $data["user_stage"] = $userStageRepositories->getListUserStage();
    $data["media"] = $mediaRepositories->getListMedia();
    $data["entrance"] = $entranceRepositories->getListEntrance();
    return view('horserace::backend.user.add_user', compact('data'));
  }

  public function storeUser(UserRequest $request,
                            UserRepositories $userRepositories)
  {
    $input = $request->all();
    $input['ip'] = null;
    $input['user_agent'] = null;
    $obj_user = new User();
    $obj_mail_register = new MailRegisterDetail();
    $input['memo'] = strip_tags($input['memo']);

    if($input['id']==0)
    {
      $input["mail_pc"] = trim($input["mail_pc"]);
      $input["mail_mobile"] = trim($input["mail_mobile"]);
      if(strlen(trim($input["mail_pc"]))>0)
      {
        $mail_new = strtolower(trim($input["mail_pc"]));

        if(strpos(strtolower($mail_new), strtolower('@gmail'))!==FALSE)
        {
            $mail_new = $obj_user->replaceMailGoogle($mail_new);         
            $list_user_mail_pc_google = $obj_user->getUserByMailPcGoogle();
            foreach($list_user_mail_pc_google as $user_mail)
            {
                $mail_exit = $obj_user->replaceMailGoogle($user_mail->mail_pc);
                if(strcmp(strtoupper($mail_exit), strtoupper($mail_new))==0) 
                {
                  return redirect()->route('admin.user.add')->with([
                    'flash_level' => "success",
                    'flash_message' => __("horserace::be_msg.email_exit"),
                    ]);
                }
            }  
            
            
            $list_user_mail_mobile_google = $obj_user->getUserByMailMobileGoogle();
            foreach($list_user_mail_mobile_google as $user_mail)
            {
                $mail_exit = $obj_user->replaceMailGoogle($user_mail->mail_pc);
                if(strcmp(strtoupper($mail_exit), strtoupper($mail_new))==0) 
                {
                  return redirect()->route('admin.user.add')->with([
                    'flash_level' => "success",
                    'flash_message' =>  __("horserace::be_msg.email_exit"),
                    ]);
                }
            }
            
            /*$list_user_mail_register_google = $obj_mail_register->getMailRegisterDetailByMailToAddressGoogle();
            foreach($list_user_mail_register_google as $mail_reg)
            {
                $mail_exit = $obj_user->replaceMailGoogle($mail_reg->mail_to_address);
                if(strcmp(strtoupper($mail_exit), strtoupper($mail_new))==0) 
                {
                  return redirect()->route('admin.user.add')->with([
                    'flash_level' => "success",
                    'flash_message' => "このメールアドレスはすでに登録済みです。",
                    ]);
                }
            }  */       
                 
        }
        else
        {
            if($obj_user->getUserByMailPcNew($mail_new) || $obj_user->getUserByMailMobile($mail_new)||$obj_mail_register->getMailRegisterDetailByMailToAddress($mail_new))
            {
              return redirect()->route('admin.user.add')->with([
                'flash_level' => "success",
                'flash_message' => "このメールアドレスはすでに登録済みです。",
                ]);;
            }

        }


        /*if(strpos($input["mail_pc"], '@gmail')!==FALSE)
        {  
          $mail_name_before = substr($input["mail_pc"],0,strpos($input["mail_pc"], '@gmail')+1);
          $mail_name_before_replace = str_replace('.','',$mail_name_before); 
          $input["mail_pc"] = str_replace($mail_name_before, $mail_name_before_replace, $input["mail_pc"]);
            
        }
        if($obj_user->getUserByMailPcNew($input["mail_pc"])||$obj_mail_register->getMailRegisterDetailByMailToAddress($input["mail_pc"])) 
        {
          return redirect()->route('admin.user.add')->with([
          'flash_level' => "success",
          'flash_message' => "このメールアドレスはすでに登録済みです。",
          ]);
        }  */
            
      }
      if(strlen(trim($input['mail_mobile']))>0)
      {
        $mail_new = strtolower(trim($input["mail_mobile"]));

        if(strpos(strtolower($mail_new), strtolower('@gmail'))!==FALSE)
        {         
            $list_user_mail_pc_google = $obj_user->getUserByMailPcGoogle();
            foreach($list_user_mail_pc_google as $user_mail)
            {
                $mail_exit = $obj_user->replaceMailGoogle($user_mail->mail_pc);
                if(strcmp(strtoupper($mail_exit), strtoupper($mail_new))==0) 
                {
                  return redirect()->route('admin.user.add')->with([
                    'flash_level' => "success",
                    'flash_message' =>  __("horserace::be_msg.email_exit"),
                    ]);
                }
            }  
            
            
            $list_user_mail_mobile_google = $obj_user->getUserByMailMobileGoogle();
            foreach($list_user_mail_mobile_google as $user_mail)
            {
                $mail_exit = $obj_user->replaceMailGoogle($user_mail->mail_pc);
                if(strcmp(strtoupper($mail_exit), strtoupper($mail_new))==0) 
                {
                  return redirect()->route('admin.user.add')->with([
                    'flash_level' => "success",
                    'flash_message' =>  __("horserace::be_msg.email_exit"),
                    ]);
                }
            }
            
            /*$list_user_mail_register_google = $obj_mail_register->getMailRegisterDetailByMailToAddressGoogle();
            foreach($list_user_mail_register_google as $mail_reg)
            {
                $mail_exit = $obj_user->replaceMailGoogle($mail_reg->mail_to_address);
                if(strcmp(strtoupper($mail_exit), strtoupper($mail_new))==0) 
                {
                  return redirect()->route('admin.user.add')->with([
                    'flash_level' => "success",
                    'flash_message' => "このメールアドレスはすでに登録済みです。",
                    ]);
                }
            } */        
                 
        }  
        else
        {
          if($obj_user->getUserByMailMobile(trim($mail_new)))
          {
            return redirect()->route('admin.user.add')->with([
            'flash_level' => "success",
            'flash_message' =>  __("horserace::be_msg.email_exit"),
            ]);
          }
        }
        /*if(strpos($input['mail_mobile'], '@gmail')!==FALSE)
        { 
          $mail_name_before = substr($input["mail_mobile"],0,strpos($input["mail_mobile"], '@gmail')+1);
          $mail_name_before_replace = str_replace('.','',$mail_name_before); 
          $input["mail_mobile"] = str_replace($mail_name_before, $mail_name_before_replace, $input["mail_mobile"]);         
        }
        if($obj_user->getUserByMailMobile(trim($input["mail_mobile"])))
        {
          return redirect()->route('admin.user.add')->with([
          'flash_level' => "success",
          'flash_message' => "このメールアドレスはすでに登録済みです。",
          ]);
        } */     
      }
    }
  
  
    if (isset($input["deleted_flg"])) {
      $result = $userRepositories->deletedUserById($input["id"]);
    } else {
      $result = $userRepositories->userStore($input);
    }

    return redirect()->route('admin.user.search')->with([
      'flash_level' => $result["status"],
      'flash_message' => $result["message"],
    ]);
  }

  public function editUser(Request $request, $id,
                           UserRepositories $userRepositories,
                           UserStageRepositories $userStageRepositories,
                           EntranceRepositories $entranceRepositories,
                           MediaRepositories $mediaRepositories,
                           UserDailyLoginHistoryRepositories $userDailyLoginHistoryRepositories)
  {
    $data['user'] = $userRepositories->getEditUser($id);
    $data["trans"] = $userRepositories->getTransUser($id);
    $condition = [
      "login_id" => $data["user"]->login_id
    ];
    $data["condition"] = json_encode($condition);
    $data["user_stage"] = $userStageRepositories->getListUserStage();
    $data["media"] = $mediaRepositories->getListMedia();
    $data["entrance"] = $entranceRepositories->getListEntrance();
    $data["history"] = $userDailyLoginHistoryRepositories->getUserLoginHistory($condition);
    return view('horserace::backend.user.edit_user', compact('data'));
  }

  public function updateUser(UserRequest $request, $id,
                             UserRepositories $userRepositories)
  {
    $input = $request->all();
    // $input['ip'] = $request->ip();
    // $input['user_agent'] = $request->header('User-Agent');
    $result = $userRepositories->editUser($id, $input);
    return redirect()->route('admin.user')->with([
      'flash_level' => $result["status"],
      'flash_message' => $result["message"],
    ]);
  }

  public function userLogin($user_id, Request $request)
  {
    $obj_user = new User();
    $user = $obj_user->getUserById($user_id);
    $obj_login_controller = new LoginController();
    $obj_login_controller->loginByAdmin($user, $request);

    return redirect()->route("home");
  }

  public function userInterim(Request $request)
  {
    return view('horserace::backend.user.user_interim');
  }

  public function searchUserInterimPost(Request $request,
                                        UserRepositories $userRepositories)
  {
    $input = $request->all();
    unset($input["_token"]);
    $input["user_interim"] = true;
    $data['user'] = $userRepositories->getSearchUser($input);
    $data["condition"] = json_encode($input);
    return view('horserace::backend.user.list_user_interim', compact("data"));
  }

  public function searchUserInterimPostAjax(Request $request, UserRepositories $userRepositories)
  {
    $input = $request->all();
    $input["user_interim"] = true;
    $result = $userRepositories->getSearchUserAjax($input);
    $data = [
      "draw" => 0,
      "recordsTotal" => $result['total'],
      "recordsFiltered" => $result['total'],
    ];
    $data['data'] = array();
    foreach ($result['result'] as $item) {
      $data['data'][] = [
        $item->login_id,
        $item->mail_pc,
        $item->ip,
        $item->interim_register_time,
        '<label class="checkbox"> <input type="checkbox" name="deleted[' . $item->user_id . ']" value="' . $item->user_id . '"><span class="input-span"></span>削除</label>',
      ];
    }
    return response()->json($data);
  }

  public function exportCSVUser(Request $request,
                                UserRepositories $userRepositories,
                                UserActivityRepositories $userActivityRepositories)
  {
    $input = $request->all();
    $condition = json_decode($input["condition"], true);
    $data_user = $userRepositories->getSearchUser($condition);  
   
    Excel::create(FILE_USER_REGISTER_MAIL, function ($excel) use ($data_user) {
      $excel->setTitle(FILE_USER_REGISTER_MAIL);
      $excel->sheet(FILE_USER_REGISTER_MAIL, function ($sheet) use ($data_user) {
        //$sheet->fromArray($arr_export, null, 'A1', false, false);
        $sheet->loadView('horserace::backend.template.export_csv_user', array('data_user' => $data_user));
      });
    })->export('xlsx');    
  }

  public function exportCSVUserInterim(Request $request,
                                       UserRepositories $userRepositories,
                                       UserActivityRepositories $userActivityRepositories)
  {
    $input = $request->all();
    $condition = json_decode($input["condition"], true);
    $data_user = $userRepositories->getSearchUser($condition);

    Excel::create(FILE_USER_INTERIM_MAIL, function ($excel) use ($data_user) {
      $excel->setTitle(FILE_USER_INTERIM_MAIL);
      $excel->sheet(FILE_USER_INTERIM_MAIL, function ($sheet) use ($data_user) {
        //$sheet->fromArray($arr_export, null, 'A1', false, false);
        $sheet->loadView('horserace::backend.template.export_csv_user_interim', array('data_user' => $data_user));
      });
    })->export('xlsx');
  }

  public function deletedUerInterim(Request $request,
                                    UserRepositories $userRepositories)
  {
    $input = $request->all();
    $result = $userRepositories->deletedUserInterim($input);
    return redirect()->route('admin.user.interim')->with([
      'flash_level' => $result["status"],
      'flash_message' => $result["message"],
    ]);
  }

  public function userAccessPrediction(Request $request,
                                       PredictionRepositories $predictionRepositories,
                                       UserAccessPredictionRepositories $userAccessPredictionRepositories,
                                       $prediction_id)
  {
    $input = $request->all();
    $data["prediction"] = $predictionRepositories->getPredictionById($prediction_id);
    $data['user_access'] = $userAccessPredictionRepositories->getUserAccessByPredictionId($prediction_id);
    return view('horserace::backend.user.user_access_prediction', compact("data"));
  }

  public function userBuyPrediction(Request $request,
                                    PredictionRepositories $predictionRepositories,
                                    UserAccessPredictionRepositories $userAccessPredictionRepositories,
                                    $prediction_id)
  {
    $input = $request->all();
    $data["prediction"] = $predictionRepositories->getPredictionById($prediction_id);
    $data['user_buy'] = $userAccessPredictionRepositories->getUserBuyByPredictionId($prediction_id);
    $data["list_prediction_open"] = $predictionRepositories->getPredictionOpen();
    return view('horserace::backend.user.user_buy_prediction', compact("data"));
  }

  public function userAccessBlog(Request $request,
                                 BlogRepositories $blogRepositories,
                                 UserAccessBlogRepositories $userAccessBlogRepositories,
                                 $blog_id)
  {
    $input = $request->all();
    $data["blog"] = $blogRepositories->getEditBlog($blog_id);
    $data['user_access'] = $userAccessBlogRepositories->getUserAccessByBlogId($blog_id);
    return view('horserace::backend.user.user_access_blog', compact("data"));
  }

  public function addAllUserStage(Request $request,
                                  UserStageRepositories $userStageRepositories)
  {
    $input = $request->all();
    $condition = json_decode($input["condition"], true);
    $result = $userStageRepositories->addAllUserStage($input, $condition);
    return redirect()->route('admin.user.search')->with([
      'flash_level' => $result["status"],
      'flash_message' => $result["message"],
    ]);
  }

  public function editAllUserStage(Request $request,
                                   UserStageRepositories $userStageRepositories)
  {
    $input = $request->all();
    $condition = json_decode($input["condition"], true);
    $result = $userStageRepositories->editAllUserStage($input, $condition);
    return redirect()->route('admin.user.search')->with([
      'flash_level' => $result["status"],
      'flash_message' => $result["message"],
    ]);
  }

  public function deletedAllUserStage(Request $request,
                                      UserStageRepositories $userStageRepositories)
  {
    $input = $request->all();
    $condition = json_decode($input["condition"], true);
    $result = $userStageRepositories->deletedAllUserStage($input, $condition);
    return redirect()->route('admin.user.search')->with([
      'flash_level' => $result["status"],
      'flash_message' => $result["message"],
    ]);
  }

  public function searchUserBuyPrediction(Request $request,
                                          UserStageRepositories $userStageRepositories,
                                          UserRepositories $userRepositories)
  {
    $input = $request->all();
    $data['user'] = $userRepositories->getSearchUser($input);
    $data["condition"] = json_encode($input);
    $data["user_stage"] = $userStageRepositories->getListUserStage();
    return view('horserace::backend.user.list_user_buy_prediction', compact('data'));
  }

  public function deleteUserBuyPrediction(Request $request,
                                          UserAccessPredictionRepositories $userAccessPredictionRepositories)
  {
    $input = $request->all();
    $result = $userAccessPredictionRepositories->deleteUserBuyPrediction($input);
    return redirect()->route('admin.user.buy_prediction', trim($input["prediction_id"]))->with([
      'flash_level' => $result["status"],
      'flash_message' => $result["message"],
    ]);
  }

  public function searchUserLoginHistory(Request $request)
  {
    return view('horserace::backend.user.search_user_login_history');
  }

  public function userLoginHistory(Request $request,
                                   UserDailyLoginHistoryRepositories $userDailyLoginHistoryRepositories)
  {
    $input = $request->all();
    // $data["history"] = $userDailyLoginHistoryRepositories->getUserLoginHistory($input);
    $data["search"] = $input;
    return view('horserace::backend.user.user_login_history', compact("data"));
  }

  public function userLoginHistoryAjax(Request $request, UserDailyLoginHistoryRepositories $userDailyLoginHistoryRepositories)
  {
    $input = $request->all();
    $result = $userDailyLoginHistoryRepositories->getUserLoginHistoryAjax($input);
    $data = [
      "draw" => 0,
      "recordsTotal" => $result['total'],
      "recordsFiltered" => $result['total'],
    ];
    $data['data'] = array();
    foreach ($result['result'] as $item) {

      $data['data'][] = [
        $item->id,
        '<a class="text-blue" href="' . route("admin.user.edit", $item->user_id) . '">' . $item->login_id . '</a>',
        date("Y-m-d H:i:s", strtotime($item->login_date)),
        number_format($item->login_number),
      ];
    }
    return response()->json($data);
  }

  public function addUserBuyPrediction(Request $request,
                                       PredictionRepositories $predictionRepositories)
  {
    $input = $request->all();
    $prediction_detail_id = trim($input["prediction_detail_id"]);
    $result = $predictionRepositories->addUserBuyPrediction($input);
    return redirect()->route("admin.user.buy_prediction", $prediction_detail_id)->with([
      'flash_level' => $result["status"],
      'flash_message' => $result["message"],
    ]);
  }
}
