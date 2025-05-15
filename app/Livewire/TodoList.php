<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Todo;
use Illuminate\Support\Facades\Auth;

class TodoList extends Component
{
    public $title;

    public function addTodo()
    {
        $this->validate(['title' => 'required|string|max:255']);

        Todo::create([
            'title' => $this->title,
            'user_id' => Auth::id(),
        ]);

        $this->reset('title');
    }

    public function toggleCompleted($id)
    {
        $todo = Todo::where('user_id', Auth::id())->findOrFail($id);
        $todo->completed = !$todo->completed;
        $todo->save();
    }

    public function deleteTodo($id)
    {
        $todo = Todo::where('user_id', Auth::id())->findOrFail($id);
        $todo->delete();
    }

    public function render()
    {
        return view('livewire.todo-list', [
            'todos' => Todo::where('user_id', Auth::id())->latest()->get(),
        ])->layout('components.layouts.app');
    }
}

