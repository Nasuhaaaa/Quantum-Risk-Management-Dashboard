<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The primary key associated with the model.
     *
     * @var string
     */
    protected $primaryKey = 'User_ID';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'Kata_Laluan',
        'password',
        'Jenis_Pengguna',
        'ID_Agensi',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'Kata_Laluan',
        'remember_token',
    ];

    /**
     * Get the name of the unique identifier for the user.
     * Use 'username' instead of the default 'email'
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'username';
    }

    /**
     * Get the name of the password attribute for the user.
     * Use 'Kata_Laluan' instead of 'password'
     *
     * @return string
     */
    public function getAuthPasswordName()
    {
        return 'Kata_Laluan';
    }

    /**
     * Get the password attribute (maps Kata_Laluan to password for Auth)
     *
     * @return mixed
     */
    public function getAuthPassword()
    {
        return $this->getAttribute('Kata_Laluan');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    /**
     * Set the Kata_Laluan (password) attribute - hash it
     *
     * @param  string  $value
     * @return void
     */
    protected function setKataLaluanAttribute($value)
    {
        $this->attributes['Kata_Laluan'] = bcrypt($value);
    }

    public function jenisPengguna()
    {
        return $this->belongsTo(JenisPengguna::class, 'Jenis_Pengguna', 'role_id');
    }

    public function agensi()
    {
        return $this->belongsTo(Agensi::class, 'ID_Agensi', 'id');
    }

    public function getRoleTypeAttribute()
    {
        $jenisPengguna = $this->jenisPengguna?->jenis_pengguna ?? '';

        // Map jenis pengguna to role type
        $roleMap = [
            'Sistem Admin' => 'admin',
            'Ketua Sektor' => 'ketua_sektor',
            'Pengurusan' => 'pengurusan',
            'Entiti (Agensi)' => 'entiti',
        ];

        return $roleMap[$jenisPengguna] ?? 'entiti';
    }

}
