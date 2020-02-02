<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    /**
     * PROPERTIES
     */


    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * RELATIONSHIPS
     */

    public function sessions() {
        return $this->hasMany('App\Models\Quizzes\QuizSession', "user_id");
    }

    public function logs() {
        return $this->hasMany('App\Models\Quizzes\Log', 'user_id');
    }

    /**
     * METHODS
     */

    /**
     * STATIC METHODS
     */
}
