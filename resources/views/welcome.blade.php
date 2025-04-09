<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdlabFactory Freelance | Plateforme de Gestion Freelance Professionnelle</title>
    <meta name="description"
        content="Solution tout-en-un pour gérer vos projets, clients, factures et rendez-vous en tant que freelance professionnel">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                        dark: '#18181B'
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'fade-in': 'fadeIn 1s ease-in-out',
                        'slide-up': 'slideUp 0.8s ease-out'
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(30px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        .gradient-text {
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .btn-hover-effect:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px -5px rgba(59, 130, 246, 0.4);
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50 text-gray-800">
    <!-- Navigation -->
    <nav class="glass-effect fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <i class="fas fa-briefcase text-primary-600 text-2xl mr-2"></i>
                        <span class="text-xl font-bold text-gray-800">Adlab<span
                                class="gradient-text">Factory</span></span>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-center space-x-8">
                        <a href="#features"
                            class="text-gray-600 hover:text-primary-600 transition-colors duration-200 font-medium">Fonctionnalités</a>
                        <a href="#testimonials"
                            class="text-gray-600 hover:text-primary-600 transition-colors duration-200 font-medium">Témoignages</a>
                        <a href="#pricing"
                            class="text-gray-600 hover:text-primary-600 transition-colors duration-200 font-medium">Tarifs</a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}"
                        class="text-gray-600 hover:text-primary-600 font-medium hidden md:block">Connexion</a>
                    <a href="{{ route('register') }}"
                        class="bg-primary-600 hover:bg-primary-700 text-white px-5 py-2 rounded-lg font-medium transition-all duration-300 btn-hover-effect">
                        Essai Gratuit
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-28 pb-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div class="animate-fade-in">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6">
                    Gérez votre activité <span class="gradient-text">freelance</span> avec efficacité
                </h1>
                <p class="text-lg md:text-xl text-gray-600 mb-8 max-w-lg">
                    La plateforme tout-en-un pour gérer vos projets, clients, factures et rendez-vous en un seul
                    endroit. Gagnez du temps et concentrez-vous sur ce qui compte vraiment.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('register') }}"
                        class="bg-primary-600 hover:bg-primary-700 text-white px-8 py-3 rounded-lg font-semibold text-center transition-all duration-300 btn-hover-effect">
                        Commencer gratuitement
                    </a>
                    <a href="#features"
                        class="border border-gray-300 hover:border-primary-500 text-gray-700 hover:text-primary-600 px-8 py-3 rounded-lg font-semibold text-center transition-all duration-300 flex items-center justify-center gap-2">
                        <i class="fas fa-play-circle"></i> Voir la démo
                    </a>
                </div>
                <div class="mt-8 flex items-center">
                    <div class="flex -space-x-2">
                        <img class="w-10 h-10 rounded-full border-2 border-white"
                            src="https://randomuser.me/api/portraits/women/12.jpg" alt="User">
                        <img class="w-10 h-10 rounded-full border-2 border-white"
                            src="https://randomuser.me/api/portraits/men/32.jpg" alt="User">
                        <img class="w-10 h-10 rounded-full border-2 border-white"
                            src="https://randomuser.me/api/portraits/women/45.jpg" alt="User">
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Rejoint par <span
                                class="text-primary-600">500+</span> freelances</p>
                        <div class="flex items-center">
                            <div class="flex">
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                            </div>
                            <span class="ml-2 text-sm font-medium text-gray-600">5.0 (200 avis)</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative animate-float">
                <div class="relative z-10">
                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80"
                        alt="Dashboard Preview" class="rounded-xl shadow-2xl border-8 border-white">
                </div>
                <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-primary-100 rounded-full blur-xl opacity-70"></div>
                <div class="absolute -top-8 -right-8 w-32 h-32 bg-purple-100 rounded-full blur-xl opacity-70"></div>
            </div>
        </div>
    </section>

    <!-- Clients Logo -->
    <section class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-gray-500 mb-8">Ils nous font confiance</p>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-8 items-center justify-center">
                <img src="https://logo.clearbit.com/slack.com" alt="Slack"
                    class="h-8 opacity-60 hover:opacity-100 transition-opacity mx-auto">
                <img src="https://logo.clearbit.com/airbnb.com" alt="Airbnb"
                    class="h-8 opacity-60 hover:opacity-100 transition-opacity mx-auto">
                <img src="https://logo.clearbit.com/spotify.com" alt="Spotify"
                    class="h-8 opacity-60 hover:opacity-100 transition-opacity mx-auto">
                <img src="https://logo.clearbit.com/netflix.com" alt="Netflix"
                    class="h-8 opacity-60 hover:opacity-100 transition-opacity mx-auto">
                <img src="https://logo.clearbit.com/google.com" alt="Google"
                    class="h-8 opacity-60 hover:opacity-100 transition-opacity mx-auto">
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <span
                class="inline-block px-3 py-1 text-sm font-medium rounded-full bg-primary-100 text-primary-800 mb-4">Fonctionnalités</span>
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Tout ce dont vous avez besoin pour réussir</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Une plateforme complète conçue spécifiquement pour les
                freelances professionnels</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div
                class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 feature-card animate-slide-up">
                <div
                    class="w-14 h-14 bg-primary-50 rounded-lg flex items-center justify-center mb-6 feature-icon transition-transform duration-300">
                    <i class="fas fa-users text-primary-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-3">Gestion des Clients</h3>
                <p class="text-gray-600 mb-4">Centralisez toutes les informations de vos clients, suivez les
                    interactions et créez des relations durables.</p>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-2"></i> CRM intégré
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-2"></i> Historique des échanges
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-2"></i> Segmentation avancée
                    </li>
                </ul>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 feature-card animate-slide-up"
                style="animation-delay: 0.2s">
                <div
                    class="w-14 h-14 bg-primary-50 rounded-lg flex items-center justify-center mb-6 feature-icon transition-transform duration-300">
                    <i class="fas fa-file-invoice-dollar text-primary-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-3">Facturation Pro</h3>
                <p class="text-gray-600 mb-4">Créez des devis et factures professionnels en quelques clics, avec suivi
                    des paiements et rappels automatiques.</p>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-2"></i> Modèles personnalisables
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-2"></i> Paiements en ligne
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-2"></i> Rappels automatiques
                    </li>
                </ul>
            </div>

            <!-- Feature 3 -->
            <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 feature-card animate-slide-up"
                style="animation-delay: 0.4s">
                <div
                    class="w-14 h-14 bg-primary-50 rounded-lg flex items-center justify-center mb-6 feature-icon transition-transform duration-300">
                    <i class="fas fa-calendar-check text-primary-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-3">Agenda Intelligent</h3>
                <p class="text-gray-600 mb-4">Planifiez vos rendez-vous et réunions avec un système de réservation
                    automatique et des rappels.</p>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-2"></i> Synchronisation calendrier
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-2"></i> Page de réservation
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-2"></i> Rappels automatiques
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-primary-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div class="animate-fade-in">
                    <div class="text-4xl font-bold mb-2">5,000+</div>
                    <div class="text-primary-100">Freelances actifs</div>
                </div>
                <div class="animate-fade-in" style="animation-delay: 0.2s">
                    <div class="text-4xl font-bold mb-2">1.2M€</div>
                    <div class="text-primary-100">Facturés chaque mois</div>
                </div>
                <div class="animate-fade-in" style="animation-delay: 0.4s">
                    <div class="text-4xl font-bold mb-2">98%</div>
                    <div class="text-primary-100">Satisfaction clients</div>
                </div>
                <div class="animate-fade-in" style="animation-delay: 0.6s">
                    <div class="text-4xl font-bold mb-2">24/7</div>
                    <div class="text-primary-100">Support disponible</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <span
                class="inline-block px-3 py-1 text-sm font-medium rounded-full bg-primary-100 text-primary-800 mb-4">Témoignages</span>
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Ce que disent nos utilisateurs</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Découvrez comment AdlabFactory a transformé leur activité
                freelance</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Testimonial 1 -->
            <div class="bg-white p-8 rounded-xl shadow-lg animate-slide-up">
                <div class="flex items-center mb-6">
                    <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Sarah Martin"
                        class="w-12 h-12 rounded-full mr-4">
                    <div>
                        <h4 class="font-bold">Sarah Martin</h4>
                        <p class="text-gray-600">Comerciante </p>
                    </div>
                </div>
                <p class="text-gray-700 mb-6 italic">"AdlabFactory a révolutionné ma façon de travailler. Je gagne au
                    moins 10 heures par semaine sur l'administratif et je peux enfin me concentrer sur ma création. La
                    gestion des factures est un vrai bonheur !"</p>
                <div class="flex">
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                </div>
            </div>

            <!-- Testimonial 2 -->
            <div class="bg-white p-8 rounded-xl shadow-lg animate-slide-up" style="animation-delay: 0.2s">
                <div class="flex items-center mb-6">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Thomas Leroy"
                        class="w-12 h-12 rounded-full mr-4">
                    <div>
                        <h4 class="font-bold">Thomas Leroy</h4>
                        <p class="text-gray-600">
                            Comerciale
                        </p>
                    </div>
                </div>
                <p class="text-gray-700 mb-6 italic">"En tant que développeur freelance, je détestais la partie
                    administrative. Avec AdlabFactory, tout est automatisé et tellement simple. Je recommande à tous mes
                    collègues freelances !"</p>
                <div class="flex">
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-primary-500 to-primary-700 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">Prêt à transformer votre activité freelance ?</h2>
            <p class="text-xl text-primary-100 mb-8">Essayez AdlabFactory gratuitement .</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}"
                    class="bg-white text-primary-600 hover:bg-gray-100 px-8 py-3 rounded-lg font-semibold text-center transition-all duration-300 btn-hover-effect">
                    Commencer gratuitement
                </a>
                <a href="https://adlabfactory.ma/a-propos-de-nous/"
                    class="border border-white text-white hover:bg-white hover:text-primary-600 px-8 py-3 rounded-lg font-semibold text-center transition-all duration-300 flex items-center justify-center gap-2">
                    <i class="fas fa-envelope"></i> Contactez-nous
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-12">
                <div>
                    <h3 class="text-white text-lg font-semibold mb-4">AdlabFactory</h3>
                    <p class="mb-4">La plateforme tout-en-un pour les freelances professionnels.</p>
                    <div class="flex space-x-4">
                        <a href="https://adlabfactory.ma/a-propos-de-nous/"
                            class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://adlabfactory.ma/a-propos-de-nous/"
                            class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="https://adlabfactory.ma/a-propos-de-nous/"
                            class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </div>
                </div>
                <div>
                    <h3 class="text-white text-lg font-semibold mb-4">Produit</h3>
                    <ul class="space-y-2">
                        <li><a href="https://adlabfactory.ma/a-propos-de-nous/"
                                class="hover:text-white transition-colors">Fonctionnalités</a></li>
                        <li><a href="https://adlabfactory.ma/a-propos-de-nous/"
                                class="hover:text-white transition-colors">Tarifs</a></li>
                        <li><a href="https://adlabfactory.ma/a-propos-de-nous/"
                                class="hover:text-white transition-colors">FAQ</a></li>
                        <li><a href="https://adlabfactory.ma/a-propos-de-nous/"
                                class="hover:text-white transition-colors">Nouveautés</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white text-lg font-semibold mb-4">Entreprise</h3>
                    <ul class="space-y-2">
                        <li><a href="https://adlabfactory.ma/a-propos-de-nous/"
                                class="hover:text-white transition-colors">À propos</a></li>
                        <li><a href="https://adlabfactory.ma/a-propos-de-nous/"
                                class="hover:text-white transition-colors">Carrières</a></li>
                        <li><a href="https://adlabfactory.ma/a-propos-de-nous/"
                                class="hover:text-white transition-colors">Blog</a></li>
                        <li><a href="https://adlabfactory.ma/a-propos-de-nous/"
                                class="hover:text-white transition-colors">Presse</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white text-lg font-semibold mb-4">Support</h3>
                    <ul class="space-y-2">
                        <li><a href="https://adlabfactory.ma/a-propos-de-nous/"
                                class="hover:text-white transition-colors">Centre d'aide</a></li>
                        <li><a href="https://adlabfactory.ma/a-propos-de-nous/"
                                class="hover:text-white transition-colors">Contact</a></li>
                        <li><a href="https://adlabfactory.ma/a-propos-de-nous/"
                                class="hover:text-white transition-colors">Confidentialité</a></li>
                        <li><a href="https://adlabfactory.ma/a-propos-de-nous/"
                                class="hover:text-white transition-colors">CGU</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p>© 2025 AdlabFactory. Tous droits réservés.</p>
                <div class="mt-4 md:mt-0 flex space-x-6">
                    <a href="https://adlabfactory.ma/a-propos-de-nous/"
                        class="hover:text-white transition-colors">Confidentialité</a>
                    <a href="https://adlabfactory.ma/a-propos-de-nous/"
                        class="hover:text-white transition-colors">Conditions</a>
                    <a href="https://adlabfactory.ma/a-propos-de-nous/"
                        class="hover:text-white transition-colors">Cookies</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="https://adlabfactory.ma/a-propos-de-nous/"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();

                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Animation on scroll
        const animateOnScroll = () => {
            const elements = document.querySelectorAll('.animate-slide-up, .animate-fade-in');

            elements.forEach(element => {
                const elementPosition = element.getBoundingClientRect().top;
                const windowHeight = window.innerHeight;

                if (elementPosition < windowHeight - 100) {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }
            });
        };

        window.addEventListener('scroll', animateOnScroll);
        window.addEventListener('load', animateOnScroll);
    </script>
</body>

</html>