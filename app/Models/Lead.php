<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;
    protected $fillable=['name','email','phone','address','description','profit_amount','state',
                        'arrive_date','service_id','source_id','campaign_id'];
   public function service(){
        return $this->belongsTo(Service::class,'service_id','id');
    }
    public function source(){
        return $this->belongsTo(Source::class,'source_id','id');
    }
    public function campaign(){
        return $this->belongsTo(Campaign::class,'campaign_id','id');
    }
}
