<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $fillable = [
        'nama', 'jenis', 'release_year', 'actors', 'deskripsi', 'foto', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

