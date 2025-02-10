<?php

namespace App\Http\Livewire;

use App\Models\app\Interaction;
use Livewire\Component;

class InteractionComponent extends Component
{
    // public $interactions;

    public $search = '';
    public $sortBy = 'created_at'; // Columna por la que se ordenará
    public $sortDirection = 'desc'; // Dirección de ordenación (asc o desc)
    public $showModal = false; // Controla la visibilidad del modal
    public $selectedInteraction;
    public $confirmingDeletion = false; // Controla la visibilidad del modal de confirmación


    public function render()
    {
        $query = Interaction::query();

        if ($this->search) {
            $query->where('prompt', 'like', '%' . $this->search . '%')
                ->orWhere('response', 'like', '%' . $this->search . '%');
        }

        // Aplicar ordenación
        $interactions = $query->orderBy($this->sortBy, $this->sortDirection)
                               ->paginate(10);

        return view('livewire.interaction-component', [
            'interactions' => $interactions,
        ]);
    }

    public function sortBy($column)
    {
        if ($this->sortBy === $column) {
            // Si ya está ordenando por esta columna, cambiar la dirección
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            // Cambiar a la nueva columna y reiniciar la dirección
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    /**
     * Abrir el modal con los detalles de la interacción.
     *
     * @param \App\Models\Interaction $interaction
     */
    public function openModal($interactionId)
    {
        $this->selectedInteraction = Interaction::find($interactionId);
        $this->showModal = true;
    }

    /**
     * Cerrar el modal.
     */
    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedInteraction = null;
    }

    public function confirmDeletion($interactionId)
    {
        $this->selectedInteraction = Interaction::find($interactionId);
        $this->confirmingDeletion = true;
    }

    /**
     * Eliminar la interacción seleccionada.
     */
    public function deleteInteraction()
    {
        if ($this->selectedInteraction) {
            $this->selectedInteraction->delete();
            $this->selectedInteraction = null;
            $this->confirmingDeletion = false;
            session()->flash('message', 'Interacción eliminada correctamente.');
        }
    }
}
