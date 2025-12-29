<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ulasan extends Model
{
    use HasFactory;
    protected $table = 'ulasan';
    protected $primaryKey = 'id_ulasan';
    protected $fillable = [
        'nama',
        'email',
        'rating',
        'komentar'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id_customer');
    }
     public function setEmailAttribute($value)
    {
        $this->attributes['email'] = $value ?: '';
    }
}
