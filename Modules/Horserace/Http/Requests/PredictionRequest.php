<?php

namespace Modules\Horserace\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PredictionRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'name' => 'required',
      //'content' => 'required',
      'start_time' => 'required',
      'end_time' => 'required|after:start_time',
      'default_point' => 'required',
      'status' => 'required',
      'prediction_type' => 'required',
//      'member_level' => 'required',
      'info_start_time' => 'required',
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
      'name.required' => __("horserace::be_msg.prediction_name_required"),
      //'content.required' => __("horserace::be_msg.prediction_content_required"),
      'start_time.required' => __("horserace::be_msg.prediction_start_time_required"),
      'end_time.required' => __("horserace::be_msg.prediction_end_time_required"),
      'end_time.after' => __("horserace::be_msg.prediction_end_time_after"),
      'default_point.required' => __("horserace::be_msg.default_point_required"),
      'status.required' => __("horserace::be_msg.prediction_status_required"),
      'prediction_type.required' => __("horserace::be_msg.prediction_type_required"),
      'member_level.required' => __("horserace::be_msg.member_level_required"),
      'info_start_time.required' => __("horserace::be_msg.info_start_time_required"),
    ];
  }
}
