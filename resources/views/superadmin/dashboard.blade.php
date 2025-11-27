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
                
                <!-- Dashboard - Active -->
                <a href="{{ route('superadmin.dashboard') }}" 
                   class="flex items-center px-4 py-3 bg-white rounded-lg shadow-sm group justify-start sidebar-expanded justify-center sidebar-collapsed"
                   title="Dashboard">
                    <svg class="w-5 h-5 text-primary sidebar-expanded-icon mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span class="font-semibold text-primary sidebar-text">Dashboard</span>
                </a>
                
                <!-- Admins -->
                <a href="#" 
                   class="flex items-center px-4 py-3 text-white text-opacity-90 hover:bg-white hover:text-primary rounded-lg transition group justify-start sidebar-expanded justify-center sidebar-collapsed"
                   title="Admins">
                    <svg class="w-5 h-5 sidebar-expanded-icon mr-3 group-hover:text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span class="font-medium sidebar-text">Admins</span>
                </a>

                <!-- Sellers -->
                <a href="#" 
                   class="flex items-center px-4 py-3 text-white text-opacity-90 hover:bg-white hover:text-primary rounded-lg transition group justify-start sidebar-expanded justify-center sidebar-collapsed"
                   title="Sellers">
                    <svg class="w-5 h-5 sidebar-expanded-icon mr-3 group-hover:text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span class="font-medium sidebar-text">Sellers</span>
                </a>

                <!-- Plans -->
                <a href="#" 
                   class="flex items-center px-4 py-3 text-white text-opacity-90 hover:bg-white hover:text-primary rounded-lg transition group justify-start sidebar-expanded justify-center sidebar-collapsed"
                   title="Plans">
                    <svg class="w-5 h-5 sidebar-expanded-icon mr-3 group-hover:text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="font-medium sidebar-text">Plans</span>
                </a>

                <!-- Notifications -->
                <a href="{{ route('superadmin.settings.notifications') }}" 
                   class="flex items-center px-4 py-3 text-white text-opacity-90 hover:bg-white hover:text-primary rounded-lg transition group justify-start sidebar-expanded justify-center sidebar-collapsed"
                   title="Notifications">
                    <svg class="w-5 h-5 sidebar-expanded-icon mr-3 group-hover:text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    <span class="font-medium sidebar-text">Notifications</span>
                </a>

                <!-- Settings -->
                <a href="#" 
                   class="flex items-center px-4 py-3 text-white text-opacity-90 hover:bg-white hover:text-primary rounded-lg transition group justify-start sidebar-expanded justify-center sidebar-collapsed"
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
                        <div class="flex-1 min-w-0 sidebar-text">
                            <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-white text-opacity-70 truncate">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="sidebar-text">
                        @csrf
                        <button type="submit" class="text-white text-opacity-70 hover:text-opacity-100 transition ml-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top Bar -->
        <header class="bg-white shadow-sm z-10">
            <div class="px-8 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Dashboard</h2>
                        <p class="text-sm text-gray-600 mt-1">Welcome back, {{ auth()->user()->name }}!</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <x-language-switcher />
                        <div class="text-sm text-gray-600">
                            {{ now()->format('l, F j, Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Dashboard Content -->
        <main class="flex-1 overflow-y-auto bg-gray-50 p-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Users -->
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-600 mb-1">Total Users</p>
                            <p class="text-3xl font-bold text-gray-900">{{ \App\Models\User::count() }}</p>
                            <p class="text-xs text-green-600 mt-2">All registered users</p>
                        </div>
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Sellers -->
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-600 mb-1">Total Sellers</p>
                            <p class="text-3xl font-bold text-gray-900">{{ \App\Models\Tenant::count() }}</p>
                            <p class="text-xs text-purple-600 mt-2">Active tenants</p>
                        </div>
                        <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Subscription Plans -->
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-600 mb-1">Subscription Plans</p>
                            <p class="text-3xl font-bold text-gray-900">{{ \App\Models\SubscriptionPlan::count() }}</p>
                            <p class="text-xs text-green-600 mt-2">Available plans</p>
                        </div>
                        <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Products -->
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-600 mb-1">Total Products</p>
                            <p class="text-3xl font-bold text-gray-900">{{ \App\Models\Product::count() }}</p>
                            <p class="text-xs text-orange-600 mt-2">Across all stores</p>
                        </div>
                        <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity & System Overview -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Recent Sellers -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Recent Sellers</h3>
                        <a href="#" class="text-sm text-primary hover:text-secondary font-medium">View All →</a>
                    </div>
                    <div class="space-y-4">
                        @forelse(\App\Models\Tenant::latest()->take(5)->get() as $tenant)
                        <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary to-secondary flex items-center justify-center text-white font-semibold">
                                    {{ substr($tenant->company_name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $tenant->company_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $tenant->subdomain }}.kedai.test</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                Active
                            </span>
                        </div>
                        @empty
                        <div class="text-center py-8 text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <p class="text-sm">No sellers yet</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- System Overview -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">System Overview</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">System Status</p>
                                    <p class="text-xs text-gray-600">All systems operational</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Online</span>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-purple-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Storage</p>
                                    <p class="text-xs text-gray-600">Unlimited on StackCP</p>
                                </div>
                            </div>
                            <span class="text-sm font-semibold text-purple-600">∞</span>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Active Subscriptions</p>
                                    <p class="text-xs text-gray-600">Monthly recurring</p>
                                </div>
                            </div>
                            <span class="text-sm font-semibold text-green-600">{{ \App\Models\Tenant::count() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Quick Actions</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="#" class="group flex items-center p-4 border-2 border-gray-200 rounded-xl hover:border-primary hover:shadow-md transition-all">
                        <div class="w-12 h-12 bg-primary bg-opacity-10 rounded-lg flex items-center justify-center mr-4 group-hover:bg-opacity-20 transition">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 group-hover:text-primary transition">Add New Admin</h4>
                            <p class="text-sm text-gray-600">Create admin account</p>
                        </div>
                    </a>

                    <a href="#" class="group flex items-center p-4 border-2 border-gray-200 rounded-xl hover:border-primary hover:shadow-md transition-all">
                        <div class="w-12 h-12 bg-primary bg-opacity-10 rounded-lg flex items-center justify-center mr-4 group-hover:bg-opacity-20 transition">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 group-hover:text-primary transition">System Settings</h4>
                            <p class="text-sm text-gray-600">Configure platform</p>
                        </div>
                    </a>

                    <a href="#" class="group flex items-center p-4 border-2 border-gray-200 rounded-xl hover:border-primary hover:shadow-md transition-all">
                        <div class="w-12 h-12 bg-primary bg-opacity-10 rounded-lg flex items-center justify-center mr-4 group-hover:bg-opacity-20 transition">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 group-hover:text-primary transition">View Analytics</h4>
                            <p class="text-sm text-gray-600">Platform insights</p>
                        </div>
                    </a>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const sidebarTexts = document.querySelectorAll('.sidebar-text');
    const sidebarIcons = document.querySelectorAll('.sidebar-icon');
    const sidebarExpandedIcons = document.querySelectorAll('.sidebar-expanded-icon');
    const collapseBtn = document.getElementById('collapseBtn');
    const arrow = collapseBtn.querySelector('span');
    
    if (sidebar.classList.contains('w-64')) {
        // Collapse
        sidebar.classList.remove('w-64');
        sidebar.classList.add('w-20');
        sidebarTexts.forEach(el => el.style.display = 'none');
        sidebarIcons.forEach(el => el.classList.remove('hidden'));
        // Remove margin from icons when collapsed
        sidebarExpandedIcons.forEach(el => el.classList.remove('mr-3'));
        arrow.textContent = '›'; // Arrow points right when collapsed
    } else {
        // Expand
        sidebar.classList.remove('w-20');
        sidebar.classList.add('w-64');
        sidebarTexts.forEach(el => el.style.display = '');
        sidebarIcons.forEach(el => el.classList.add('hidden'));
        // Add margin back to icons when expanded
        sidebarExpandedIcons.forEach(el => el.classList.add('mr-3'));
        arrow.textContent = '‹'; // Arrow points left when expanded
    }
}
</script>
@endsection
