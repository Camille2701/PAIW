<footer class="bg-gray-100 border-t">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Newsletter -->
            <div class="md:col-span-1">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Inscrivez-vous à notre newsletter</h3>
                <p class="text-sm text-gray-600 mb-4">
                    Obtenez les dernières infos spéciales, lancements de nouveaux produits, événements.
                </p>
                
                @if (session()->has('message'))
                    <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('message') }}
                    </div>
                @endif

                <form wire:submit.prevent="subscribe" class="flex">
                    <input 
                        type="email" 
                        wire:model="email"
                        placeholder="Votre email"
                        class="flex-1 px-3 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-1 focus:ring-black focus:border-black"
                        required
                    >
                    <button 
                        type="submit"
                        class="bg-black text-white px-4 py-2 rounded-r-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-black"
                    >
                        S'inscrire
                    </button>
                </form>
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Boutique -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Boutique</h3>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li><a href="/femmes" class="hover:text-gray-900">Femmes</a></li>
                    <li><a href="/hommes" class="hover:text-gray-900">Hommes</a></li>
                    <li><a href="/linge-de-maison" class="hover:text-gray-900">Linge de maison</a></li>
                    <li><a href="/accessoires" class="hover:text-gray-900">Accessoires</a></li>
                    <li><a href="/equipement" class="hover:text-gray-900">Équipement</a></li>
                    <li><a href="/par-activite" class="hover:text-gray-900">Par activité</a></li>
                </ul>
            </div>

            <!-- Aide -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Aide</h3>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li><a href="/centre-d-aide" class="hover:text-gray-900">Centre d'aide</a></li>
                    <li><a href="/statut-commande" class="hover:text-gray-900">Statut de la commande</a></li>
                    <li><a href="/tableau-tailles" class="hover:text-gray-900">Tableau des tailles</a></li>
                    <li><a href="/retours-garantie" class="hover:text-gray-900">Retours et garantie</a></li>
                    <li><a href="/contactez-nous" class="hover:text-gray-900">Contactez-nous</a></li>
                </ul>
            </div>

            <!-- À Propos -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">À Propos</h3>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li><a href="/a-propos" class="hover:text-gray-900">À propos</a></li>
                    <li><a href="/responsabilite" class="hover:text-gray-900">Responsabilité</a></li>
                    <li><a href="/technologie-innovation" class="hover:text-gray-900">Technologie et innovation</a></li>
                    <li><a href="/explorez-nos-histoires" class="hover:text-gray-900">Explorez nos histoires</a></li>
                </ul>
            </div>
        </div>

        <!-- Liens supplémentaires -->
        <div class="mt-8 pt-8 border-t border-gray-200">
            <div class="flex flex-wrap justify-center space-x-6 text-sm text-gray-600">
                <a href="/cartes-cadeaux" class="hover:text-gray-900">Cartes-cadeaux</a>
                <a href="/vente" class="hover:text-gray-900">Vente</a>
            </div>
        </div>

        <!-- Copyright et mentions légales -->
        <div class="mt-8 pt-8 border-t border-gray-200">
            <p class="text-center text-sm text-gray-500">
                © 2025 PAIW. Tous droits réservés.
            </p>
        </div>
    </div>
</footer>
