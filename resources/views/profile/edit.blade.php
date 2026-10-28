<x-perl-layout :header="false">
    <div class="max-w-2xl mx-auto p-6">

        <a href="{{ route('tasks.index') }}" class="text-2xl">←</a>

        {{-- Profile card --}}
        <div class="bg-perl-blue text-white rounded-3xl p-6 mt-4">
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data"
                  class="space-y-4">
                @csrf
                @method('PATCH')

                <div class="flex items-center gap-4">
                    @if ($user->avatar)
                        <img src="{{ $user->avatar }}" class="w-20 h-20 rounded-full object-cover">
                    @else
                        <div class="w-20 h-20 rounded-full bg-perl-light"></div>
                    @endif

                    <div>
                        <label for="avatar" class="text-sm font-bold uppercase">Profile photo</label>
                        <input id="avatar" name="avatar" type="file" accept="image/*"
                               class="block text-sm mt-1">
                    </div>
                </div>

                <div>
                    <label for="name" class="text-sm font-bold uppercase">Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required
                           class="w-full rounded-xl border-0 text-perl-dark mt-1">
                </div>

                <div>
                    <label for="email" class="text-sm font-bold uppercase">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                           class="w-full rounded-xl border-0 text-perl-dark mt-1">
                </div>

                @if ($errors->any())
                    <ul class="text-sm list-disc list-inside bg-white text-red-700 rounded-xl p-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                @if (session('status') === 'profile-updated')
                    <p class="text-sm">Saved.</p>
                @endif

                <button class="bg-white text-perl-dark rounded-full px-6 py-2 font-semibold">Save</button>
            </form>
        </div>

        {{-- Password and delete account (Breeze's own forms, kept as they are) --}}
        <div class="bg-white rounded-3xl p-6 mt-6">
            @include('profile.partials.update-password-form')
        </div>

        <div class="bg-white rounded-3xl p-6 mt-6">
            @include('profile.partials.delete-user-form')
        </div>

    </div>
</x-perl-layout>