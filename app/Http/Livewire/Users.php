<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Users extends Component
{
    public $usersData;
    public $nowPage = 1;
    public $pages = 10;
    public $confirming;
    public $mesage_notification;
    public $query;

    public $rol, $user, $user_model;

    public function rules()
    {
        if($this->user_model){
            return [
                'user.nombre' => 'required',
                'user.email' => 'required|email',
                'user.contraseña' => 'required|min:5',
                'rol' => 'required',
            ];
        }else{
            return [
                'user.nombre' => 'required',
                'user.email' => 'required|email|unique:users,email',
                'user.contraseña' => 'required|min:5',
                'rol' => 'required',
            ];
        }

    }

    protected $messages = [
        'user.nombre' => 'El campo nombre es requerido',
        'user.email' => 'El campo email es requerido o está repetido',
        'user.contraseña' => 'El campo contraseña es requerido',
        'rol' => 'El campo rol es requerido',
    ];

    public function render()
    {
        $users = $this->usersData->slice(($this->nowPage - 1) * $this->pages)->take($this->pages);
        return view('livewire.users', ['users' => $users]);
    }

    public function mount()
    {
        $this->usersData = User::get();
    }

    public function search()
    {
        $this->usersData = User::where('name', 'like', '%' . $this->query . '%')
            ->orWhere('email', 'like', '%' . $this->query . '%')
            ->get()->take($this->pages);
    }


    public function nextPage()
    {
        $this->nowPage++;
        $this->render();
    }

    public function afterPage()
    {
        $this->nowPage--;
        $this->render();
    }

    public function delete($id)
    {
        $this->usersData->find($id)->delete();
        $this->mesage_notification = "El usuario ha sido eliminado";
        $this->dispatchBrowserEvent('notification');
        $this->mount();
    }

    public function confirmDelete($id)
    {
        $this->confirming = $id;
    }


    public function changeRole($userId, $role, $newRole)
    {

        $user = User::find($userId);

        $user->removeRole($role);
        $user->assignRole($newRole);

        $user->save();
        $this->mesage_notification = "El rol del usuario ha sido cambiado";
        $this->dispatchBrowserEvent('notification');
        $this->mount();

    }

    public function formNewUser()
    {
        $this->clean();
        $this->dispatchBrowserEvent('openModal');
    }

    public function saveNewUser()
    {
        $this->validate();
        DB::beginTransaction();
    
        try {
            $user = new User;
            $user->name = $this->user['nombre'];
            $user->email = $this->user['email'];
            $user->password = $this->user['contraseña'];

            $user->save();
            $user->assignRole($this->rol);

            DB::commit();

            $this->mesage_notification = "El usuario ha sido creado";
            $this->dispatchBrowserEvent('notification');
            $this->dispatchBrowserEvent('closeModal');
            $this->clean();
            $this->mount();
            return;
        } catch (\Exception $e) {
            DB::rollback();

            $this->mesage_notification = "Error: " . $e;
            $this->dispatchBrowserEvent('notification');
            $this->dispatchBrowserEvent('closeModal');
            $this->mount();
            return;
        }
    }

    public function modalUpdateUser($id)
    {
        $this->user_model = User::find($id);
        $this->user['nombre'] = $this->user_model->name;
        $this->user['email'] = $this->user_model->email;
        $this->rol = "0";
        $this->dispatchBrowserEvent('openModalUpdate');
    }

    public function updateUser()
    {
        $this->validate();
        DB::beginTransaction();
        try {
            $this->user_model->name = $this->user['nombre'];
            $this->user_model->email = $this->user['email'];
            $this->user_model->password = $this->user['contraseña'];

            $this->user_model->save();

            DB::commit();

            $this->mesage_notification = "El usuario ha sido editado";
            $this->dispatchBrowserEvent('notification');
            $this->dispatchBrowserEvent('closeModalUpdate');
            $this->clean();
            $this->mount();
            return;
        } catch (\Exception $e) {
            DB::rollback();

            $this->mesage_notification = "Error: " . $e;
            $this->dispatchBrowserEvent('notification');
            $this->dispatchBrowserEvent('closeModalUpdate');
            return;
        }
    }


    public function clean()
    {
        $this->user['nombre'] = "";
        $this->user['email'] = "";
        $this->user['contraseña'] = "";
        $this->user_model = null;
        return;
    }
}
