<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Type_article;
use Livewire\WithPagination;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class TypeArticleComp extends Component
{
    use WithPagination; //Traite de pagination

    public $search = ""; //variable à mapper wire model
    public $isAddTypeArticle = False;
    public $newTypeArticleName = "";
    public $newValue="";

    protected $paginationTheme = "bootstrap"; // d'utiliser bootstrap au lieu de TailwindCss

    public function render()
    {
        Carbon::setLocale("fr");
        $searchCriteria = "%".$this->search."%";//critère de recherche
        //Données à envoyer dans TypeArticle
        $data = [
            "typearticles" => Type_article::where("nom","like",$searchCriteria)->latest()->paginate(4) // Cherch dans le model TypeArticle
        ];

        return view('livewire.typearticles.index', $data)
        ->extends('layouts.master')
        ->section('contenu');
    }

    public function toggleShowAddTypeArticleForm(){
        if($this->isAddTypeArticle){
            $this->isAddTypeArticle = False;
            $this->newTypeArticleName = "";
            $this->resetErrorBag(['newTypeArticleName']);
        }else{
            $this->isAddTypeArticle = True;
        }
    }

    public function addTypeArticle(){
        $validated = $this->validate([
            "newTypeArticleName" => "required|max:50|unique:Type_articles,nom"
        ]);
        Type_article::create(["nom" => $validated["newTypeArticleName"]]);
        $this->toggleShowAddTypeArticleForm();

        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Type d'article ajouté avec succès !"]);
    }

    // Utilisation de l'injection de dependance pour que ELOQUENT recupère directement le id
    public function editTypeArticle(Type_article $typeArticle){
        //$typeArticle = Type_article::find($id);
        $this->dispatchBrowserEvent("showEditForm", ["typearticle" => $typeArticle]);
    }

    public function updateTypeArticle($id, $value){
        $this->newValue = $value;
        //dump($id);
        $validated = $this->validate([
            "newValue" => ["required", "max:50", Rule::unique("type_articles","nom")->ignore($id)]
        ]);
        
        //dump("sdfghj");
        Type_article::find($id)->update(["nom" => $validated["newValue"]]);

        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Type d'article mise à jour avec succès !"]);
    }

    public function confirmDelete($name, $id){
        $this->dispatchBrowserEvent("showConfirmMessage", ["message" => [
            "text"=>"Vous êtes sur le point de supprimer $name de la liste des types d'article.",
            "title"=>"Êtes-vous sûre de continuer?",
            "type"=>"warning",
            "data"=> [

                "type_article_id"=> $id
            
                ]
            ]
        ]);
    }

    public function deleteTypeArticle(Type_article $typearticle){
        $typearticle->delete();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Type d'article supprimé avec succès !"]);
    }
}