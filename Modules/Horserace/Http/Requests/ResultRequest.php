<?php

namespace Modules\Horserace\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResultRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
       'course' => 'required',
      // 'double' => 'required',
     // 'course_text' => 'required',
      'date' => 'required',
      //'korogashi' => 'required',
      'race_no_1_num' => 'required',
      //'race_no_1_title' => 'required',
      'place_1' => 'required',
      'ticket_type' => 'required'
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
      'course.required' => __("horserace::be_msg.result_course_required"),
     // 'course_text.required' => __("horserace::be_msg.result_course_required"),
      'date.required' => __("horserace::be_msg.result_date_required"),
      //'korogashi.required' => __("horserace::be_msg.result_korogashi_required"),
      'race_no_1_num.required' => __("horserace::be_msg.result_race_no_1_num_required"),
      //'race_no_1_title.required' => __("horserace::be_msg.result_race_no_1_title_required"),
      'place_1.required' => __("horserace::be_msg.result_place_1_required"),
      'ticket_type.required' => __("horserace::be_msg.result_ticket_type_required")
    ];
  }
}
