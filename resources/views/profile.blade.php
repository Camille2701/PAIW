@extends('layouts.auth')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Mon Profil</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Informations personnelles</h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nom complet</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                    </div>

                    @if($user->first_name || $user->last_name)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Prénom et Nom</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->first_name }} {{ $user->last_name }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Adresse</h2>

                <div class="space-y-4">
                    @if($user->street)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Rue</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->street }}</p>
                    </div>
                    @endif

                    @if($user->postal_code)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Code postal</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->postal_code }}</p>
                    </div>
                    @endif

                    @if($user->department)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Département</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->department }}</p>
                    </div>
                    @endif

                    @if($user->country)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Pays</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->country }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-200">
            <div class="flex justify-between items-center">
                <p class="text-sm text-gray-500">
                    Membre depuis le {{ $user->created_at->format('d/m/Y') }}
                </p>

                <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
                    Modifier mon profil
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
