<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo', 
        'descripcion', 
        'imagen', 
        'user_id'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class)->select(['name', 'username']);
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    //Metodo para verificar si un usuario le ha dado me gusta a el post
    public function checkLike(User $user)
    {
        //Busca si en la tabla de likes de la BD si el id de un usuario se encuentra registrado de haber dado like
        return $this->likes->contains('user_id', $user->id);
    }
}
