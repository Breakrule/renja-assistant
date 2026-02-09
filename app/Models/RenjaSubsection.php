<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RenjaSubsection extends Model
{
    use HasFactory;
    
    // Timestamps disabled as this is structural/configuration data that doesn't need tracking
    public $timestamps = false;

    protected $fillable = [
        'renja_section_id',
        'kode_subbab',
        'judul',
        'tipe',
        'status',
    ];
    public function section()
    {
        return $this->belongsTo(RenjaSection::class, 'renja_section_id');
    }
    public function contentBlock()
    {
        return $this->hasOne(ContentBlock::class);
    }

}
