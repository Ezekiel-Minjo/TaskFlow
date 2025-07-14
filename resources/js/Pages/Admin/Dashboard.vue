<template>
  <AuthenticatedLayout>
    <Head title="Admin Dashboard" />

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <div class="flex justify-between items-center mb-8">
              <h1 class="text-3xl font-bold text-gray-800">Admin Dashboard</h1>
              <div class="text-sm text-gray-600">
                Welcome, {{ $page.props.auth.user.name }}
              </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
              <Link :href="route('admin.users')" class="bg-blue-500 hover:bg-blue-600 text-white p-6 rounded-lg transition-colors">
                <div class="flex items-center">
                  <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                  </svg>
                  <div>
                    <h3 class="text-lg font-semibold">Manage Users</h3>
                    <p class="text-blue-100">Add, edit, or delete users</p>
                  </div>
                </div>
              </Link>

              <Link :href="route('admin.tasks')" class="bg-green-500 hover:bg-green-600 text-white p-6 rounded-lg transition-colors">
                <div class="flex items-center">
                  <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                  </svg>
                  <div>
                    <h3 class="text-lg font-semibold">Manage Tasks</h3>
                    <p class="text-green-100">Create and assign tasks</p>
                  </div>
                </div>
              </Link>

              <div class="bg-purple-500 text-white p-6 rounded-lg">
                <div class="flex items-center">
                  <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                  </svg>
                  <div>
                    <h3 class="text-lg font-semibold">Analytics</h3>
                    <p class="text-purple-100">View system reports</p>
                  </div>
                </div>
              </div>

              <div class="bg-orange-500 text-white p-6 rounded-lg">
                <div class="flex items-center">
                  <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                  </svg>
                  <div>
                    <h3 class="text-lg font-semibold">Settings</h3>
                    <p class="text-orange-100">System configuration</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Welcome Message -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-100 border border-blue-200 rounded-lg p-6">
              <h2 class="text-xl font-semibold text-gray-800 mb-3">Welcome to TaskFlow Admin Panel</h2>
              <p class="text-gray-600 mb-4">
                Manage your team's productivity with our comprehensive task management system. 
                From here you can oversee users, assign tasks, track progress, and ensure 
                deadlines are met efficiently.
              </p>
              <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                <div class="flex items-center">
                  <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                  Email notifications enabled
                </div>
                <div class="flex items-center">
                  <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                  Real-time updates
                </div>
                <div class="flex items-center">
                  <span class="w-2 h-2 bg-purple-500 rounded-full mr-2"></span>
                  Advanced reporting
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>