<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propriete_article extends Model
{
    use HasFactory;

    public function type_article(){
        return $this->belongsTo(Type_article::class);
    }

    public function articles(){
        return $this->belongsToMany(Article::class, "article_proprietes", "propriete_article_id", "article_id");
    }
}
