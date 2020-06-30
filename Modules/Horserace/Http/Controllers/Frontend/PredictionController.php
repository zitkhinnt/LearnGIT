<?php
/**
 * Date: 2018-10-09
 */

namespace Modules\Horserace\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Horserace\Repositories\PredictionRepositories;
use Modules\Horserace\Entities\PredictionType;

class PredictionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
        $this->middleware('user_activity');
    }

    // dat comment not use -> HR only
    // public function predictionTrail(Request $request,
    //     PredictionRepositories $predictionRepositories) {
    //     $id_user = Auth::user()->id;
    //     $data["list_prediction"] = $predictionRepositories->feGetPrediction($id_user, MEMBER_LEVEL_TRIAL);
    //     return view('horserace::frontend.prediction.trial', compact("data"));
    // }

    // public function predictionGold(Request $request,
    //     PredictionRepositories $predictionRepositories) {
    //     $id_user = Auth::user()->id;
    //     $data["list_prediction"] = $predictionRepositories->feGetPrediction($id_user, MEMBER_LEVEL_GOLD);
    //     return view('horserace::frontend.prediction.gold', compact("data"));
    // }

    // public function predictionDiamond(Request $request,
    //     PredictionRepositories $predictionRepositories) {
    //     $id_user = Auth::user()->id;
    //     $data["list_prediction"] = $predictionRepositories->feGetPrediction($id_user, MEMBER_LEVEL_DIAMOND);
    //     return view('horserace::frontend.prediction.diamond', compact("data"));
    // }

    // public function predictionCrystal(Request $request,
    //     PredictionRepositories $predictionRepositories) {
    //     // if (Auth::user()->member_level >= MEMBER_LEVEL_CRYSTAL) {
    //     $id_user = Auth::user()->id;
    //     $data["list_prediction"] = $predictionRepositories->feGetPrediction($id_user, MEMBER_LEVEL_CRYSTAL);
    //     return view('horserace::frontend.prediction.crystal', compact("data"));
    //     /* } else {
    // return redirect()->route("home")->with([
    // 'flash_level' => "danger",
    // 'flash_message' => __("horserace::be_msg.error_member_level"),
    // ]);
    // } */
    // }

    public function predictionSpecial(Request $request,
        PredictionRepositories $predictionRepositories) {
        $id_user = Auth::user()->id;
        $data["list_prediction"] = $predictionRepositories->feGetPrediction($id_user, MEMBER_SPECIAL);
        return view('horserace::frontend.prediction.special', compact("data"));
    }

    public function buyPrediction(Request $request,
        PredictionRepositories $predictionRepositories) {
        $input = $request->all();
        $prediction_id = trim($input["prediction_id"]);
        $id_user = Auth::user()->id;
        $result = $predictionRepositories->buyPrediction($id_user, $prediction_id);

        if ($result["status"] == "danger") {
            switch ($result["error"]) {
                case "point":
                    return redirect()->route("point")->with([
                        'flash_level' => $result["status"],
                        'flash_message' => $result["message"],
                    ]);
                    break;

                case "member_level":
                    return redirect()->back()->with([
                        'flash_level' => $result["status"],
                        'flash_message' => $result["message"],
                    ]);
                    break;
                case "exist":
                    return redirect()->back()->with([
                        'flash_level' => $result["status"],
                        'flash_message' => $result["message"],
                    ]);
                    break;
            }

        } else {
            return redirect()->route("prediction_detail", $prediction_id)
                ->with([
                    'flash_level' => $result["status"],
                    'flash_message' => $result["message"],
                ]);
        }
    }

    public function predictionDetail(PredictionRepositories $predictionRepositories,
        $id_prediction) {
        $id_user = Auth::user()->id;
        $result = $predictionRepositories->feGetPredictionDetail($id_user, $id_prediction);

        if ($result["status"] == "danger") {
            return redirect()->route("home")->with([
                'flash_level' => $result["status"],
                'flash_message' => $result["message"],
            ]);
        } else {
            $obj_PredictionType = new PredictionType();
            $prediction_type = $obj_PredictionType->getPredictionTypeById($result["prediction"]->prediction_type);
            $data["prediction"] = $result["prediction"];
            $data['prediction_type'] = $prediction_type;

            // if ($data["prediction"]->member_level == MEMBER_SPECIAL) {
            //     return view('horserace::frontend.prediction.pre_detail_special', compact("data"));
            // } else {
            // return view('horserace::frontend.prediction.prediction_detail', compact("data"));
            // }
            if($data['prediction']->user_buy == BUY_PREDICTION){
                return view('horserace::frontend.prediction.prediction_detail', compact("data"));
            } else {
                abort(404);
            }
        }
    }

    public function getWeek(Request $request,
        PredictionRepositories $predictionRepositories) {
        $id_user = Auth::user()->id;
        $data['trial'] = $predictionRepositories->feGetPredictionByOpen($id_user, MEMBER_LEVEL_TRIAL);
        $data['gold'] = $predictionRepositories->feGetPredictionByOpen($id_user, MEMBER_LEVEL_GOLD);
        $data['diamond'] = $predictionRepositories->feGetPredictionByOpen($id_user, MEMBER_LEVEL_DIAMOND);
        $data['crystal'] = $predictionRepositories->feGetPredictionByOpen($id_user, MEMBER_LEVEL_CRYSTAL);
        return view('horserace::frontend.prediction.week', compact('data'));
    }

    public function predictions(
        Request $request,
        PredictionRepositories $predictionRepositories,
        $prediction_type_code
    ) {
        $id_user = Auth::user()->id;
        $data = $predictionRepositories->feGetPredictionByType($id_user, $prediction_type_code);
        if ($data) {
            return view('horserace::frontend.prediction.pre_list', compact("data"));
        } else {
            abort(404);
        }
    }

    // dat comment not user -> user only 1 route for 7 prediction type
    // public function predictionTrial01(
    //     Request $request,
    //     PredictionRepositories $predictionRepositories
    // ) {
    //     $id_user = Auth::user()->id;
    //     $data = $predictionRepositories->feGetPredictionByType($id_user, PREDICTION_TYPE_CODE_TR1);
    //     return view('horserace::frontend.prediction.pre_trial01', compact("data"));
    // }

    // public function predictionTrial02(
    //     Request $request,
    //     PredictionRepositories $predictionRepositories
    // ) {
    //     $id_user = Auth::user()->id;
    //     $data = $predictionRepositories->feGetPredictionByType($id_user, PREDICTION_TYPE_CODE_TR2);
    //     return view('horserace::frontend.prediction.pre_trial02', compact("data"));
    // }

    // public function prediction1st(
    //     Request $request,
    //     PredictionRepositories $predictionRepositories
    // ) {
    //     $id_user = Auth::user()->id;
    //     $data = $predictionRepositories->feGetPredictionByType($id_user, PREDICTION_TYPE_CODE_PR1);
    //     return view('horserace::frontend.prediction.pre_1st', compact("data"));
    // }

    // public function prediction2nd(
    //     Request $request,
    //     PredictionRepositories $predictionRepositories
    // ) {
    //     $id_user = Auth::user()->id;
    //     $data = $predictionRepositories->feGetPredictionByType($id_user, PREDICTION_TYPE_CODE_PR2);
    //     return view('horserace::frontend.prediction.pre_2nd', compact("data"));
    // }

    // public function prediction3rd(
    //     Request $request,
    //     PredictionRepositories $predictionRepositories
    // ) {
    //     $id_user = Auth::user()->id;
    //     $data = $predictionRepositories->feGetPredictionByType($id_user, PREDICTION_TYPE_CODE_PR3);
    //     return view('horserace::frontend.prediction.pre_3rd', compact("data"));
    // }

    // public function prediction4th(
    //     Request $request,
    //     PredictionRepositories $predictionRepositories
    // ) {
    //     $id_user = Auth::user()->id;
    //     $data = $predictionRepositories->feGetPredictionByType($id_user, PREDICTION_TYPE_CODE_PR4);
    //     return view('horserace::frontend.prediction.pre_4th', compact("data"));
    // }

    // public function prediction5th(
    //     Request $request,
    //     PredictionRepositories $predictionRepositories
    // ) {
    //     $id_user = Auth::user()->id;
    //     $data = $predictionRepositories->feGetPredictionByType($id_user, PREDICTION_TYPE_CODE_PR5);
    //     return view('horserace::frontend.prediction.pre_5th', compact("data"));
    // }

}
