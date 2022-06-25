<?php
use Illuminate\Support\Str;

define("PAGELIST", "liste");
define("PAGECREATEFORM", "create");
define("PAGEEDITFORM", "edit");
define("DEFAULTPASSWORD", "password");

//Recupère le nom et prenom de l' utilisateur
function userFullName(){
    return auth()->user()->prenom." ".auth()->user()->nom;
}

//ne fonctionne pas
function setMenuClass($route, $classe){
    $routeActuel = request()->route()->getName();
    if(contains($routeActuel, $route)){
        return $classe;
    }
    return "";
}

function setMenuActive($route){
    $routeActuel = request()->route()->getName();
    if($routeActuel === $route){
        return "active";
    }
    return "";
}

function contains($container, $contenu){
    return Str::contains($container, $contenu);
}

//Recupère le rôle ou les rôles de l'utilisateur
function getRolesName(){
    $rolesName = "";
    $i=0;
    foreach(auth()->user()->roles as $role){
        $rolesName .= $role->role;

        if($i < sizeof(auth()->user()->roles)-1){
            $rolesName .= ",";
        }

        $i++;
        
    }

    return $rolesName;
}

?>