<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>POC Camille</title>
    
    
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
    @endif
    </head>
    
    <body class="bg-gray-50">
        <h1 class="text-3xl font-bold text-center mt-10">POC CAMILLE</h1>
        
        <div class="max-w-4xl mx-auto mt-12">
            <h2 class="text-2xl font-semibold mb-6 text-center">Portfolio de nos projets Laravel</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-bold mb-2">Site web Garage Renault-Dacia</h3>
                    <p class="text-gray-700 mb-2">Site vitrine pour un garage Renault-Dacia : gestion des vehicules en vente, gestion de l'équipe et des horaires d'ouverture...</p>
                    <a href="https://renaultgarageducentre.fr/" class="text-blue-600 underline">Voir le projet</a>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-bold mb-2">Carnet d'adresses</h3>
                    <p class="text-gray-700 mb-2">Application Laravel permettant de gérer un carnet d'adresses : ajout, modification et suppression de contacts, organisation par catégories personnalisées.</p>
                    <a href="#" class="text-blue-600 underline">Voir le projet</a>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-bold mb-2">Site E-commerce Astrolab</h3>
                    <p class="text-gray-700 mb-2">Boutique en ligne avec gestion des produits, panier, commandes et paiement Stripe.</p>
                    <a href="#" class="text-blue-600 underline">Voir le projet</a>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-bold mb-2">Générateur de script JsonLD</h3>
                    <p class="text-gray-700 mb-2">Application permettant de générer dynamiquement un script jsonld pour le référencement d'un site web.</p>
                    <a href="#" class="text-blue-600 underline">Voir le projet</a>
                </div>
            </div>
            
            <div class="mt-12 text-center">
                <p class="text-gray-600">
                    Retrouvez plus d'infos sur notre site :
                    <a href="https://ec-craft.fr" class="text-blue-600 hover:underline">ec-craft.fr</a>
                </p>
            </div>


            <div class="text-center mt-56">
                <p class="text-gray-600">
                    © 2025 EC-Craft. Tous droits réservés.
                </p>
            </div>
            
            
        </div>
        
    </body>
    </html>
    