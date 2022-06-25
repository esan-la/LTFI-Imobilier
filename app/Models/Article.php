<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    public function type()
    {
       return $this->belongsTo(Type_article::class, "type_article_id", "id");
    }

    public function tarifications(){
        return $this->hasMany(Tarification::class);
    }

    public function locations(){
        return $this->belongsToMany(Location::class, "article_location", "article_id", "location_id");
    }

    public function propriete_articles(){
        return $this->belongsToMany(Propriete_article::class, "article_proprietes", "article_id", "propriete_article_id");
    }
}
