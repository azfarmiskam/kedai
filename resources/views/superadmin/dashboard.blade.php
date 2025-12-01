@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-gray-50">
    <!-- Sidebar -->
    <aside id="sidebar" class="w-64 bg-primary shadow-xl transition-all duration-300 ease-in-out">
        <div class="h-full flex flex-col">
            <!-- Logo/Brand - Fixed Height -->
            <div class="px-6 py-6 border-b border-white border-opacity-10 h-24 flex items-center justify-center">
                <div class="sidebar-text text-center">
                    <h1 class="text-2xl font-bold text-white">{{ $theme['system_name'] }}</h1>
                    <p class="text-xs text-white text-opacity-70 mt-1">Super Admin Panel</p>
                </div>
                <div class="sidebar-icon hidden">
                    <div class="w-12 h-12 rounded-full bg-white bg-opacity-20 flex items-center justify-center">
                        <span class="text-white font-bold text-xl">{{ substr($theme['system_name'], 0, 1) }}</span>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto relative">
                <!-- Collapse Button -->
                <button id="collapseBtn" onclick="toggleSidebar()" 
                        class="absolute top-2 right-2 w-8 h-8 rounded-md bg-white text-primary hover:bg-gray-100 transition flex items-center justify-center shadow-sm border border-gray-200 mb-4"
                        title="Collapse sidebar">
                    <span class="text-sm font-bold">‹</span>
                </button>
                
                <!-- Add spacing for the button -->
                <div class="h-6"></div>
                
                <!-- Dashboard -->
                <a href="javascript:void(0)" onclick="showSection('dashboard')" data-section="dashboard"
                   class="sidebar-menu-item flex items-center px-4 py-3 bg-white text-primary rounded-lg shadow-sm group justify-start sidebar-expanded justify-center sidebar-collapsed"
                   title="Dashboard">
                    <svg class="w-5 h-5 sidebar-expanded-icon mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span class="font-semibold sidebar-text">Dashboard</span>
                </a>

                <!-- Admins -->
                <a href="javascript:void(0)" onclick="showSection('admins')" data-section="admins"
                   class="sidebar-menu-item flex items-center px-4 py-3 text-white text-opacity-90 hover:bg-white hover:text-primary rounded-lg transition group justify-start sidebar-expanded justify-center sidebar-collapsed"
                   title="Admins">
                    <svg class="w-5 h-5 sidebar-expanded-icon mr-3 group-hover:text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span class="font-medium sidebar-text">Admins</span>
                </a>

                <!-- Sellers -->
                <a href="javascript:void(0)" onclick="showSection('sellers')" data-section="sellers"
                   class="sidebar-menu-item flex items-center px-4 py-3 text-white text-opacity-90 hover:bg-white hover:text-primary rounded-lg transition group justify-start sidebar-expanded justify-center sidebar-collapsed"
                   title="Sellers">
                    <svg class="w-5 h-5 sidebar-expanded-icon mr-3 group-hover:text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span class="font-medium sidebar-text">Sellers</span>
                </a>

                <!-- Plans -->
                <a href="javascript:void(0)" onclick="showSection('plans')" data-section="plans"
                   class="sidebar-menu-item flex items-center px-4 py-3 text-white text-opacity-90 hover:bg-white hover:text-primary rounded-lg transition group justify-start sidebar-expanded justify-center sidebar-collapsed"
                   title="Plans">
                    <svg class="w-5 h-5 sidebar-expanded-icon mr-3 group-hover:text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="font-medium sidebar-text">Plans</span>
                </a>

                <!-- Notifications -->
                <a href="javascript:void(0)" onclick="showSection('notifications')" data-section="notifications"
                   class="sidebar-menu-item flex items-center px-4 py-3 text-white text-opacity-90 hover:bg-white hover:text-primary rounded-lg transition group justify-start sidebar-expanded justify-center sidebar-collapsed"
                   title="Notifications">
                    <svg class="w-5 h-5 sidebar-expanded-icon mr-3 group-hover:text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    <span class="font-medium sidebar-text">Notifications</span>
                </a>

                <!-- Settings -->
                <a href="javascript:void(0)" onclick="showSection('settings')" data-section="settings"
                   class="sidebar-menu-item flex items-center px-4 py-3 text-white text-opacity-90 hover:bg-white hover:text-primary rounded-lg transition group justify-start sidebar-expanded justify-center sidebar-collapsed"
                   title="Settings">
                    <svg class="w-5 h-5 sidebar-expanded-icon mr-3 group-hover:text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="font-medium sidebar-text">Settings</span>
                </a>
            </nav>

            <!-- User Profile -->
            <div class="px-4 py-4 border-t border-white border-opacity-10">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3 flex-1 min-w-0">
                        <div class="w-10 h-10 rounded-full bg-white bg-opacity-20 flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-semibold text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                        <div class="sidebar-text flex-1 min-w-0">
                            <p class="text-white font-medium text-sm truncate">{{ auth()->user()->name }}</p>
                            <p class="text-white text-opacity-70 text-xs truncate">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="sidebar-text">
                        @csrf
                        <button type="submit" class="text-white hover:text-opacity-70 transition" title="Logout">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 overflow-y-auto">
        <!-- Dashboard Section (Default) -->
        <div id="section-dashboard" class="section-content">
            @include('superadmin.sections.dashboard-stats')
        </div>

        <!-- Admins Section -->
        <div id="section-admins" class="section-content hidden">
            @include('superadmin.sections.admins-management')
        </div>

        <!-- Sellers Section -->
        <div id="section-sellers" class="section-content hidden">
            @include('superadmin.sections.sellers-placeholder')
        </div>

        <!-- Plans Section -->
        <div id="section-plans" class="section-content hidden">
            @include('superadmin.sections.plans-placeholder')
        </div>

        <!-- Notifications Section -->
        <div id="section-notifications" class="section-content hidden">
            @include('superadmin.sections.notifications-settings')
        </div>

        <!-- Settings Section -->
        <div id="section-settings" class="section-content hidden">
            @include('superadmin.sections.settings-placeholder')
        </div>
    </div>
