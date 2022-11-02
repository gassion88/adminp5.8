<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Scopes\ZoneScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gsm extends Model
{
    use HasFactory;



    protected $table = 'gsm';


}
