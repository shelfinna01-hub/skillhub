<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $fillable = [
        'name',
        'description',
        'instructor',
    ];

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'pendaftaran', 'kelas_id', 'user_id')
            ->withTimestamps();
    }
}
