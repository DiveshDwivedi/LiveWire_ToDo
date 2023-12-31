<div>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    @include('livewire.includes.create-todo-box')
    @include('livewire.includes.search-box')

    <div id="todos-list">
        @foreach ($todos as $todo)
        @include('livewire.includes.todo-cart')
        @endforeach

        <div class="my-2">
            <!-- Pagination goes here -->
            {{ $todos->links() }}
        </div>
    </div>
</div>
