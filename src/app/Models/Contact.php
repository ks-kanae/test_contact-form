<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'first_name',
        'last_name',
        'gender',
        'email',
        'tel',
        'address',
        'building',
        'detail',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeKeywordSearch($query, $keyword)
    {
        if ($keyword !== null && $keyword !== '') {
            $query->where(function ($q) use ($keyword) {
            $q->where('first_name', 'like', '%' . $keyword . '%')
            ->orWhere('last_name', 'like', '%' . $keyword . '%')
            ->orWhere('email', 'like', '%' . $keyword . '%');
            });
        }
    }

    public function scopeGender($query, $gender)
    {
        if ($gender !== null && $gender !== '') {
        $query->where('gender', $gender);
    }
    }

    public function scopeCategory($query, $categoryId)
    {
    if ($categoryId !== null && $categoryId !== '') {
        $query->where('category_id', $categoryId);
    }
    }

    public function scopeCreatedDate($query, $date)
{
    if ($date !== null && $date !== '') {
        $query->whereDate('created_at', $date);
    }
}
}
