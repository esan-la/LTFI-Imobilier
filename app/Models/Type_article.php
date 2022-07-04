<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type_article extends Model
{
    use HasFactory;

    protected $fillable = ["nom"];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function propriete_articles(){
        return $this->hasMany(Propriete_article::class);
    }

}
