<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RenjaReview extends Model
{
    protected $fillable = [
        'renja_id',
        'user_id',
        'catatan',
        'status', // revisi | disetujui
    ];

    public function renja()
    {
        return $this->belongsTo(Renja::class);
    }
}