</div>

<script>
// Global state
let currentSection = 'dashboard';
let sidebarCollapsed = false;

// Show specific section
function showSection(sectionId) {
    // Hide all sections
    document.querySelectorAll('.section-content').forEach(section => {
        section.classList.add('hidden');
    });
    
    // Show selected section
    const section = document.getElementById('section-' + sectionId);
    if (section) {
        section.classList.remove('hidden');
        currentSection = sectionId;
        
        // Update URL hash
        window.location.hash = sectionId;
        
        // Save to localStorage
        localStorage.setItem('lastSection', sectionId);
    }
    
    // Update menu highlighting
    updateActiveMenu(sectionId);
}

// Update active menu item
function updateActiveMenu(sectionId) {
    // Remove active class from all menu items
    document.querySelectorAll('.sidebar-menu-item').forEach(item => {
        item.classList.remove('bg-white', 'text-primary', 'shadow-sm');
        item.classList.add('text-white', 'text-opacity-90');
        
        // Update SVG colors
        const svg = item.querySelector('svg');
        if (svg) {
            svg.classList.remove('text-primary');
        }
        const span = item.querySelector('span');
        if (span) {
            span.classList.remove('font-semibold', 'text-primary');
            span.classList.add('font-medium');
        }
    });
    
    // Add active class to selected menu
    const menuItem = document.querySelector(`[data-section="${sectionId}"]`);
    if (menuItem) {
        menuItem.classList.add('bg-white', 'text-primary', 'shadow-sm');
        menuItem.classList.remove('text-white', 'text-opacity-90');
        
        // Update SVG colors
        const svg = menuItem.querySelector('svg');
        if (svg) {
            svg.classList.add('text-primary');
        }
        const span = menuItem.querySelector('span');
        if (span) {
            span.classList.add('font-semibold', 'text-primary');
            span.classList.remove('font-medium');
        }
    }
}

// Toggle sidebar collapse/expand
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const collapseBtn = document.getElementById('collapseBtn');
    const btnText = collapseBtn.querySelector('span');
    
    sidebarCollapsed = !sidebarCollapsed;
    
    if (sidebarCollapsed) {
        sidebar.classList.remove('w-64');
        sidebar.classList.add('w-20');
        btnText.textContent = '›';
        
        // Hide text, show icons
        document.querySelectorAll('.sidebar-text').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.sidebar-icon').forEach(el => el.classList.remove('hidden'));
        document.querySelectorAll('.sidebar-expanded').forEach(el => {
            el.classList.remove('justify-start');
            el.classList.add('justify-center');
        });
        document.querySelectorAll('.sidebar-expanded-icon').forEach(el => {
            el.classList.remove('mr-3');
        });
    } else {
        sidebar.classList.remove('w-20');
        sidebar.classList.add('w-64');
        btnText.textContent = '‹';
        
        // Show text, hide icons
        document.querySelectorAll('.sidebar-text').forEach(el => el.classList.remove('hidden'));
        document.querySelectorAll('.sidebar-icon').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.sidebar-expanded').forEach(el => {
            el.classList.remove('justify-center');
            el.classList.add('justify-start');
        });
        document.querySelectorAll('.sidebar-expanded-icon').forEach(el => {
            el.classList.add('mr-3');
        });
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Check URL hash
    const hash = window.location.hash.substring(1);
    if (hash) {
        showSection(hash);
    } else {
        // Check localStorage
        const lastSection = localStorage.getItem('lastSection');
        if (lastSection) {
            showSection(lastSection);
        } else {
            showSection('dashboard');
        }
    }
});

// Handle browser back/forward
window.addEventListener('hashchange', function() {
    const hash = window.location.hash.substring(1);
    if (hash) {
        showSection(hash);
    }
});
</script>
@endsection
