<?php

namespace Modules\Horserace\Http\Controllers\Backend;
use Session;
use Modules\Horserace\Repositories\FrontendImageRepositories;
use Modules\Horserace\Entities\FrontendImage;
use Illuminate\Http\Request;


use Illuminate\Routing\Controller;

class ChangeImageController extends Controller {
	public function __construct() {
		$this->middleware('auth:admin');
		$this->middleware('admin');
	}

	public function editFrontend(FrontendImageRepositories $frontendImageRepositories,
								FrontendImage $frontendImage) {

		// get frontend image
		$frontendimages = $frontendImage->getAllImage();

		foreach ($frontendimages as $value) {
    			$data['frontendimages'][$value->code] = (array) $value;
		}

		return view('horserace::backend.edit_frontend.edit', compact('data'));
	}
	
	public function updateImage(FrontendImageRepositories $frontendImageRepositories, 
								Request $request,
								FrontendImage $frontendImage){	
			// get frontend image
		$frontendimages = $frontendImage->getAllImage();

		foreach ($frontendimages as $value) {
    		$data['frontendimages'][$value->code] = (array) $value;
		}
	
		$input = $request->all();
		$result = $frontendImageRepositories->updateImage($input);

		return redirect()->route('admin.edit_frontend');
		
	}
}