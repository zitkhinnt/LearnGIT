<?php

namespace Modules\Horserace\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
// repositories
use Modules\Horserace\Entities\Media;
use Modules\Horserace\Entities\User;
use Modules\Horserace\Http\Requests\EntranceRequest;
use Modules\Horserace\Http\Requests\MediaRequest;
use Modules\Horserace\Http\Requests\PageRequest;
use Modules\Horserace\Http\Requests\PointRequest;
use Modules\Horserace\Http\Requests\UserStageRequest;
use Modules\Horserace\Http\Requests\VenueRequest;
use Modules\Horserace\Repositories\EntranceRepositories;
use Modules\Horserace\Repositories\MediaRepositories;
// request
use Modules\Horserace\Repositories\PageRepositories;
use Modules\Horserace\Repositories\PointRepositories;
use Modules\Horserace\Repositories\UserStageRepositories;
use Modules\Horserace\Repositories\VenueRepositories;

class SiteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('admin');
    }

    /* Entrance start*/
    public function getEntrance(Request $request,
        EntranceRepositories $entranceRepositories,
        UserStageRepositories $userStageRepositories) {
        $data['list'] = $entranceRepositories->getListEntrance();
        $user_stage = $userStageRepositories->getListUserStage();
        $arr_user_stage = array();
        foreach ($user_stage as $item) {
            $arr_user_stage[$item->id] = $item;
        }
        $data["user_stage"] = $arr_user_stage;
        return view('horserace::backend.site.entrance.list_entrance', compact("data"));
    }

    public function addEntrance(Request $request,
        UserStageRepositories $userStageRepositories) {
        $data["user_stage"] = $userStageRepositories->getListUserStage();
        return view('horserace::backend.site.entrance.add_entrance', compact("data"));
    }

    public function editEntrance(Request $request,
        UserStageRepositories $userStageRepositories,
        EntranceRepositories $entranceRepositories,
        $id) {
        $data["user_stage"] = $userStageRepositories->getListUserStage();
        $data['entrance'] = $entranceRepositories->getEditEntrance($id);
        return view('horserace::backend.site.entrance.edit_entrance', compact("data"));
    }

    public function storeEntrance(EntranceRequest $request,
        EntranceRepositories $entranceRepositories) {
        $input = $request->all();
        $result = $entranceRepositories->entranceStore($input);
        return redirect()->route('admin.entrance')->with([
            'flash_level' => $result["status"],
            'flash_message' => $result["message"],
        ]);
    }

    public function deleteEntrance(Request $request,
        EntranceRepositories $entranceRepositories) {
        $entrance_id = $request->id_delete;
        $result = $entranceRepositories->entranceDelete($entrance_id);
        return redirect()->route('admin.entrance')->with([
            'flash_level' => $result["status"],
            'flash_message' => $result["message"],
        ]);
    }

    /* Entrance end*/

    /* Page start */
    public function getPage(Request $request,
        PageRepositories $pageRepositories) {
        $data['list'] = $pageRepositories->getListPage();
        return view('horserace::backend.site.page.list_page', compact('data'));
    }

    public function addPage(Request $request)
    {
        return view('horserace::backend.site.page.add_page');
    }

    public function editPage(Request $request,
        PageRepositories $pageRepositories, $id) {
        $data['edit'] = $pageRepositories->getEditPage($id);
        return view('horserace::backend.site.page.edit_page', compact('data'));
    }

    public function storePage(PageRequest $request,
        PageRepositories $pageRepositories) {
        $input = $request->all();
        $result = $pageRepositories->pageStore($input);
        return redirect()->route('admin.page')->with([
            'flash_level' => $result["status"],
            'flash_message' => $result["message"],
        ]);
    }

    public function deletePage(Request $request,
        PageRepositories $pageRepositories) {
        $page_id = $request->id_delete;
        $result = $pageRepositories->pageDelete($page_id);
        return redirect()->route('admin.page')->with([
            'flash_level' => $result["status"],
            'flash_message' => $result["message"],
        ]);
    }
    /* Page end */

    /* Point start */
    public function getPoint(Request $request,
        PointRepositories $pointRepositories) {
        $data['list'] = $pointRepositories->getListPoint();
        return view('horserace::backend.site.point.list_point', compact('data'));
    }

    public function storePoint(PointRequest $request,
        PointRepositories $pointRepositories) {
        $input = $request->all();
        $result = $pointRepositories->pointStore($input);
        return redirect()->route('admin.point')->with([
            'flash_level' => $result["status"],
            'flash_message' => $result["message"],
        ]);
    }

    public function editPoint(Request $request,
        PointRepositories $pointRepositories, $id) {
        $data['edit'] = $pointRepositories->getEditPoint($id);
        $data['list'] = $pointRepositories->getListPoint();
        return view('horserace::backend.site.point.edit_point', compact('data'));
    }

    public function deletePoint(Request $request,
        PointRepositories $pointRepositories) {
        $point_id = $request->id_delete;
        $result = $pointRepositories->pointDelete($point_id);
        return redirect()->route('admin.point')->with([
            'flash_level' => $result["status"],
            'flash_message' => $result["message"],
        ]);
    }
    /* Point end */

    /* Venue start */
    public function getVenue(Request $request,
        VenueRepositories $venueRepositories) {
        $data['list'] = $venueRepositories->getListVenue();
        return view('horserace::backend.site.venue.list_venue', compact('data'));
    }

    public function storeVenue(VenueRequest $request,
        VenueRepositories $venueRepositories) {
        $input = $request->all();
        $result = $venueRepositories->venueStore($input);
        return redirect()->route('admin.venue')->with([
            'flash_level' => $result["status"],
            'flash_message' => $result["message"],
        ]);
    }

    public function editVenue(Request $request,
        VenueRepositories $venueRepositories, $id) {
        $data['edit'] = $venueRepositories->getEditVenue($id);
        $data['list'] = $venueRepositories->getListVenue();
        return view('horserace::backend.site.venue.edit_venue', compact('data'));
    }

    public function deleteVenue(Request $request,
        VenueRepositories $venueRepositories) {
        $venue_id = $request->id_delete;
        $result = $venueRepositories->venueDelete($venue_id);
        return redirect()->route('admin.venue')->with([
            'flash_level' => $result["status"],
            'flash_message' => $result["message"],
        ]);
    }
    /* Venue end */

    /* UserStage start */
    public function getUserStage(Request $request,
        UserStageRepositories $UserStageRepositories) {
        $data['list'] = $UserStageRepositories->getListUserStage();
        return view('horserace::backend.site.user_stage.list_user_stage', compact('data'));
    }

    public function storeUserStage(UserStageRequest $request,
        UserStageRepositories $UserStageRepositories) {
        $input = $request->all();
        $result = $UserStageRepositories->UserStageStore($input);
        return redirect()->route('admin.user_stage')->with([
            'flash_level' => $result["status"],
            'flash_message' => $result["message"],
        ]);
    }

    public function editUserStage(Request $request,
        UserStageRepositories $userStageRepositories, $id) {
        $data['edit'] = $userStageRepositories->getEditUserStage($id);
        $data['list'] = $userStageRepositories->getListUserStage();
        return view('horserace::backend.site.user_stage.edit_user_stage', compact('data'));
    }

    public function deleteUserStage(Request $request,
        UserStageRepositories $userStageRepositories) {
        $user_stage_id = $request->id_delete;
        $result = $userStageRepositories->userStageDelete($user_stage_id);
        return redirect()->route('admin.user_stage')->with([
            'flash_level' => $result["status"],
            'flash_message' => $result["message"],
        ]);
    }
    /* user_stage end */

    /* Media start */
    public function getMedia(Request $request,
        MediaRepositories $mediaRepositories) {
        $data['list'] = $mediaRepositories->getListMedia();
        return view('horserace::backend.site.media.list_media', compact('data'));
    }

    public function addMedia(Request $request)
    {
        return view('horserace::backend.site.media.add_media');
    }

    public function editMedia(Request $request,
        MediaRepositories $mediaRepositories, $id) {
        $data['media'] = $mediaRepositories->getEditMedia($id);
        return view('horserace::backend.site.media.edit_media', compact('data'));
    }

    public function storeMedia(MediaRequest $request,
        MediaRepositories $mediaRepositories) {
        $input = $request->all();
        $result = $mediaRepositories->mediaStore($input);
        return redirect()->route('admin.media')->with([
            'flash_level' => $result["status"],
            'flash_message' => $result["message"],
        ]);
    }

    public function deleteMedia(Request $request,
        MediaRepositories $mediaRepositories) {
        $obj_media = new Media();
        $obj_user = new User();

        $media_id = $request->id_delete;
        $media = $obj_media->getMediaById($media_id);
        $result = $mediaRepositories->mediaDelete($media_id);

        // Delete user
        $obj_user->deleteUserByMediaCode($media->code);

        return redirect()->route('admin.media')->with([
            'flash_level' => $result["status"],
            'flash_message' => $result["message"],
        ]);
    }
    /* Media end */

}
