<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Fund extends Model
{
    use HasFactory;

    protected $table = 'funds';

    protected $fillable = [
        'name',
        'fund_amount',
        'start_date',
        'end_date',
        'category_id',
        'details',
        'image',
        'owner_email',
        'status',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}




