<?php

namespace Modules\Horserace\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EntranceRequest extends FormRequest
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
      'default_point' => 'required',
      'default_user_stage' => 'required',
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
      'name.required' => __("horserace::be_msg.entrance_name_required"),
      'default_point.required' => __("horserace::be_msg.entrance_default_point_required"),
      'default_user_stage.required' => __("horserace::be_msg.entrance_default_user_stage_required"),
    ];
  }
}
