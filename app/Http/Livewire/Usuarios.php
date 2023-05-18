<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class Usuarios extends Component
{
    public $usersData;
    public $nowPage = 1;
    public $pages = 2;
    public $confirming;
    public $mesage_notification;
    public $query;

    public function render()
    {
        $users = $this->usersData->slice(($this->nowPage - 1) * $this->pages)->take($this->pages);
        return view('livewire.usuarios', ['users' => $users]);
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
}
