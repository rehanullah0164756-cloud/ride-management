<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Rider extends Model
{
    protected $fillable = ['user_id','name','email','phone','address'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rides()
    {
        return $this->hasMany(Ride::class);
    }
}
