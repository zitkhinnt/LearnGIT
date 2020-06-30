<?php
/**
 * Date 2018-09-10
 */

namespace Modules\Horserace\Repositories;

use DB;
use DateTime;
use hasFile;
use Modules\Horserace\Entities\Blog;
use Modules\Horserace\Entities\TransactionPayment;
use Modules\Horserace\Entities\User;
use Modules\Horserace\Entities\UserAccessBlog;
use Modules\Horserace\Entities\Venue;

class UserAccessBlogRepositories
{
  public function getUserAccessByBlogId($blog_id)
  {
    $obj_user_access_blog = new UserAccessBlog();
    $obj_user = new User();

    // Get user access
    $data = $obj_user_access_blog->getUserAccessByBlogId($blog_id);

    // Get info user
    foreach ($data as $key => $item) {
      $user = $obj_user->getUserById($item->user_id);
      $data[$key]->info = $user;
    }

    return $data;
  }
}