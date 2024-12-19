<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'parent_id',
        'external_id',
    ];

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->with('children');
    }


    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }
}