<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = ['title','user_id','color', 'start', 'end', 'obs'];
    protected $guarded = false;
    protected $table = 'events';





}
