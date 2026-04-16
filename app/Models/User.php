<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'username',
        'password',
        'remember_token',
        'jenis_pengguna_id',
        'agensi_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [];
    }

    protected function setPasswordAttribute($value): void
    {
        $value = (string) $value;
        $this->attributes['password'] = password_get_info($value)['algo'] ? $value : bcrypt($value);
    }

    public function jenisPengguna()
    {
        return $this->belongsTo(JenisPengguna::class, 'jenis_pengguna_id', 'role_id');
    }

    public function agensi()
    {
        return $this->belongsTo(Agensi::class, 'agensi_id', 'id');
    }

    public function getRoleTypeAttribute(): string
    {
        $jenisPengguna = $this->jenisPengguna?->jenis_pengguna ?? '';

        return match ($jenisPengguna) {
            'Sistem Admin' => 'admin',
            'Ketua Sektor' => 'ketua_sektor',
            'Pengurusan' => 'pengurusan',
            'Entiti (Agensi)' => 'entiti',
            default => 'entiti',
        };
    }
}
