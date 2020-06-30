<?php

namespace Modules\Horserace\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MediaRequest extends FormRequest
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
      'code' => 'required|alpha_dash|unique:media,code,' . $this->get('id'),
      'cost' => 'required',
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
      'name.required' => __("horserace::be_msg.media_name_required"),
      'code.required' => __("horserace::be_msg.media_code_detail_required"),
      'code.alpha_dash' => __("horserace::be_msg.media_code_detail_alpha_dash"),
      'code.unique' => __("horserace::be_msg.media_code_detail_unique"),
      'cost.required' => __("horserace::be_msg.media_cost_required"),
      'source.required' => __("horserace::be_msg.media_source_required")
    ];
  }
}
