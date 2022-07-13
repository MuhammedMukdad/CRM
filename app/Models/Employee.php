<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Employee extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable=['name','role','isAdmin','password','remember_token','email','phone','address','description','department_id'];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function notifications(){
        return $this->hasMany(Notification::class,'sender_id','id');
    }

    public function receivedNotifications(){
        return $this->belongsToMany(Notification::class,'received_notifications','receiver_id','notification_id','id','id');
    }

    public function department(){
        return $this->belongsTo(Department::class,'department_id','id');
    }

    public function services(){
        return $this->belongsToMany(Service::class,'service_employees','employee_id','service_id','id','id');

    }
}
