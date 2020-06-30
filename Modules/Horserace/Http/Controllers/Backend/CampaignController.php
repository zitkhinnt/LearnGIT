<?php

namespace Modules\Horserace\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Horserace\Http\Requests\PredictionRequest;
use Modules\Horserace\Http\Requests\PredictionResultRequest;
use Modules\Horserace\Http\Requests\PredictionTypeRequest;
use Modules\Horserace\Repositories\PredictionRepositories;
use Modules\Horserace\Repositories\PredictionResultRepositories;
use Modules\Horserace\Repositories\PredictionTypeRepositories;
use Modules\Horserace\Repositories\UserStageRepositories;
use Modules\Horserace\Repositories\VenueRepositories;

class CampaignController extends Controller {
	public function __construct() {
		$this->middleware('auth:admin');
		$this->middleware('admin');
	}

	public function prediction(Request $request,
		PredictionRepositories $predictionRepositories,
		UserStageRepositories $userStageRepositories,
		PredictionTypeRepositories $predictionTypeRepositories) {
		$data['prediction'] = $predictionRepositories->getPrediction();
		$data['user_stage'] = $userStageRepositories->getListUserStage();
		$list_pre_type = $predictionTypeRepositories->getPredictionType();		
		$arr_pre_type = array();
		foreach ($list_pre_type as $item) {
			$arr_pre_type[$item->id] = (array) $item;
		}
		$data['prediction_type'] = $arr_pre_type;
		return view('horserace::backend.campaign.prediction', compact('data'));
  }

  public function predictionAjax(
    Request $request,
    PredictionRepositories $predictionRepositories,
    UserStageRepositories $userStageRepositories,
    PredictionTypeRepositories $predictionTypeRepositories
  ) {
    $input = $request->all();
    $result = $predictionRepositories->getPredictionAjax($input);

    $data = [
      "draw" => 0,
      "recordsTotal" => $result['total'],
      "recordsFiltered" => $result['total'],
    ];
    $data['data'] = array();

    foreach ($result['result'] as $item) {
      if ($item->number_buyer > 0) {
        $html = '<div class="w-100"><form action="' . route('admin.user.search_buy_prediction') . '" method="GET"><input type="hidden" name="prediction_id" value="' . $item->id . '"><label>買い目情報閲覧</label><select class="form-control p-0" name="buy_prediction"><option value="">指定なし</option><option value="1">公開前情報閲覧者</option><option value="2">公開前情報未閲覧者</option><option value="3">買い目情報閲覧者</option><option value="4">買い目情報未閲覧者</option></select><button class="btn btn-dark mt-2">購入者をユーザ検索する</button></form></div>';
      } else {
        $html = '';
      }
      $class = backgroundColorPre($item->status);
      $data['data'][] = [

        '<a class="text-muted font-16" href="' . route('admin.prediction.edit', $item->id) . '"><i class="ti-pencil-alt"></i></a>',
        $item->id,
        $item->name,
        number_format($item->default_point) . " pt",
        $item->prediction_type_name,
        predictionStatusStr('horserace', $item->status),
        $item->user_stage_str,
        '<a href="' . route("admin.user.buy_prediction", $item->id) . '" style="color: #e55039;">' . $item->number_buyer . '</a>',
        '<a href="' . route("admin.user.search_buy_prediction", ["prediction_id" => $item->id, "buy_prediction" => "3"]) . '" style="color: #e55039;">' . $item->number_buyer . '</a>',
        $html,
        '<a href="' . route("admin.user.access_prediction", $item->id) . '" style="color: #4a69bd;">' . $item->number_access . '</a>',
        date_format(date_create($item->start_time), 'Y-m-d')  . ' ～ ' . date_format(date_create($item->end_time), 'Y-m-d'),
        '<a class="btn btn-info" href="' . route("admin.prediction.review", ["id_prediction" => $item->id, "content" => PREDICTION_TYPE_CONTENT_AFTER_BUY]) . '">プレビュー</a>',
        '<a class="btn btn-info" href="' . route("admin.prediction.review", ["id_prediction" => $item->id, "content" => PREDICTION_TYPE_CONTENT_RESULT]) . '">プレビュー</a>',
        [
          'class' => $class
        ],
      ];
    }
    return response()->json($data);
  }

	public function addPrediction(Request $request,
		UserStageRepositories $userStageRepositories,
		PredictionTypeRepositories $predictionTypeRepositories) {
		$data['user_stage'] = $userStageRepositories->getListUserStage();
		$data['prediction_type'] = $predictionTypeRepositories->getPredictionType();
		return view('horserace::backend.campaign.add_prediction', compact("data"));
	}

