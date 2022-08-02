<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HistoryMemo extends Model
{
    use HasFactory;
    protected $fillable = [
        'memo_id',
        'catatan',
        'bukti'
    ];
    public $incrementing = false;

    protected $keyType = 'string';

    public static function boot(){
        parent::boot();

        static::creating(function ($issue) {
            $issue->id = Str::uuid(36);
        });
    }

    public function getBuktiUrlAttribute(){
        return url('storage/'. $this->bukti);
    }
    protected $appends = [
        'bukti_url',

    ];
    public function memo(){
        return $this->belongsTo(Memo::class,'memo_id');
    }
}
