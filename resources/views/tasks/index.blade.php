<x-perl-layout>
    <div class="max-w-2xl mx-auto p-6 text-perl-dark">




{{-- Group tabs --}}
<div class="flex flex-wrap items-center gap-5 mb-6">
    <a href="{{ route('tasks.index') }}"
       class="font-semibold {{ $groupId ? '' : 'underline underline-offset-8 decoration-2' }}">
        all
    </a>

    @foreach ($groups as $group)
        <a href="{{ route('tasks.index', ['group' => $group->id]) }}"
           class="font-semibold {{ $groupId == $group->id ? 'underline underline-offset-8 decoration-2' : '' }}">
            {{ $group->name }}
        </a>
    @endforeach

    {{-- Add group --}}
    <form method="POST" action="{{ route('groups.store') }}" class="flex gap-2">
        @csrf
        <input type="text" name="name" placeholder="+ Add group" required maxlength="50"
               class="rounded-full border border-perl-dark bg-transparent px-4 py-1 text-sm w-36">
        <button class="bg-perl-blue text-white rounded-full px-4 py-1 text-sm">add</button>
    </form>
</div>

{{-- Delete the selected group --}}
@if ($groupId)
    <form method="POST" action="{{ route('groups.destroy', $groupId) }}"
          onsubmit="return confirm('Delete this group? Its tasks will stay, just without a group.')"
          class="mb-4">
        @csrf
        @method('DELETE')
        <button class="text-sm underline">delete this group</button>
    </form>
@endif



       {{-- Add task form --}}
