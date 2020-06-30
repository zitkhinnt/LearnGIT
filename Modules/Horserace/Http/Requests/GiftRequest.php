<?php

namespace Modules\Horserace\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GiftRequest extends FormRequest
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
      'type' => 'required',
      'point' => 'required|numeric',
      'start_time' => 'required',
      'end_time' => 'required|after:start_time',
      'content' => 'required'
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
      'name.required' => __("horserace::be_msg.gift_name_required"),
      'type.required' => __("horserace::be_msg.gift_type_required"),
      'point.required' => __("horserace::be_msg.gift_point_required"),
      'point.numeric' => __("horserace::be_msg.gift_point_numeric"),
      'start_time.required' => __("horserace::be_msg.gift_start_date_required"),
      'end_time.required' => __("horserace::be_msg.gift_end_date_required"),
      'end_time.after' => __("horserace::be_msg.gift_end_date_after_start_date"),
      'content.required' => __("horserace::be_msg.gift_content_required")
    ];
  }
}
