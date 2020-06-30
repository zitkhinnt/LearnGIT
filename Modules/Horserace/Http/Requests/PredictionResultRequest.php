<?php

namespace Modules\Horserace\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PredictionResultRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'race_name' => 'required',
      'type' => 'required',
      'hit_race' => 'required',
      'amount' => 'required',
      'reserve_datetime' => 'required',
      'venue_id' => 'required',
      'content' => 'required',
      'prediction_type' => 'required',
      'race_date' => 'required',
      'race_no' => 'required',
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
      'race_name.required' => __("horserace::be_msg.race_name_required"),
      'type.required' => __("horserace::be_msg.type_required"),
      'hit_race.required' => __("horserace::be_msg.hit_race_required"),
      'amount.required' => __("horserace::be_msg.amount_required"),
      'reserve_datetime.required' => __("horserace::be_msg.reserve_datetime_required"),
      'venue_id.required' => __("horserace::be_msg.venue_id_required"),
      'content.required' => __("horserace::be_msg.content_required"),
      'prediction_type.required' => __("horserace::be_msg.prediction_type_required"),
      'race_no.required' => __("horserace::be_msg.race_no_required"),
      'race_date.required' => __("horserace::be_msg.race_date"),
    ];
  }
}
