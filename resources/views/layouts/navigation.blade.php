<nav id="sidebar"
    class="w-64 h-screen fixed bg-gray-900 text-gray-100 p-5 flex flex-col transition-all duration-300 ease-in-out border-r border-gray-700">
    <!-- Toggle Button -->
    <button id="toggleSidebar"
        class="text-gray-300 hover:text-white mb-8 focus:outline-none self-end transition-colors duration-200">
        <i class="fas fa-bars text-xl"></i>
    </button>

    <!-- Logo/Brand -->
    <div class="mb-10 flex items-center space-x-3 px-2">
        <span id="brandText" class="text-2xl font-semibold tracking-tight">Adlab Hub</span>
    </div>

    <!-- Navigation Menu -->
    <ul class="space-y-2 flex-1">
        <!-- Public Routes (Accessible to All) -->
        <li>
            <a href="{{ route('home') }}"
                class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-800 hover:text-indigo-300 transition-colors duration-200 group">
                <i class="fas fa-home text-lg w-6 text-center text-gray-400 group-hover:text-indigo-300"></i>
                <span class="ml-3 menu-text font-medium">Home</span>
            </a>
        </li>
        <li>
            <a href="{{ route('plans.index') }}"
                class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-800 hover:text-indigo-300 transition-colors duration-200 group">
                <i class="fas fa-layer-group text-lg w-6 text-center text-gray-400 group-hover:text-indigo-300"></i>
                <span class="ml-3 menu-text font-medium">Plans</span>
            </a>
        </li>

        <!-- Authenticated Routes -->
        @auth
        <li>
            <a href="{{ route('dashboard') }}"
                class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-800 hover:text-indigo-300 transition-colors duration-200 group">
                <i class="fas fa-tachometer-alt text-lg w-6 text-center text-gray-400 group-hover:text-indigo-300"></i>
                <span class="ml-3 menu-text font-medium">Dashboard</span>
            </a>
        </li>

        <!-- Contacts (Accessible to Authenticated Users with Permission) -->
        @can('viewAny', App\Models\Contact::class)
        <li>
            <a href="{{ route('contacts.index') }}"
                class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-800 hover:text-indigo-300 transition-colors duration-200 group">
                <i class="fas fa-address-book text-lg w-6 text-center text-gray-400 group-hover:text-indigo-300"></i>
                <span class="ml-3 menu-text font-medium">Contacts</span>
            </a>
        </li>
        @endcan

        <!-- Rendez-vous (Accessible to Authenticated Users with Permission) -->
        @can('viewAny', App\Models\Rdv::class)
        <li>
            <a href="{{ route('rdvs.index') }}"
                class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-800 hover:text-indigo-300 transition-colors duration-200 group">
                <i class="fas fa-calendar-alt text-lg w-6 text-center text-gray-400 group-hover:text-indigo-300"></i>
                <span class="ml-3 menu-text font-medium">Rendez-vous</span>
            </a>
        </li>
        @endcan

        <!-- Freelancer Routes -->
        @role('Freelancer')
        <li class="pt-4 mt-4 border-t border-gray-800">
            <span class="text-xs uppercase tracking-wider text-gray-500 px-4 mb-2 block menu-text">Freelancer</span>
            <ul class="space-y-2">

                <li>
                    <a href="{{ route('commissions.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-800 hover:text-indigo-300 transition-colors duration-200 group">
                        <i
                            class="fas fa-money-bill-wave text-lg w-6 text-center text-gray-400 group-hover:text-indigo-300"></i>
                        <span class="ml-3 menu-text">Commissions</span>
                    </a>
                </li>

            </ul>
        </li>
        @endrole

        <!-- Account Manager Routes -->
        @role('Account Manager')
        <li class="pt-4 mt-4 border-t border-gray-800">
            <span class="text-xs uppercase tracking-wider text-gray-500 px-4 mb-2 block menu-text">Gestion</span>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('devis.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-800 hover:text-indigo-300 transition-colors duration-200 group">
                        <i
                            class="fas fa-file-alt text-lg w-6 text-center text-gray-400 group-hover:text-indigo-300"></i>
                        <span class="ml-3 menu-text">Devis</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('commissions.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-800 hover:text-indigo-300 transition-colors duration-200 group">
                        <i
                            class="fas fa-money-bill-wave text-lg w-6 text-center text-gray-400 group-hover:text-indigo-300"></i>
                        <span class="ml-3 menu-text">Commissions</span>
                    </a>
                </li>
            </ul>
        </li>
        @endrole

        <!-- Admin & Super Admin Routes -->
        @role('Admin|Super Admin')
        <li class="pt-4 mt-4 border-t border-gray-800">
            <span class="text-xs uppercase tracking-wider text-gray-500 px-4 mb-2 block menu-text">Administration</span>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('users.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-800 hover:text-indigo-300 transition-colors duration-200 group">
                        <i
                            class="fas fa-users-cog text-lg w-6 text-center text-gray-400 group-hover:text-indigo-300"></i>
                        <span class="ml-3 menu-text">Utilisateurs</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('plans.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-800 hover:text-indigo-300 transition-colors duration-200 group">
                        <i
                            class="fas fa-layer-group text-lg w-6 text-center text-gray-400 group-hover:text-indigo-300"></i>
                        <span class="ml-3 menu-text">Plans</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('commissions.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-800 hover:text-indigo-300 transition-colors duration-200 group">
                        <i
                            class="fas fa-money-bill-wave text-lg w-6 text-center text-gray-400 group-hover:text-indigo-300"></i>
                        <span class="ml-3 menu-text">Commissions</span>
                    </a>
                </li>
            </ul>
        </li>
        @endrole

        <!-- Super Admin Exclusive Routes -->
        @role('Super Admin |Admin')
        <li class="pt-4 mt-4 border-t border-gray-800">
            <span class="text-xs uppercase tracking-wider text-gray-500 px-4 mb-2 block menu-text">Super Admin</span>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('admin.data') }}"
                        class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-800 hover:text-indigo-300 transition-colors duration-200 group">
                        <i
                            class="fas fa-database text-lg w-6 text-center text-gray-400 group-hover:text-indigo-300"></i>
                        <span class="ml-3 menu-text">Data</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('abonnements.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-800 hover:text-indigo-300 transition-colors duration-200 group">
                        <i
                            class="fas fa-file-contract text-lg w-6 text-center text-gray-400 group-hover:text-indigo-300"></i>
                        <span class="ml-3 menu-text">Abonnements</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('commissions.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-800 hover:text-indigo-300 transition-colors duration-200 group">
                        <i
                            class="fas fa-money-bill-wave text-lg w-6 text-center text-gray-400 group-hover:text-indigo-300"></i>
                        <span class="ml-3 menu-text">Commissions</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('devis.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-800 hover:text-indigo-300 transition-colors duration-200 group">
                        <i
                            class="fas fa-file-alt text-lg w-6 text-center text-gray-400 group-hover:text-indigo-300"></i>
                        <span class="ml-3 menu-text">Devis</span>
                    </a>
                </li>
            </ul>
        </li>
        @endrole

        <!-- Permissions-Based Routes -->
        @can('manage subscriptions')
        <li>
            <a href="{{ route('abonnements.index') }}"
                class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-800 hover:text-indigo-300 transition-colors duration-200 group">
                <i class="fas fa-file-contract text-lg w-6 text-center text-gray-400 group-hover:text-indigo-300"></i>
                <span class="ml-3 menu-text">Abonnements</span>
            </a>
        </li>
        @endcan
        @endauth
    </ul>

    <!-- Authentication Buttons -->
    <div class="mt-auto pt-4 border-t border-gray-800">
        @auth
        <a href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-800 hover:text-red-400 transition-colors duration-200 group">
            <i class="fas fa-sign-out-alt text-lg w-6 text-center text-gray-400 group-hover:text-red-400"></i>
            <span class="ml-3 menu-text">Déconnexion</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
        @else
        <a href="{{ route('login') }}"
            class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-800 hover:text-blue-400 transition-colors duration-200 group">
            <i class="fas fa-sign-in-alt text-lg w-6 text-center text-gray-400 group-hover:text-blue-400"></i>
            <span class="ml-3 menu-text">Connexion</span>
        </a>
        <a href="{{ route('register') }}"
            class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-800 hover:text-green-400 transition-colors duration-200 group mt-2">
            <i class="fas fa-user-plus text-lg w-6 text-center text-gray-400 group-hover:text-green-400"></i>
            <span class="ml-3 menu-text">Inscription</span>
        </a>
        @endauth
    </div>
</nav>

<!-- Improved JavaScript for Toggle -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const toggleSidebar = document.getElementById('toggleSidebar');
        const menuTextElements = document.querySelectorAll('.menu-text');
        const brandText = document.getElementById('brandText');

        // Check for saved state in localStorage
        const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';

        // Apply initial state
        if (isCollapsed) {
            collapseSidebar();
        }

        toggleSidebar.addEventListener('click', () => {
            if (sidebar.classList.contains('w-16')) {
                expandSidebar();
                localStorage.setItem('sidebarCollapsed', 'false');
            } else {
                collapseSidebar();
                localStorage.setItem('sidebarCollapsed', 'true');
            }
        });

        function collapseSidebar() {
            sidebar.classList.remove('w-64');
            sidebar.classList.add('w-16');
            menuTextElements.forEach(el => el.style.opacity = '0');
            menuTextElements.forEach(el => el.style.position = 'absolute');
            brandText.style.opacity = '0';
            brandText.style.position = 'absolute';
            // Change icon to indicate expand
            toggleSidebar.innerHTML = '<i class="fas fa-chevron-right text-xl"></i>';
        }

        function expandSidebar() {
            sidebar.classList.remove('w-16');
            sidebar.classList.add('w-64');
            menuTextElements.forEach(el => el.style.opacity = '1');
            menuTextElements.forEach(el => el.style.position = 'static');
            brandText.style.opacity = '1';
            brandText.style.position = 'static';
            // Change icon to indicate collapse
            toggleSidebar.innerHTML = '<i class="fas fa-bars text-xl"></i>';
        }
    });
</script>