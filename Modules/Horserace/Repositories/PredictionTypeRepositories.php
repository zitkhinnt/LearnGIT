<?php
/**
 * Date 2018-09-10
 */

namespace Modules\Horserace\Repositories;

use Modules\Horserace\Entities\PredictionType;

class PredictionTypeRepositories
{
    public function storePredictionType($input)
    {
        $obj_prediction_type = new PredictionType();

        // Save data
        $arr_prediction_type = [
            // "code" => trim($input["code"]),
            "name" => trim($input["name"]),
            "before_open_content" => $input['before_open_content'] ?? '',
            "after_open_content" => $input['after_open_content'] ?? '',
            "default_point" => $input['default_point'] ?? 0,
            "prediction_type_params" => json_encode($input['table_params']),
        ];

        // check isset file upload
        if (isset($input['image'])) {
            //File::delete(public_path('upload/career'), $name_image);
            $time = \Carbon\Carbon::now()->timestamp;
            $name_image = $time . '_' . $input['image']->getClientOriginalName();
            $input['image']->move(public_path('uploads/prediction_type'), $name_image);
            $arr_prediction_type['image'] = '/uploads/prediction_type/' . $name_image;
        }

        if ($input["id"] != 0) {
            // Edit
            $obj_prediction_type->updatePredictionType(trim($input["id"]), $arr_prediction_type);
            $result = [
                "status" => "success",
                "message" => __("horserace::be_msg.edit_prediction_type_success"),
            ];
        } else {
            // dat comment -> prediction cannot be create
            // Create
            // $obj_prediction_type->insertPredictionType($arr_prediction_type);
            // $result = [
            //   "status" => "success",
            //   "message" => __("horserace::be_msg.add_prediction_type_success")
            // ];
        }

        return $result;
    }

    public function getPredictionTypeById($id_prediction_type)
    {
        $obj_prediction_type = new PredictionType();
        $PredictionType = $obj_prediction_type->getPredictionTypeById($id_prediction_type);
        return $PredictionType;
    }

    public function getPredictionType()
    {
        $obj_prediction_type = new PredictionType();
        $list_prediction_type = $obj_prediction_type->getPredictionType();
        return $list_prediction_type;
    }

    public function deletePredictionType($id_prediction_type)
    {
        $obj_prediction_type = new PredictionType();
        $obj_prediction_type->deletePredictionType($id_prediction_type);
        $result = [
            "status" => "success",
            "message" => __("horserace::be_msg.delete_prediction_type_success"),
        ];

        return $result;
    }
}