  public function storePrediction(
    PredictionRequest $request,
    PredictionRepositories $predictionRepositories
  ) {
    $input = $request->all();
    if (!isset($input['clone'])) {
      $result = $predictionRepositories->storePrediction($input);
      return redirect()->route('admin.prediction')->with([
        'flash_level' => $result["status"],
        'flash_message' => $result["message"],
      ]);
    } else {
      $input['id'] = 0;
      $result = $predictionRepositories->storePrediction($input);

      return redirect()->back()->with([
        'flash_level' => $result["status"],
        'flash_message' => $result["message"],
        'prediction_id_clone' => $result['prediction_id_insert'],
      ]);
    }
  }

	public function reviewPrediction(Request $request,
		PredictionRepositories $predictionRepositories,
		$id_prediction, $content) {
		$data["prediction"] = $predictionRepositories->getPredictionById($id_prediction);
		$data["content"] = $content;
		return view('horserace::backend.review_fe.review_prediction', compact('data'));
	}

	public function editPrediction(Request $request, $id,
		PredictionRepositories $predictionRepositories,
		UserStageRepositories $userStageRepositories,
		PredictionTypeRepositories $predictionTypeRepositories) {
		$data['prediction'] = $predictionRepositories->getPredictionById($id);
		$data['user_stage'] = $userStageRepositories->getListUserStage();
    $data['prediction_type'] = $predictionTypeRepositories->getPredictionType();
		return view('horserace::backend.campaign.edit_prediction', compact('data'));
	}

	public function deletePrediction(Request $request,
		PredictionRepositories $predictionRepositories) {
		$input = $request->all();
		$result = $predictionRepositories->deletePrediction(trim($input["id_delete"]));
		return redirect()->route('admin.prediction')->with([
			'flash_level' => $result["status"],
			'flash_message' => $result["message"],
		]);
	}

	public function predictionResult(Request $request,
		PredictionResultRepositories $predictionResultRepositories,
		VenueRepositories $venueRepositories) {
		$data["list_pre"] = $predictionResultRepositories->getPredictionResultAndPrediction();
		$arr_venue = $venueRepositories->getListVenue();
		foreach ($arr_venue as $item) {
			$data["venue"][$item->id] = $item;
		}
		return view('horserace::backend.campaign.prediction_result', compact("data"));
	}

	public function addPredictionResult(Request $request,
		VenueRepositories $venueRepositories,
		$id_prediction) {
		$data["venue"] = $venueRepositories->getListVenue();
		$data["id_prediction"] = $id_prediction;
		return view('horserace::backend.campaign.add_prediction_result', compact("data"));
	}

	public function editPredictionResult(Request $request,
		PredictionResultRepositories $predictionResultRepositories,
		VenueRepositories $venueRepositories,
		$id_pre_result) {
		$data["pre_result"] = $predictionResultRepositories->getPredictionResultById($id_pre_result);
		$data["venue"] = $venueRepositories->getListVenue();
		return view('horserace::backend.campaign.edit_prediction_result', compact("data"));
	}

	public function storePredictionResult(PredictionResultRequest $request,
		PredictionResultRepositories $predictionResultRepositories) {
		$input = $request->all();
		$result = $predictionResultRepositories->storePredictionResult($input);

		return redirect()->route('admin.prediction.result')->with([
			'flash_level' => $result["status"],
			'flash_message' => $result["message"],
		]);
	}

	public function predictionType(Request $request,
		PredictionTypeRepositories $predictionTypeRepositories) {
		$data['prediction_type'] = $predictionTypeRepositories->getPredictionType();
		return view('horserace::backend.campaign.prediction_type', compact('data'));
	}

	public function addPredictionType(Request $request) {
		return view('horserace::backend.campaign.add_prediction_type', compact("data"));
	}

	public function storePredictionType(PredictionTypeRequest $request,
		PredictionTypeRepositories $predictionTypeRepositories) {
		$input = $request->all();
		$result = $predictionTypeRepositories->storePredictionType($input);
		return redirect()->route('admin.prediction.type')->with([
			'flash_level' => $result["status"],
			'flash_message' => $result["message"],
		]);
	}

	public function editPredictionType(Request $request, $id,
		PredictionTypeRepositories $predictionTypeRepositories) {
		$data['prediction_type'] = $predictionTypeRepositories->getPredictionTypeById($id);
		$data['prediction_type_table_params'] = json_decode($data['prediction_type']->prediction_type_params);
		return view('horserace::backend.campaign.edit_prediction_type', compact('data'));
	}

	public function deletePredictionType(Request $request,
		PredictionTypeRepositories $predictionTypeRepositories) {
		$input = $request->all();
		$result = $predictionTypeRepositories->deletePredictionType(trim($input["id_delete"]));
		return redirect()->route('admin.prediction.type')->with([
			'flash_level' => $result["status"],
			'flash_message' => $result["message"],
		]);
	}

	public function editFronend(Request $request, $id,
		PredictionTypeRepositories $predictionTypeRepositories) {
		$data['prediction_type'] = $predictionTypeRepositories->getPredictionTypeById($id);
		return view('horserace::backend.campaign.edit_prediction_type', compact('data'));
	}
}
