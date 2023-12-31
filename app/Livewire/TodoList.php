<?php

namespace App\Livewire;

use App\Models\Todo;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\WithPagination;

class TodoList extends Component
{
    use WithPagination;
    #[Rule('required|min:3|max:50')]

    public $name;
    public $search;
    public $editingTodoID;
    #[Rule('required|min:3|max:50')]

    public $editingTodoName;

    public function create() {
        // validate
        // create todo
        // clear input
        // send flash error message

        $validated = $this->validateOnly('name');

        Todo::create($validated);

        $this->reset('name');

        session()->flash('success', 'Created');

        $this->resetPage();
    }

    public function edit($todoID) {
        $this->editingTodoID = $todoID;

        $this->editingTodoName = Todo::findOrfail($todoID)->name;
    }

    public function delete($todoID) {
        Todo::findOrfail($todoID)->delete();
    }

    public function toggle($todoID) {
        $todo = Todo::findOrfail($todoID);

        $todo->completed = !$todo->completed;

        $todo->save();
    }

    public function cancelEditing() {
        $this->reset('editingTodoID', 'editingTodoName');
    }

    public function update() {
        $this->validateOnly('editingTodoName');
        Todo::findOrfail($this->editingTodoID)->update([
            'name' => $this->editingTodoName
        ]);

        $this->cancelEditing();
    }
    public function render()
    {
        return view('livewire.todo-list',['todos' => Todo::latest()->where('name', 'like', "%{$this->search}%")->paginate(5)]);
    }
}
