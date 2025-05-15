<div class="max-w-xl mx-auto mt-10 p-6">
    <form wire:submit.prevent="addTodo" class="flex mb-4">
        <input wire:model="title" type="text" placeholder="Nouvelle tâche..."
               class="flex-grow border border-gray-300 p-2 rounded-l focus:outline-none focus:border-blue-500">
        <button type="submit" class="bg-blue-600 text-white px-4 rounded-r">Ajouter</button>
    </form>
    <ul>
        @foreach($todos as $todo)
            <li class="flex justify-between items-center border-b py-2">
                <div class="flex items-center">
                    <input type="checkbox" wire:click="toggleCompleted({{ $todo->id }})"
                           @checked($todo->completed) class="mr-2">
                    <span @class(['line-through' => $todo->completed])>{{ $todo->title }}</span>
                </div>
                <button wire:click="deleteTodo({{ $todo->id }})"
                        class="text-red-600 hover:underline">Supprimer</button>
            </li>
        @endforeach
    </ul>
</div>

