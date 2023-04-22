<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notify extends Model
{
    use HasFactory;
    protected $table = 'notifys';
    protected $fillable = [
        'title', 'content', 'starttime', 'endtime', 'status'
    ];



    public function getStarttimeAttribute($value)
    {
        return Carbon::createFromDate($value);
    }

    public function getEndtimeAttribute($value)
    {
        return Carbon::createFromDate($value);
    }
}
