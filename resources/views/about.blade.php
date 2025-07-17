@extends('layouts.web')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-100 py-12 sm:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-900 mb-4">À propos de nous</h1>
            <p class="text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto px-4">Camille, Alexis et Clément ont créé ce site dans le cadre d'un projet d'école.</p>
        </div>
    </div>

    <!-- Section Équipe -->
    <div class="py-12 sm:py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 sm:mb-16">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-4">Notre Équipe</h2>
                <p class="text-lg sm:text-xl text-gray-600 max-w-2xl mx-auto px-4">Découvrez les personnes passionnées qui ont donné vie à ce projet.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                <!-- Alexis -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <div class="aspect-square overflow-hidden bg-gray-100">
                        @if(\App\Models\AboutPage::getAlexisImageUrl())
                            <img src="{{ \App\Models\AboutPage::getAlexisImageUrl() }}"
                                 alt="Alexis"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                                <div class="text-center">
                                    <div class="w-24 h-24 bg-gray-400 rounded-full mx-auto mb-4 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 text-sm">Photo à venir</p>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="p-4 sm:p-6">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">Alexis</h3>
                        <p class="text-blue-600 font-medium mb-3 text-sm sm:text-base">Développeur Full-Stack</p>
                        <p class="text-gray-600 text-xs sm:text-sm leading-relaxed">
                            Passionné par le développement web et les nouvelles technologies, Alexis apporte son expertise technique au projet.
                        </p>
                    </div>
                </div>

                <!-- Camille -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <div class="aspect-square overflow-hidden bg-gray-100">
                        @if(\App\Models\AboutPage::getCamilleImageUrl())
                            <img src="{{ \App\Models\AboutPage::getCamilleImageUrl() }}"
                                 alt="Camille"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                                <div class="text-center">
                                    <div class="w-24 h-24 bg-gray-400 rounded-full mx-auto mb-4 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 text-sm">Photo à venir</p>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="p-4 sm:p-6">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">Camille</h3>
                        <p class="text-blue-600 font-medium mb-3 text-sm sm:text-base">Designer & Développeur</p>
                        <p class="text-gray-600 text-xs sm:text-sm leading-relaxed">
                            Spécialisé dans l'expérience utilisateur et le design d'interface, Camille donne vie aux idées créatives.
                        </p>
                    </div>
                </div>

                <!-- Clément -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <div class="aspect-square overflow-hidden bg-gray-100">
                        @if(\App\Models\AboutPage::getClementImageUrl())
                            <img src="{{ \App\Models\AboutPage::getClementImageUrl() }}"
                                 alt="Clément"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                                <div class="text-center">
                                    <div class="w-24 h-24 bg-gray-400 rounded-full mx-auto mb-4 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 text-sm">Photo à venir</p>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="p-4 sm:p-6">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">Clément</h3>
                        <p class="text-blue-600 font-medium mb-3 text-sm sm:text-base">Développeur Backend</p>
                        <p class="text-gray-600 text-xs sm:text-sm leading-relaxed">
                            Expert en architecture backend et gestion de données, Clément assure la robustesse technique du projet.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Mission -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Notre Mission</h2>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Ce projet e-commerce a été développé dans le cadre de nos études pour mettre en pratique nos compétences en développement web moderne. Nous utilisons Laravel, Livewire et Filament pour créer une expérience utilisateur exceptionnelle.
                    </p>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Notre objectif est de démontrer notre maîtrise des technologies web actuelles tout en créant une plateforme fonctionnelle et élégante pour la vente en ligne.
                    </p>
                    <p class="text-gray-600 leading-relaxed">
                        Chaque membre de l'équipe apporte ses compétences uniques pour réaliser un projet complet, de la conception à la mise en production.
                    </p>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Technologies Utilisées</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center p-4 bg-blue-50 rounded-lg">
                            <div class="font-semibold text-blue-900">Laravel</div>
                            <div class="text-sm text-blue-700">Framework PHP</div>
                        </div>
                        <div class="text-center p-4 bg-green-50 rounded-lg">
                            <div class="font-semibold text-green-900">Livewire</div>
                            <div class="text-sm text-green-700">Composants Dynamiques</div>
                        </div>
                        <div class="text-center p-4 bg-purple-50 rounded-lg">
                            <div class="font-semibold text-purple-900">Filament</div>
                            <div class="text-sm text-purple-700">Interface Admin</div>
                        </div>
                        <div class="text-center p-4 bg-yellow-50 rounded-lg">
                            <div class="font-semibold text-yellow-900">Tailwind CSS</div>
                            <div class="text-sm text-yellow-700">Design System</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
