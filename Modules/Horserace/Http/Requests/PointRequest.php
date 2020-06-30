<?php

namespace Modules\Horserace\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PointRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'point' => 'required|numeric|unique:point,point,'.$this->get('id'), 
      'price' => 'required|numeric'
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

  public function messages () {
    return [
      'point.required' => __("horserace::be_msg.point_required"),
      'point.numeric' => __("horserace::be_msg.point_numeric"),
      'point.unique'   => __("horserace::be_msg.point_unique"),
      'price.required' => __("horserace::be_msg.price_required"),
      'price.numeric' => __("horserace::be_msg.price_numeric")
    ];
  }
}
