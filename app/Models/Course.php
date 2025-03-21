<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users;
use App\Models\Categories;
class Course extends Model
{
    protected $table = 'courses';

    protected $fillable = [
        'title',
        'description',
        'thumbnail',
        'price',
        'discount',
        'user_id',
        'category_id',
        'user_id',
    ];
    
    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }
}
