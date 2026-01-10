<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RenjaSubsection extends Model
{
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
