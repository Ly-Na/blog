<?php

namespace App\Http\Livewire;

use App\Models\Salle;
use Livewire\Component;

class Salles extends Component
{
    public $Salles, $numero, $description, $Salle_id;
    public $isOpen = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function render()
    {
        $this->Salles = Salle::all();
        return view('livewire.salles.Salles');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function openModal()
    {
        $this->isOpen = true;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function closeModal()
    {
        $this->isOpen = false;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    private function resetInputFields()
    {
        $this->title = '';
        $this->body = '';
        $this->Salle_id = '';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function store()
    {
        $this->validate([
            'numero' => 'required',
            'description' => 'required',
        ]);

        Salle::updateOrCreate(['id' => $this->Salle_id], [
            'numero' => $this->numero,
            'description' => $this->description,
        ]);

        session()->flash('message',
            $this->Salle_id ? 'Salle Updated Successfully.' : 'Salle Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function edit($id)
    {
        $Salle = Salle::findOrFail($id);
        $this->Salle_id = $id;
        $this->numero = $Salle->numero;
        $this->description = $Salle->description;

        $this->openModal();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        Salle::find($id)->delete();
        session()->flash('message', 'Salle Deleted Successfully.');
    }
}
