<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    // ( ˶°ㅁ°) !! commentaire des blogs: 
    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }
    //-------- commandes:
    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }
    // ( ˶°ㅁ°) !! user à un adresse
    public function adresse()
    {
        return $this->hasOne(Adresse::class);
    }
    // favoris
        public function favoris()
    {
        return $this->belongsToMany(Produit::class, 'favoris');
    }
}
