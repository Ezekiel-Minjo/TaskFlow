<template>
  <AuthenticatedLayout>
    <Head title="Manage Tasks" />

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <div class="flex justify-between items-center mb-6">
              <h1 class="text-3xl font-bold text-gray-800">Manage Tasks</h1>
              <button @click="showCreateForm = true" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-colors">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Create New Task
              </button>
            </div>

            <!-- Success/Error Messages -->
            <div v-if="$page.props.flash.success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
              {{ $page.props.flash.success }}
            </div>

            <!-- Tasks Table -->
            <div class="overflow-x-auto">
              <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-50">
                  <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Task</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned To</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deadline</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="task in tasks" :key="task.id" class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div>
                        <div class="text-sm font-medium text-gray-900">{{ task.title }}</div>
                        <div class="text-sm text-gray-500" v-if="task.description">{{ task.description.substring(0, 50) }}...</div>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center">
                        <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center mr-2">
                          <span class="text-xs text-gray-600 font-semibold">{{ task.user.name.charAt(0).toUpperCase() }}</span>
                        </div>
                        <span class="text-sm text-gray-900">{{ task.user.name }}</span>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span :class="getStatusClass(task.status)" 
                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                        {{ task.status }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                      <div :class="isOverdue(task.deadline) ? 'text-red-600 font-semibold' : ''">
                        {{ formatDate(task.deadline) }}
                        <div v-if="isOverdue(task.deadline)" class="text-xs text-red-500">Overdue</div>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                      <button @click="editTask(task)" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                      <button @click="deleteTask(task)" class="text-red-600 hover:text-red-900">Delete</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Create/Edit Task Modal -->
            <div v-if="showCreateForm || editingTask" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
              <div class="relative top-10 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                  <h3 class="text-lg font-medium text-gray-900 mb-4">
                    {{ editingTask ? 'Edit Task' : 'Create New Task' }}
                  </h3>
                  <form @submit.prevent="submitForm">
                    <div class="mb-4">
                      <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                      <input v-model="form.title" type="text" required 
                             class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div class="mb-4">
                      <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                      <textarea v-model="form.description" rows="3" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
                    </div>
                    <div class="mb-4">
                      <label class="block text-sm font-medium text-gray-700 mb-2">Assign To</label>
                      <select v-model="form.user_id" required 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">Select a user</option>
                        <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
                      </select>
                    </div>
                    <div class="mb-4" v-if="editingTask">
                      <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                      <select v-model="form.status" required 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="Pending">Pending</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Completed">Completed</option>
                      </select>
                    </div>
                    <div class="mb-4">
                      <label class="block text-sm font-medium text-gray-700 mb-2">Deadline</label>
                      <input v-model="form.deadline" type="date" required 
                             class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div class="flex justify-end space-x-3">
                      <button type="button" @click="cancelForm" 
                              class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                        Cancel
                      </button>
                      <button type="submit" 
                              class="px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-md">
                        {{ editingTask ? 'Update' : 'Create & Assign' }}
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
  tasks: Array,
  users: Array
});

const showCreateForm = ref(false);
const editingTask = ref(null);

const form = reactive({
  title: '',
  description: '',
  user_id: '',
  status: 'Pending',
  deadline: ''
});

const resetForm = () => {
  form.title = '';
  form.description = '';
  form.user_id = '';
  form.status = 'Pending';
  form.deadline = '';
};

const editTask = (task) => {
  editingTask.value = task;
  form.title = task.title;
  form.description = task.description || '';
  form.user_id = task.user_id;
  form.status = task.status;
  form.deadline = task.deadline;
};

const cancelForm = () => {
  showCreateForm.value = false;
  editingTask.value = null;
  resetForm();
};

const submitForm = () => {
  if (editingTask.value) {
    router.put(route('admin.tasks.update', editingTask.value.id), form, {
      onSuccess: () => cancelForm()
    });
  } else {
    router.post(route('admin.tasks.store'), form, {
      onSuccess: () => cancelForm()
    });
  }
};

const deleteTask = (task) => {
  if (confirm(`Are you sure you want to delete the task "${task.title}"?`)) {
    router.delete(route('admin.tasks.destroy', task.id));
  }
};

const getStatusClass = (status) => {
  switch (status) {
    case 'Completed':
      return 'bg-green-100 text-green-800';
    case 'In Progress':
      return 'bg-yellow-100 text-yellow-800';
    case 'Pending':
      return 'bg-gray-100 text-gray-800';
    default:
      return 'bg-gray-100 text-gray-800';
  }
};

const formatDate = (date) => {
  return new Date(date).toLocaleDateString();
};

const isOverdue = (deadline) => {
  return new Date(deadline) < new Date() && new Date(deadline).toDateString() !== new Date().toDateString();
};
</script>