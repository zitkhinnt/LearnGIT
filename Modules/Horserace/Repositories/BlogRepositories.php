<?php
/**
 * Date 2018-09-10
 */

namespace Modules\Horserace\Repositories;

use Modules\Horserace\Entities\Blog;
use Modules\Horserace\Entities\UserAccessBlog;

class BlogRepositories
{
    public function blogStore($input)
    {
        $obj_blog = new Blog();
        $arr_blog = [
            'title' => trim($input['title']),
            'status' => trim($input['status']),
            'content' => trim($input['content']),
            'public_at' => trim($input['public_at']),
            'public_end' => trim($input['public_end']),
        ];

        if (trim($input['id']) == 0) {
            //insert
            $blog_id = $obj_blog->insertBlog($arr_blog);
            $result = [
                "status" => "success",
                "message" => __("horserace::be_msg.add_blog_success"),
            ];
        } else {
            //update
            $obj_blog->updateBlog(trim($input['id']), $arr_blog);
            $result = [
                'status' => 'success',
                'message' => __("horserace::be_msg.edit_blog_success"),
            ];
        }
        return $result;
    }

    public function getEditBlog($id)
    {
        $obj_blog = new Blog();
        $data_edit_blog = $obj_blog->getBLogById($id);
        return $data_edit_blog;
    }

    public function getListBlog()
    {
        $obj_blog = new Blog();
        $list_blog = $obj_blog->getBlog();
        return $list_blog;
    }

    public function getListBlogPublic()
    {
        $obj_blog = new Blog();
        $list_blog = $obj_blog->getBlogPublic();
        return $list_blog;
    }

    public function getFristBlogPublic()
    {
        $obj_blog = new Blog();
        $list_blog = $obj_blog->getBlogPublic();
        if(count($list_blog)>0)
            return $list_blog[0];
        return null;
    }

    public function blogDelete($id)
    {
        $obj_blog = new Blog();
        $obj_blog->deleteBlog($id);
        $result = [
            "status" => "success",
            "message" => __("horserace::be_msg.deleted_blog_success"),
        ];
        return $result;
    }

    public function feGetBlogDetail($user_id, $blog_id)
    {
        $obj_blog = new Blog();
        $obj_user_access_blog = new UserAccessBlog();
        // Add access
        // Check have access
        if ($obj_user_access_blog->haveAccessBlog($user_id, $blog_id)) {
            // Update
            $obj_user_access_blog->addAccessBlog($user_id, $blog_id);
        } else {
            // Add
            $arr_access_blog = [
                "user_id" => $user_id,
                "blog_id" => $blog_id,
                "number_access" => 1,
            ];
            $obj_user_access_blog->insertUserAccessBlog($arr_access_blog);
            $obj_blog->addAccessBlog($blog_id);
        }

        $blog = $obj_blog->getBLogById($blog_id);
        return $blog;
    }

}
