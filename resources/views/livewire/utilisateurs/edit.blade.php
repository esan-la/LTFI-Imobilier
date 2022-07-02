 <div class="row p-4 pt-5">
            <div class="col-md-6">

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-user-plus fa-2px"></i> Formulaire d'édition utilisateur</h3>
                    </div>

                    <form role="form" wire:submit.prevent="updateUser()">
                        <div class="card-body">
                            
                                <div class = "d-flex">
                                    <div class="form-group flex-grow-1 mr-2">
                                        <label>Nom</label>
                                        <input type="text" wire:model="editUser.nom" class="form-control @error('editUser.nom') is-invalid @enderror">
                                        @error("editUser.nom")
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                               
                                    <div class="form-group flex-grow-1">
                                        <label>prénom</label>
                                        <input type="text" wire:model="editUser.prenom" class="form-control @error('editUser.prenom') is-invalid @enderror">
                                        @error("editUser.prenom")
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                    


                            <div class="form-group">
                                <label>Sexe</label>
                                <select class="form-control @error('editUser.sexe') is-invalid @enderror" wire:model="editUser.sexe">
                                    <option value="">---------</option>
                                    <option value="H">Homme</option>
                                    <option value="F">Femme</option>
                                </select>
                                @error("editUser.sexe")
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Adresse e-mail</label>
                                <input type="email" wire:model="editUser.email" class="form-control @error('editUser.email') is-invalid @enderror">
                                @error("editUser.email")
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class = "d-flex">
                                <div class="form-group flex-grow-1 mr-2">
                                    <label>Téléphone 1</label>
                                    <input type="text" wire:model="editUser.telephone1" class="form-control @error('editUser.telephone1') is-invalid @enderror">
                                    @error("editUser.telephone1")
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror

                                </div>
                               
                                <div class="form-group flex-grow-1">
                                    <label>Téléphon 2</label>
                                    <input type="text" wire:model="editUser.telephone2" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Pièce d'identité</label>
                                <select class="form-control @error('editUser.pieceIdentite') is-invalid @enderror" wire:model="editUser.pieceIdentite">
                                    <option value="">---------</option>
                                    <option value="CNI">CNI</option>
                                    <option value="PASSPORT">PASSPORT</option>
                                    <option value="PERMIS DE CONDUIRE">PERMIS DE CONDUIRE</option>
                                </select>
                                @error("editUser.pieceIdentite")
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="form-group flex-grow-1">
                                <label>Numéro de pièce d'identité</label>
                                <input type="text" wire:model="editUser.numeroPieceIdentite" class="form-control @error('editUser.telephone1') is-invalid @enderror">
                                @error("editUser.numeroPieceIdentite")
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Appliquer les modifications</button>
                            <button type="button" wire:click="goToListUser()" class="btn btn-danger">Retourner à la liste des utilisateurs</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                 <h3 class="card-title"><i class="fas fa-key fa-2px"></i> Réinitialisation de mot passe</h3>
                            </div>
                            <div class="card-body">
                                <ul>
                                    <li>
                                        <a href="#" class="btn btn-link" wire:click.prevent="confirmPwdReset">Réinitialiser le mot de passe</a>
                                        <span>( Par défaut : "password" )</span>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-12 pt-4">
                        <div class="card card-primary">
                            <div class="card-header d-flex align-items-center">
                                 <h3 class="card-title flex-grow-1"><i class="fas fa-fingerprint fa-2px"></i> Roles & Permissions</h3>
                                 <button class="btn bg-gradient-success" wire:click="updateRoleAndPermissions"><i class="fas fa-check"></i> Appliquer les modifications</button>
                            </div>
                            <div class="card-body">
                                <div class="accordion">
                                    
                                    @foreach ($rolePermissions["roles"] as $role)
                                    
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between">
                                            <h4 class="card-title flex-grow-1">
                                                <a data-parent="#accordion" href="#" aria-expanded="true">
                                                    {{$role["role_role"]}}
                                                </a>
                                            </h4>
                                            <div class="custom-switch custom-switch-off-danger custom-switch-on-success">
                                                <input type="checkbox" class="custom-control-input" wire:model.lasy="rolePermissions.roles.{{$loop->index}}.active" @if($role["active"]) checked @endif id="customSwitch{{$role['role_id']}}">
                                                <label class="custom-control-label" for="customSwitch{{$role['role_id']}}"> {{ $role["active"]? "Active" : "Desactivé" }} </label>
                                            </div>
                                        </div>
                                    </div>
                                     @endforeach

                                     {{--@json($rolePermissions["roles"])--}}

                                    <div class="">
                                        <table class="table table-bordered">
                                            <thead>
                                                <th>Permissions</th>
                                                <th></th>
                                            </thead>
                                            <tbody>
                                                
                                                @foreach ($rolePermissions["permissions"] as $permission)

                                                <tr>
                                                    <td>{{$permission["permission_nom"]}}</td>
                                                    <td>
                                                        <div class="custom-switch custom-switch-off-danger custom-switch-on-success">
                                                            <input type="checkbox" class="custom-control-input" @if($permission["active"]) checked @endif wire:model.lasy="rolePermissions.permissions.{{$loop->index}}.active" id="customSwitchPermission{{$permission["permission_id"]}}">
                                                            <label class="custom-control-label" for="customSwitchPermission{{$permission["permission_id"]}}"> {{ $permission["active"]? "Active" : "Desactivé" }} </label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>