<form method="POST" action="{{ route('tasks.store') }}" class="mb-8"
      x-data="{ open: false, busy: false }"
      @submit="busy = true"
      @keydown.escape="open = false">
    @csrf

    <input type="text" name="title" placeholder="+ add a task" required maxlength="255"
           enterkeyhint="done" autocomplete="off"
           @focus="open = true"
           class="w-full rounded-xl border-0 bg-white text-base py-3 px-4 placeholder-perl-dark/60">

    <div x-show="open" x-transition style="display: none;" class="mt-3 space-y-3">
        <textarea name="description" rows="2" placeholder="add description..."
                  @keydown.enter="if (!$event.shiftKey) { $event.preventDefault(); $el.form.requestSubmit(); }"
                  class="w-full rounded-xl border-0 bg-white text-base"></textarea>

        <div class="flex flex-wrap gap-3">
            <input type="datetime-local" name="deadline"
                   class="flex-1 min-w-[12rem] rounded-xl border-0 bg-white text-base">

            <select name="priority" class="rounded-xl border-0 bg-white text-base">
                <option value="low">Low</option>
                <option value="medium" selected>Medium</option>
                <option value="high">High</option>
            </select>

            <select name="task_group_id" class="rounded-xl border-0 bg-white text-base">
                <option value="">No group</option>
                @foreach ($groups as $group)
                    <option value="{{ $group->id }}" @selected($groupId == $group->id)>{{ $group->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" :disabled="busy"
                class="inline-flex items-center justify-center gap-2 w-full sm:w-auto min-h-[44px]
                       rounded-full bg-white text-perl-dark px-8 py-2 font-semibold shadow-sm
                       active:scale-95 transition disabled:opacity-60">
            Enter <span aria-hidden="true">→</span>
        </button>
    </div>
</form>

        {{-- Sort arrows --}}
<div class="flex gap-3 mb-4 text-xl">
    <a href="{{ route('tasks.index', array_filter(['group' => $groupId, 'sort' => 'asc'])) }}"
       title="Earliest deadline first"
       class="{{ request('sort') === 'desc' ? 'opacity-40' : '' }}">↓</a>
    <a href="{{ route('tasks.index', array_filter(['group' => $groupId, 'sort' => 'desc'])) }}"
       title="Latest deadline first"
       class="{{ request('sort') === 'desc' ? '' : 'opacity-40' }}">↑</a>
</div>

        {{-- Task list --}}
        @forelse ($tasks as $task)
            <div class="flex items-start justify-between mb-5">
                <div class="flex gap-3 flex-1 min-w-0">
                    <form method="POST" action="{{ route('tasks.toggle', $task) }}">
                        @csrf
                        @method('PATCH')
                        <button class="w-5 h-5 mt-1 rounded-full border-2 border-perl-dark"></button>
                    </form>

                    <div class="flex-1 min-w-0">
                        <p class="font-semibold">{{ $task->title }}</p>
                        @if ($task->deadline)
                            <p class="text-sm">{{ $task->deadline->format('M jS, g:i A') }}</p>
                        @endif
                        <p class="text-xs uppercase">{{ $task->priority }} priority</p>

   <div x-data="{ editing: false, busy: false }" class="mt-1">

    {{-- Normal view --}}
    <div x-show="!editing" class="space-y-1">
        @if ($task->description)
            <p class="text-sm">{{ $task->description }}</p>
        @endif
        <button type="button"
                @click="editing = true; $nextTick(() => $refs.title.focus())"
                class="text-sm underline py-1">
            {{ $task->description ? 'edit' : 'add description...' }}
        </button>
    </div>

    {{-- Edit form with the Enter pill --}}
    <form x-show="editing" x-transition style="display: none;"
          method="POST" action="{{ route('tasks.update', $task) }}"
          @submit="busy = true" @keydown.escape="editing = false"
          class="mt-2 space-y-3">
        @csrf
        @method('PATCH')

        <input x-ref="title" type="text" name="title" value="{{ $task->title }}" required
               maxlength="255" enterkeyhint="done"
               class="w-full rounded-xl border-0 bg-white text-base">

        <textarea name="description" rows="2" placeholder="add description..."
                  @keydown.enter="if (!$event.shiftKey) { $event.preventDefault(); $el.form.requestSubmit(); }"
                  class="w-full rounded-xl border-0 bg-white text-base">{{ $task->description }}</textarea>

        <div class="flex flex-wrap gap-3">
            <input type="datetime-local" name="deadline"
                   value="{{ $task->deadline?->format('Y-m-d\TH:i') }}"
                   class="flex-1 min-w-[12rem] rounded-xl border-0 bg-white text-base">

            <select name="priority" class="rounded-xl border-0 bg-white text-base">
                <option value="low" @selected($task->priority === 'low')>Low</option>
                <option value="medium" @selected($task->priority === 'medium')>Medium</option>
                <option value="high" @selected($task->priority === 'high')>High</option>
            </select>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" :disabled="busy"
                    class="inline-flex items-center justify-center gap-2 flex-1 sm:flex-none min-h-[44px]
                           rounded-full bg-white text-perl-dark px-8 py-2 font-semibold shadow-sm
                           active:scale-95 transition disabled:opacity-60">
                Enter <span aria-hidden="true">→</span>
            </button>
            <button type="button" @click="editing = false" class="text-sm underline py-2">cancel</button>
        </div>
    </form>
</div>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    @if ($task->deadline)
                        <span class="countdown border border-perl-dark rounded-full px-3 text-sm"
                              data-deadline="{{ $task->deadline->toIso8601String() }}"></span>
                    @endif

                    <form method="POST" action="{{ route('tasks.destroy', $task) }}">
                        @csrf
                        @method('DELETE')
                        <button class="text-sm underline">delete</button>
                    </form>
                </div>
            </div>
        @empty
            <p>No tasks yet. Add your first one above.</p>
        @endforelse

        {{-- Previous (completed) tasks --}}
<hr class="border-dotted border-perl-dark my-6">

<details>
    <summary class="text-sm cursor-pointer">show previous tasks →</summary>

    <div class="mt-4 space-y-3">
        @forelse ($previous as $task)
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <form method="POST" action="{{ route('tasks.toggle', $task) }}">
                        @csrf
                        @method('PATCH')
                        <button class="w-5 h-5 rounded-full border-2 border-perl-dark bg-perl-dark"
                                title="Mark as not done"></button>
                    </form>
                    <div>
                        <p class="line-through">{{ $task->title }}</p>
                        <p class="text-xs">done {{ $task->completed_at->format('M jS, g:i A') }}</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('tasks.destroy', $task) }}">
                    @csrf
                    @method('DELETE')
                    <button class="text-sm underline">delete</button>
                </form>
            </div>
        @empty
            <p class="text-sm">Nothing completed yet.</p>
        @endforelse
    </div>
</details>

    </div>
</x-perl-layout>