<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tourism Management Admin')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    <!-- Include Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Include Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        .sidebar-transition {
            transition: width 0.3s ease-in-out;
        }

        .sidebar-collapsed .menu-text {
            display: none;
        }

        .sidebar-collapsed .sidebar-icon {
            margin-right: 0;
        }

        .sidebar-collapsed #adminPanelTitle {
            display: none;
        }

        #toggleSidebar {
            display: block;
            /* Ensure the toggle button is always displayed */
        }

        [x-cloak] { display: none !important; }
    </style>
    @yield('styles')
</head>

<body class="bg-gray-100">
    <div class="flex h-screen" id="app" x-data>
        <!-- Sidebar -->
        <aside id="sidebar"
            class="bg-gradient-to-b from-teal-600 to-teal-700 text-white w-64 flex-shrink-0 overflow-y-auto sidebar-transition">
            <div class="p-4 flex items-center justify-between">
                <h1 id="adminPanelTitle" class="text-lg font-bold">Admin Panel</h1>
                <button id="toggleSidebar" class="text-white focus:outline-none">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
            <nav class="mt-4">
                @can('view dashboard')
                    <a href="#"
                        class="block py-2.5 px-4 rounded transition duration-200 hover:bg-teal-800 flex items-center">
                        <i class="fas fa-home mr-2 sidebar-icon"></i><span class="menu-text">Dashboard</span>
                    </a>
                @endcan

                <div x-data="{ open: false }">
                    <button @click="open = !open" class="w-full block py-2.5 px-4 rounded transition duration-200 hover:bg-teal-800 flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-building mr-2 sidebar-icon"></i>
                            <span class="menu-text">Departments</span>
                        </div>
                        <i class="fas" :class="{ 'fa-chevron-down': !open, 'fa-chevron-up': open }"></i>
                    </button>
                    <div x-show="open" x-transition x-cloak class="pl-4">
                        <a href="{{ route('departments.index') }}"
                            class="block py-2 px-4 rounded transition duration-200 hover:bg-teal-800 flex items-center">
                            <i class="fas fa-list mr-2 sidebar-icon"></i><span class="menu-text">List Departments</span>
                        </a>
                        <a href="{{ route('departments.create') }}"
                            class="block py-2 px-4 rounded transition duration-200 hover:bg-teal-800 flex items-center">
                            <i class="fas fa-plus mr-2 sidebar-icon"></i><span class="menu-text">Create Department</span>
                        </a>
                    </div>
                </div>

                <div x-data="{ open: false }">
                    <button @click="open = !open" class="w-full block py-2.5 px-4 rounded transition duration-200 hover:bg-teal-800 flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-layer-group mr-2 sidebar-icon"></i>
                            <span class="menu-text">Sections</span>
                        </div>
                        <i class="fas" :class="{ 'fa-chevron-down': !open, 'fa-chevron-up': open }"></i>
                    </button>
                    <div x-show="open" x-transition x-cloak class="pl-4">
                        <a href="{{ route('sections.index') }}"
                            class="block py-2 px-4 rounded transition duration-200 hover:bg-teal-800 flex items-center">
                            <i class="fas fa-list mr-2 sidebar-icon"></i><span class="menu-text">List Sections</span>
                        </a>
                        <a href="{{ route('sections.create') }}"
                            class="block py-2 px-4 rounded transition duration-200 hover:bg-teal-800 flex items-center">
                            <i class="fas fa-plus mr-2 sidebar-icon"></i><span class="menu-text">Create Section</span>
                        </a>
                    </div>
                </div>

                <div x-data="{ open: false }">
                    <button @click="open = !open" class="w-full block py-2.5 px-4 rounded transition duration-200 hover:bg-teal-800 flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-2 sidebar-icon"></i>
                            <span class="menu-text">Locations</span>
                        </div>
                        <i class="fas" :class="{ 'fa-chevron-down': !open, 'fa-chevron-up': open }"></i>
                    </button>
                    <div x-show="open" x-transition x-cloak class="pl-4">
                        <a href="{{ route('locations.index') }}"
                            class="block py-2 px-4 rounded transition duration-200 hover:bg-teal-800 flex items-center">
                            <i class="fas fa-list mr-2 sidebar-icon"></i><span class="menu-text">List Locations</span>
                        </a>
                        <a href="{{ route('locations.create') }}"
                            class="block py-2 px-4 rounded transition duration-200 hover:bg-teal-800 flex items-center">
                            <i class="fas fa-plus mr-2 sidebar-icon"></i><span class="menu-text">Create Location</span>
                        </a>
                    </div>
                </div>

                <div x-data="{ open: false }">
                    <button @click="open = !open" class="w-full block py-2.5 px-4 rounded transition duration-200 hover:bg-teal-800 flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-clipboard-list mr-2 sidebar-icon"></i>
                            <span class="menu-text">Fixed Assets</span>
                        </div>
                        <i class="fas" :class="{ 'fa-chevron-down': !open, 'fa-chevron-up': open }"></i>
                    </button>
                    <div x-show="open" x-transition x-cloak class="pl-4">
                        <a href="{{ route('fixed-assets.index') }}"
                            class="block py-2 px-4 rounded transition duration-200 hover:bg-teal-800 flex items-center">
                            <i class="fas fa-list mr-2 sidebar-icon"></i><span class="menu-text">List Fixed Assets</span>
                        </a>
                        <a href="{{ route('fixed-assets.create') }}"
                            class="block py-2 px-4 rounded transition duration-200 hover:bg-teal-800 flex items-center">
                            <i class="fas fa-plus mr-2 sidebar-icon"></i><span class="menu-text">Create Fixed Asset</span>
                        </a>
                    </div>
                </div>

                <div x-data="{ open: false }">
                    <button @click="open = !open" class="w-full block py-2.5 px-4 rounded transition duration-200 hover:bg-teal-800 flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-file-alt mr-2 sidebar-icon"></i>
                            <span class="menu-text">Files</span>
                        </div>
                        <i class="fas" :class="{ 'fa-chevron-down': !open, 'fa-chevron-up': open }"></i>
                    </button>
                    <div x-show="open" x-transition x-cloak class="pl-4">
                        <a href="{{ route('files.create-with-dropdowns') }}"
                            class="block py-2 px-4 rounded transition duration-200 hover:bg-teal-800 flex items-center">
                            <i class="fas fa-file-upload mr-2 sidebar-icon"></i><span class="menu-text">Create File</span>
                        </a>
                        <a href="{{ route('files.index') }}"
                            class="block py-2 px-4 rounded transition duration-200 hover:bg-teal-800 flex items-center">
                            <i class="fas fa-file-alt mr-2 sidebar-icon"></i><span class="menu-text">All Files</span>
                        </a>
                    </div>
                </div>

                <a href="{{ route('roles-permissions.index') }}"
                    class="block py-2.5 px-4 rounded transition duration-200 hover:bg-teal-800 flex items-center">
                    <i class="fas fa-users mr-2 sidebar-icon"></i><span class="menu-text">Manage Roles and Permissions</span>
                </a>

            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <header id="topNav" class="bg-white shadow-md rounded-b-lg flex items-center justify-between p-4">
                <div class="flex items-center">
                    <form id="globalSearchForm" class="flex items-center">
                        <input type="text" id="globalSearchInput" placeholder="Search a file here..."
                            class="border rounded px-2 py-1 focus:outline-none focus:ring focus:border-teal-300">
                        <button type="submit"
                            class="ml-2 bg-teal-500 text-white px-4 py-1 rounded hover:bg-teal-600 focus:outline-none transition duration-200">Search</button>
                    </form>
                </div>
                <div class="flex items-center">
                    <div class="flex items-center mr-4">
                        <span id="currentTime" class="text-gray-600"></span>
                    </div>
                    <div class="relative">
                        <button onclick="toggleNotificationDropdown()"
                            class="text-gray-600 hover:text-gray-800 mr-4 relative">
                            <i class="fas fa-bell"></i>
                            @if (Auth::user()->unreadNotifications->count())
                                <span
                                    class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full px-1">{{ Auth::user()->unreadNotifications->count() }}</span>
                            @endif
                        </button>
                        <div id="notificationDropdown"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md overflow-hidden shadow-xl z-10 hidden">
                            <div class="max-h-60 overflow-y-auto">
                                @if (Auth::user()->notifications->isEmpty())
                                    <p class="px-4 py-2 text-gray-500">No new notifications.</p>
                                @else
                                    @foreach (Auth::user()->notifications as $notification)
                                        <a href="{{ $notification->data['url'] ?? '#' }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            {{ $notification->data['message'] }}
                                            <span
                                                class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="relative">
                        <button onclick="toggleDropdown()" class="flex items-center focus:outline-none">
                            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="User"
                                class="w-8 h-8 rounded-full mr-2"> <!-- Default user avatar from CDN -->
                            <span id="userName">{{auth()->user()->name}}</span> <!-- Replace with authenticated user's name -->
                            <i class="fas fa-chevron-down ml-2"></i>
                        </button>
                        <div id="userDropdown"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md overflow-hidden shadow-xl z-10 hidden">
                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </div>

                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200 p-6">
                <div class="bg-white rounded-lg shadow-md p-4">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        function toggleDropdown() {
            document.getElementById('userDropdown').classList.toggle('hidden');
        }

        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleSidebar');
        const topNav = document.getElementById('topNav');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('w-64');
            sidebar.classList.toggle('w-16');
            sidebar.classList.toggle('sidebar-collapsed');

            // Hide or show the top navigation bar
            if (sidebar.classList.contains('sidebar-collapsed')) {
                topNav.classList.add('hidden'); // Hide top navigation
                toggleBtn.innerHTML = '<i class="fas fa-chevron-right"></i>'; // Change icon to expand
            } else {
                topNav.classList.remove('hidden'); // Show top navigation
                toggleBtn.innerHTML = '<i class="fas fa-chevron-left"></i>'; // Change icon to collapse
            }
        });

        // Function to update the current time
        function updateTime() {
            const now = new Date();
            const options = {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            document.getElementById('currentTime').textContent = now.toLocaleTimeString([], options);
        }

        // Update time every second
        setInterval(updateTime, 1000);
        updateTime(); // Initial call to set the time immediately

        function toggleNotificationDropdown() {
            document.getElementById('notificationDropdown').classList.toggle('hidden');
        }

        // Close the dropdown if the user clicks outside of it
        window.onclick = function(event) {
            if (!event.target.matches('.fas.fa-bell')) {
                var dropdowns = document.getElementsByClassName("notificationDropdown");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('hidden') === false) {
                        openDropdown.classList.add('hidden');
                    }
                }
            }
        }

        document.getElementById('globalSearchForm').addEventListener('submit', function(e) {
            e.preventDefault();
            var searchTerm = document.getElementById('globalSearchInput').value;
            window.location.href = "{{ route('files.index') }}?search=" + encodeURIComponent(searchTerm);
        });
    </script>
    @yield('scripts')
</body>

</html>
