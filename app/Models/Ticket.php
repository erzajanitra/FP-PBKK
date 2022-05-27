<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $table = 'tickets';
    protected $guarded = ['id'];
    // protected $fillable = ['nama', 'jeniskelamin', 'alamat','noktp','notelp','fotoktp'];

    public function pricelist(){
        return $this->belongsTo(Pricelist::class);
    }
}
