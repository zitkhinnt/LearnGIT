<?php
/**
 * Date 2018-09-10
 */

namespace Modules\Horserace\Repositories;

use File;
use Modules\Horserace\Entities\Page;

class PageRepositories
{
    public function pageStore($input)
    {
        $obj_page = new Page();
        $arr_page = [
            'name' => trim($input['name']),
            'code' => trim($input['code']),
            'link' => trim($input['link']),
            'source' => trim($input['source']),
        ];

        if (trim($input['id']) == 0) {
            $page = $obj_page->insertPage($arr_page);
            $result = [
                "status" => "success",
                "message" => __("horserace::be_msg.add_page_success"),
            ];
        } else {
            $obj_page->updatePage(trim($input['id']), $arr_page);
            $result = [
                'status' => 'success',
                'message' => __("horserace::be_msg.edit_page_success"),
            ];
        }
        $this->createFile(trim($input['code']), trim($input['source']));
        return $result;
    }

    public function getEditPage($id)
    {
        $obj_page = new Page();
        $data_edit_page = $obj_page->getPageById($id);
        return $data_edit_page;
    }

    public function getListPage()
    {
        $obj_page = new Page();
        $list_page = $obj_page->getPage();
        return $list_page;
    }

    public function pageDelete($id)
    {
        $obj_page = new Page();
        $del_page = $obj_page->deletePage($id);
        $result = [
            "status" => "success",
            "message" => __("horserace::be_msg.deleted_page_success"),
        ];
        return $result;
    }

    public function createFile($code, $source)
    {
        $name_file = $code . '.blade.php';
        $path_file = '../Modules/Horserace/Resources/views/dynamic_page/' . $name_file;
        File::put($path_file, $source);
    }

}
