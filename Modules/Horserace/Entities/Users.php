<?php

namespace Modules\Horserace\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
//use Modules\Manavita\Notifications\UserResetPasswordNotification;
use DB;

class Users extends Authenticatable
{
  use Notifiable;

  protected $table = 'users';

  protected $guard = 'user';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    "login_id",
    "user_key",
    "password_text",
    "nickname",
    "deleted_flg",
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token',
  ];
}
