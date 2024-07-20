<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;




class User extends Authenticatable
{
    // use HasApiTokens, HasFactory, Notifiable;
    
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'mobile', 'roles_name', 'status', 'created_by', 'salary', 'department_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'roles_name' => 'array',
    ];


    //use accessors
    //this will return arabic data if app language is arabic and english data if not 
    public function getNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }



    /** start relations **/
    public function media()
    {
        return $this->morphOne(Media::class,'mediable');
    }



    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }



    public function creators()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    public function tasks()
    {
        return $this->hasMany(Task::class, 'employee_id');
    }



    public function tasks_by()
    {
        return $this->hasMany(Task::class, 'created_by');
    }
    /** end relations **/
}
