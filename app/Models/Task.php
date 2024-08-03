<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'start_at',
        'end_at',
        'deleted_at',
    ];

    public function scopeSearch($query, $searchTerms)
    {
        if (isset($searchTerms['status'])) {
            $query->where('status', $searchTerms['status']);
        }
        if (isset($searchTerms['start_at']) && isset($searchTerms['end_at'])) {
            $query->whereBetween('start_at', [$searchTerms['start_at'], $searchTerms['end_at']]);
        }
        
        return $query;
    }

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
        ];
    }
    protected $dates = ['deleted_at'];
}
