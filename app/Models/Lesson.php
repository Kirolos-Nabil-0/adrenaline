<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $hidden = ['created_at', 'updated_at'];

    public function section()
    {
        return $this->belongsTo('App\Models\Section' , 'section_id' , 'id');
    }

    protected function getVideoAttribute($value){
        if($value){
            return asset('uploaded/videos/'.$value) ;
        }else{
            return $value;
        }
    }
    protected function getPdfAttachAttribute($value){
        if($value){
            return asset('uploaded/attachments/'.$value) ;
        }else{
            return $value;
        }
    }

}