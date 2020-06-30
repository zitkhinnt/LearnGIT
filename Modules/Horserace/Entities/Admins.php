<?php

namespace Modules\Horserace\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use Modules\Horserace\Notifications\AdminResetPasswordNotification;

class Admins extends Authenticatable
{
  use Notifiable;

  protected $guard = 'admin';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name', 'email', 'login_id', 'password'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token',
  ];

//  public function sendPasswordResetNotification($token)
//  {
//    $this->notify(new AdminResetPasswordNotification($token));
//  }
}
