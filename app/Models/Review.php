<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = ['description'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
