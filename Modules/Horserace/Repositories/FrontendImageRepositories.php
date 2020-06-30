<?php
/**
 * Date 2018-09-10
 */

namespace Modules\Horserace\Repositories;

use DB;
use Modules\Horserace\Entities\FrontendImage;

class FrontendImageRepositories
{
    public function updateImage($input)
    {
        $obj_image = new FrontendImage();
        $result = [];

        // check isset file upload
        if (isset($input['image_attention'])) {
            
            $time = \Carbon\Carbon::now()->timestamp;
            $name_image = $time . '_' . $input['image_attention']->getClientOriginalName();
            $input['image_attention']->move(public_path('uploads/image'), $name_image);
            $arr_image['image'] = '/uploads/image/' . $name_image;
            $obj_image->updateImage(IMAGE_FRONTEND_CODE_ATTENTION , $arr_image);
            $result = [
                "status" => "success",
                "message" => __("horserace::be_msg.add_prediction_type_success"),
            ];
        }
        return $result;
    }

}
