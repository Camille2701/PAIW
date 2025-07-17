@extends('layouts.web')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-100 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">À propos de nous</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Camille, Alexis et Clément ont créé ce site dans le cadre d’un projet d’école.</p>
        </div>
    </div>

    <!-- Section 1: Image à gauche, texte à droite -->
    <div class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="order-2 lg:order-1">
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80"
                             alt="Notre histoire"
                             class="w-full h-96 object-cover">
                    </div>
                </div>
                <div class="order-1 lg:order-2">
                    <div class="bg-white rounded-2xl shadow-lg p-8">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6">Notre Histoire</h2>
                        <p class="text-gray-600 leading-relaxed mb-4">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                        </p>
                        <p class="text-gray-600 leading-relaxed mb-4">
                            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.
                        </p>
                        <p class="text-gray-600 leading-relaxed">
                            Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 2: Texte à gauche, image à droite -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl shadow-lg p-8">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6">Nos Valeurs</h2>
                        <p class="text-gray-600 leading-relaxed mb-4">
                            At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga.
                        </p>
                        <p class="text-gray-600 leading-relaxed mb-4">
                            Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus.
                        </p>
                        <p class="text-gray-600 leading-relaxed">
                            Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus.
                        </p>
                    </div>
                </div>
                <div>
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2071&q=80"
                             alt="Nos valeurs"
                             class="w-full h-96 object-cover">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 3: Image à gauche, texte à droite -->
    <div class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="order-2 lg:order-1">
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1553028826-f4804a6dba3b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80"
                             alt="Notre mission"
                             class="w-full h-96 object-cover">
                    </div>
                </div>
                <div class="order-1 lg:order-2">
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl shadow-lg p-8">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6">Notre Mission</h2>
                        <p class="text-gray-600 leading-relaxed mb-4">
                            Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.
                        </p>
                        <p class="text-gray-600 leading-relaxed mb-4">
                            Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit.
                        </p>
                        <p class="text-gray-600 leading-relaxed">
                            Sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
