<?php

namespace Modules\Horserace\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PredictionTypeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //'code' => 'required',
            'name' => 'required',
            'default_point' => 'required|numeric',
            'table_params.number_of_offers' => 'required',
            'table_params.denomination' => 'required',
            'table_params.score' => 'required',
            'table_params.investment_money' => 'required',
            'table_params.target_amount' => 'required',
            'table_params.deadline_for_participation' => 'required',
            'table_params.release_time' => 'required',
            'table_params.target_race' => 'required',
            'table_params.participation_fee' => 'required',
            //'image' => 'required',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'code.required' => __("horserace::be_msg.prediction_type_code_required"),
            'name.required' => __("horserace::be_msg.prediction_type_name_required"),
            'image.required' => __("horserace::be_msg.prediction_type_image_required"),
            'default_point.required' => __("horserace::be_msg.prediction_type_default_point_required"),
            'default_point.numeric' => __("horserace::be_msg.prediction_type_default_point_number"),
            'table_params.number_of_offers.required' => __("horserace::be_msg.prediction_type_number_of_offers_required"),
            'table_params.denomination.required' => __("horserace::be_msg.prediction_type_denomination_required"),
            'table_params.score.required' => __("horserace::be_msg.prediction_type_score_required"),
            'table_params.investment_money.required' => __("horserace::be_msg.prediction_type_investment_money_required"),
            'table_params.target_amount.required' => __("horserace::be_msg.prediction_type_target_amount_required"),
            'table_params.deadline_for_participation.required' => __("horserace::be_msg.prediction_type_deadline_for_participation_required"),
            'table_params.release_time.required' => __("horserace::be_msg.prediction_type_release_time_required"),
            'table_params.target_race.required' => __("horserace::be_msg.prediction_type_target_race_required"),
            'table_params.participation_fee.required' => __("horserace::be_msg.prediction_type_participation_fee_required"),
        ];
    }
}
