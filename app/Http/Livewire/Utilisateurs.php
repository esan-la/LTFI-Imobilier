<?php

namespace App\Http\Livewire;

use App\Models\Permission;
use App\Models\Role;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\WithPagination;

class Utilisateurs extends Component
{
    use WithPagination;

    //public $isBtnAddClicked = false;
    protected $paginationTheme = "bootstrap";

    public $currentPage = PAGELIST;

    public $newUser = [];
    public $editUser = [];
    public $rolePermissions = [];

   /* protected $rules= [
        'newUser.nom'=> 'required',
        'newUser.prenom'=> 'required',
        'newUser.email'=> 'required | email | unique:users,email',
        'newUser.telephone1'=> 'required | numeric | unique:users,telephone1',
        'newUser.pieceIdentite'=> 'required',
        'newUser.sexe'=> 'required',
        'newUser.numeroPieceIdentite'=> 'required | unique:users,numeroPieceIdentite',
    ];*/

    // remplace carement le message d'erreur par le message ecrit
    protected $messages = [
        'newUser.nom.required' => 'Le nom de l\'utilisateur est requis',
    ];

    //Remplace user.prenom dans le message d'erreur par 'Le prenom'
    protected $validationAttributes = [
        'newUser.prenom' => 'Le prenom',
    ];

    public function render()
    {
        Carbon::setLocale("fr");

        return view("livewire.utilisateurs.index", [
            "users" => User::latest()->paginate(4)
        ])
            ->extends('layouts.master')
            ->section('contenu');
    }

    public function rules(){
        if($this->currentPage == PAGEEDITFORM){
            return [
                'editUser.nom'=> 'required',
                'editUser.prenom'=> 'required',
                'editUser.email'=> ['required', 'email', Rule::unique("users", "email")->ignore($this->editUser['id'])],
                'editUser.telephone1'=> ['required', 'numeric', Rule::unique("users", "telephone1")->ignore($this->editUser['id'])],
                'editUser.pieceIdentite'=> 'required',
                'editUser.sexe'=> 'required',
                'editUser.numeroPieceIdentite'=> ['required', Rule::unique("users", "numeroPieceIdentite")->ignore($this->editUser['id'])],
            ];
        }
            return [
                'newUser.nom'=> 'required',
                'newUser.prenom'=> 'required',
                'newUser.email'=> 'required | email | unique:users,email',
                'newUser.telephone1'=> 'required | numeric | unique:users,telephone1',
                'newUser.pieceIdentite'=> 'required',
                'newUser.sexe'=> 'required',
                'newUser.numeroPieceIdentite'=> 'required | unique:users,numeroPieceIdentite',
            ];
    }

    public function goToAddUser(){
        $this->currentPage = PAGECREATEFORM;
    }

    public function goToEditUser($id){
        $this->editUser = User::find($id)->toArray();
        $this->currentPage = PAGEEDITFORM;

        $this->populateRolePermissions();
    }

    public function populateRolePermissions(){
        $this->rolePermissions["roles"] = [];
        $this->rolePermissions["permissions"] = [];

        $mapForCB = function($value){
            return $value["id"];
        };

        $roleIds = array_map($mapForCB, User::find($this->editUser["id"])->roles->toArray());
        $permissionIds = array_map($mapForCB, User::find($this->editUser["id"])->permissions->toArray());

        foreach(Role::all() as $role){
            if(in_array($role->id, $roleIds)){
                array_push($this->rolePermissions["roles"], ["role_id"=>$role->id, "role_role"=>$role->role, "active"=>true]);
            }else{
                array_push($this->rolePermissions["roles"], ["role_id"=>$role->id, "role_role"=>$role->role, "active"=>false]);
            }
        }
        foreach(Permission::all() as $permission){
            if(in_array($permission->id, $permissionIds)){
                array_push($this->rolePermissions["permissions"], ["permission_id"=>$permission->id, "permission_nom"=>$permission->nom, "active"=>true]);
            }else{
                array_push($this->rolePermissions["permissions"], ["permission_id"=>$permission->id, "permission_nom"=>$permission->nom, "active"=>false]);
            }
        }

        //dump($this->rolePermissions);

    }

    public function updateRoleAndPermissions(){
        DB::table("user_roles")->where("user_id", $this->editUser["id"])->delete();
        DB::table("user_permissions")->where("user_id", $this->editUser["id"])->delete();

        foreach($this->rolePermissions["roles"] as $role){
            if($role["active"]){
                User::find($this->editUser["id"])->roles()->attach($role["role_id"]);
            } 
        }

        foreach($this->rolePermissions["permissions"] as $permission){
            if($permission["active"]){
                User::find($this->editUser["id"])->permissions()->attach($permission["permission_id"]);
            }
        }
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Roles et permissions avec succès !"]);
    }


    public function goToListUser(){
        $this->currentPage = PAGELIST;
        $this->editUser = [];
    }

    public function addUser(){
        

        //Verifier que les informations envoyées par le formulaire sont correctes
        $validationAtributes = $this->validate();

        //Inserer la valeur de password par defaut
        $validationAtributes["newUser"]["password"] = "password";
        $validationAtributes["newUser"]["photo"] = "";
        //dump($validationAtributes);

        //Ajouter un nouvel utilisateur
        User::create($validationAtributes['newUser']);

        // Vider les champs de formulaire
        $this->newUser = [];

        //Message d'evênment de succès
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Utilisateur insérer avec succès !"]);
    }

    public function updateUser(){
       //dump("$this->editUser['id']");
        $validationAttributes = $this->validate();
        User::find($this->editUser['id'])->update($validationAttributes['editUser']);

        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Utilisateur mise à jours avec succès !"]);
    }

    public function confirmPwdReset(){
        $this->dispatchBrowserEvent("showConfirmMessage", ["message" => [
            "text"=>"Vous êtes sur le point de réinitialiser le mot de passe de cet utilisateurs. Voulez-vous continuer?",
            "title"=>"Êtes-vous sûre de continuer?",
            "type"=>"warning",
            ]
        ]);
       
    }

    public function resetPassword(){

        User::find($this->editUser['id'])->update(["password" => Hash::make(DEFAULTPASSWORD)]);
   
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Mot de passe utilisateur réinitialisé avec succès !"]);

    }

    public function confirmDelete($name, $id){
        $this->dispatchBrowserEvent("showConfirmMessage", ["message" => [
            "text"=>"Vous êtes sur le point de supprimer $name de la liste des utilisateurs.",
            "title"=>"Êtes-vous sûre de continuer?",
            "type"=>"warning",
            "data"=> [

                "user_id"=> $id
            
                ]
            ]
        ]);
    }

    public function deleteUser($id){
        User::destroy($id);
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Utilisateur supprimé avec succès !"]);
    }
}
