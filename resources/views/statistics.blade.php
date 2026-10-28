   <x-perl-layout :header="false">
    <div class="max-w-2xl mx-auto p-6 text-perl-dark">

        <a href="{{ route('tasks.index') }}" class="text-2xl">←</a>

        <h1 class="text-center text-4xl font-bold uppercase mt-2">Statistic</h1>
        <p class="text-center text-sm mb-8">you have been completing {{ $total }} tasks this month</p>

        {{-- Month tabs --}}
        <div class="flex justify-center gap-6 mb-10 text-sm font-bold uppercase">
            @foreach ($months as $m)
                <a href="{{ route('statistics', ['month' => $m->format('Y-m')]) }}"
                   class="{{ $month === $m->format('Y-m') ? 'underline underline-offset-8 decoration-2' : '' }}">
                    {{ $m->format('M. Y') }}
                </a>
            @endforeach
        </div>

        {{-- Bars --}}
        <div class="flex items-end justify-center gap-8 h-72 border-b-2 border-perl-dark">
            @foreach ($buckets as $label => $count)
                <div class="flex flex-col items-center justify-end h-full">
                    <span class="text-sm font-bold mb-1">{{ $count }}</span>
                    <div class="w-14 rounded-full bg-perl-blue"
                         style="height: {{ max(10, $count / $max * 240) }}px"></div>
                </div>
            @endforeach
        </div>

        <div class="flex justify-center gap-8 mt-2 text-xs font-bold">
            @foreach ($buckets as $label => $count)
                <span class="w-14 text-center">{{ $label }}</span>
            @endforeach
        </div>

    </div>
</x-app-layout>