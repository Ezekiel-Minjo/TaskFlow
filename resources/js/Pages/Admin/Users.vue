<template>
  <AuthenticatedLayout>
    <Head title="Manage Users" />

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <div class="flex justify-between items-center mb-6">
              <h1 class="text-3xl font-bold text-gray-800">Manage Users</h1>
              <button @click="showCreateForm = true" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add New User
              </button>
            </div>

            <!-- Success/Error Messages -->
            <div v-if="$page.props.flash.success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
              {{ $page.props.flash.success }}
            </div>
            <div v-if="$page.props.flash.error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
              {{ $page.props.flash.error }}
            </div>

            <!-- Users Table -->
            <div class="overflow-x-auto">
              <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-50">
                  <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="user in users" :key="user.id" class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center">
                        <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center mr-3">
                          <span class="text-gray-600 font-semibold">{{ user.name.charAt(0).toUpperCase() }}</span>
                        </div>
                        <span class="text-sm font-medium text-gray-900">{{ user.name }}</span>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ user.email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span :class="user.role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800'" 
                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                        {{ user.role === 'admin' ? 'Administrator' : 'User' }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                      {{ new Date(user.created_at).toLocaleDateString() }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                      <button @click="editUser(user)" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                      <button @click="deleteUser(user)" 
                              :disabled="user.id === $page.props.auth.user.id"
                              :class="user.id === $page.props.auth.user.id ? 'text-gray-400 cursor-not-allowed' : 'text-red-600 hover:text-red-900'">
                        Delete
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Create/Edit User Modal -->
            <div v-if="showCreateForm || editingUser" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
              <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                  <h3 class="text-lg font-medium text-gray-900 mb-4">
                    {{ editingUser ? 'Edit User' : 'Create New User' }}
                  </h3>
                  <form @submit.prevent="submitForm">
                    <div class="mb-4">
                      <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                      <input v-model="form.name" type="text" required 
                             class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="mb-4">
                      <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                      <input v-model="form.email" type="email" required 
                             class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="mb-4">
                      <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                      <select v-model="form.role" required 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="user">User</option>
                        <option value="admin">Administrator</option>
                      </select>
                    </div>
                    <div class="mb-4">
                      <label class="block text-sm font-medium text-gray-700 mb-2">
                        Password {{ editingUser ? '(leave blank to keep current)' : '' }}
                      </label>
                      <input v-model="form.password" type="password" 
                             :required="!editingUser"
                             class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="flex justify-end space-x-3">
                      <button type="button" @click="cancelForm" 
                              class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                        Cancel
                      </button>
                      <button type="submit" 
                              class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md">
                        {{ editingUser ? 'Update' : 'Create' }}
                      </button>
                    </div>
                  </form>
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
import { ref, reactive } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';

const props = defineProps({
  users: Array
});

const showCreateForm = ref(false);
const editingUser = ref(null);

const form = reactive({
  name: '',
  email: '',
  role: 'user',
  password: ''
});

const resetForm = () => {
  form.name = '';
  form.email = '';
  form.role = 'user';
  form.password = '';
};

const editUser = (user) => {
  editingUser.value = user;
  form.name = user.name;
  form.email = user.email;
  form.role = user.role;
  form.password = '';
};

const cancelForm = () => {
  showCreateForm.value = false;
  editingUser.value = null;
  resetForm();
};

const submitForm = () => {
  if (editingUser.value) {
    router.put(route('admin.users.update', editingUser.value.id), form, {
      onSuccess: () => cancelForm()
    });
  } else {
    router.post(route('admin.users.store'), form, {
      onSuccess: () => cancelForm()
    });
  }
};

const deleteUser = (user) => {
  if (confirm(`Are you sure you want to delete ${user.name}?`)) {
    router.delete(route('admin.users.destroy', user.id));
  }
};
</script>