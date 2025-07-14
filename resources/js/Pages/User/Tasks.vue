<template>
  <AuthenticatedLayout>
    <Head title="My Tasks" />

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <div class="flex justify-between items-center mb-6">
              <h1 class="text-3xl font-bold text-gray-800">My Tasks</h1>
              <div class="text-sm text-gray-600">
                {{ tasks.length }} task{{ tasks.length !== 1 ? 's' : '' }} assigned
              </div>
            </div>

            <!-- Success Messages -->
            <div v-if="$page.props.flash.success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
              {{ $page.props.flash.success }}
            </div>

            <!-- Task Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
              <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex items-center">
                  <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                  </div>
                  <div>
                    <p class="text-2xl font-bold text-yellow-800">{{ getTaskCount('Pending') }}</p>
                    <p class="text-yellow-600">Pending Tasks</p>
                  </div>
                </div>
              </div>

              <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-center">
                  <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                  </div>
                  <div>
                    <p class="text-2xl font-bold text-blue-800">{{ getTaskCount('In Progress') }}</p>
                    <p class="text-blue-600">In Progress</p>
                  </div>
                </div>
              </div>

              <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-center">
                  <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                  </div>
                  <div>
                    <p class="text-2xl font-bold text-green-800">{{ getTaskCount('Completed') }}</p>
                    <p class="text-green-600">Completed</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Tasks List -->
            <div v-if="tasks.length === 0" class="text-center py-12">
              <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
              </svg>
              <h3 class="mt-4 text-lg font-medium text-gray-900">No tasks assigned</h3>
              <p class="mt-2 text-gray-500">You don't have any tasks assigned to you yet.</p>
            </div>

            <div v-else class="space-y-4">
              <div v-for="task in tasks" :key="task.id" 
                   class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                <div class="p-6">
                  <div class="flex justify-between items-start mb-4">
                    <div class="flex-1">
                      <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ task.title }}</h3>
                      <p v-if="task.description" class="text-gray-600 mb-3">{{ task.description }}</p>
                    </div>
                    <span :class="getStatusClass(task.status)" 
                          class="px-3 py-1 text-xs font-semibold rounded-full ml-4">
                      {{ task.status }}
                    </span>
                  </div>

                  <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                      <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span :class="isOverdue(task.deadline) ? 'text-red-600 font-semibold' : ''">
                          Due: {{ formatDate(task.deadline) }}
                          <span v-if="isOverdue(task.deadline)" class="text-red-500 ml-1">(Overdue)</span>
                        </span>
                      </div>
                      <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Created: {{ formatDate(task.created_at) }}
                      </div>
                    </div>

                    <div class="flex items-center space-x-2">
                      <select v-model="task.status" @change="updateTaskStatus(task)" 
                              class="px-3 py-1 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="Pending">Pending</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Completed">Completed</option>
                      </select>
                    </div>
                  </div>

                  <!-- Progress bar for visual representation -->
                  <div class="mt-4">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                      <div :class="getProgressClass(task.status)" 
                           :style="{ width: getProgressWidth(task.status) }"
                           class="h-2 rounded-full transition-all duration-300"></div>
                    </div>
                  </div>
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
import { computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';

const props = defineProps({
  tasks: Array
});

const getTaskCount = (status) => {
  return props.tasks.filter(task => task.status === status).length;
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

const getProgressClass = (status) => {
  switch (status) {
    case 'Completed':
      return 'bg-green-500';
    case 'In Progress':
      return 'bg-yellow-500';
    case 'Pending':
      return 'bg-gray-400';
    default:
      return 'bg-gray-400';
  }
};

const getProgressWidth = (status) => {
  switch (status) {
    case 'Completed':
      return '100%';
    case 'In Progress':
      return '60%';
    case 'Pending':
      return '20%';
    default:
      return '20%';
  }
};

const formatDate = (date) => {
  return new Date(date).toLocaleDateString();
};

const isOverdue = (deadline) => {
  return new Date(deadline) < new Date() && new Date(deadline).toDateString() !== new Date().toDateString();
};

const updateTaskStatus = (task) => {
  router.put(route('user.tasks.updateStatus', task.id), {
    status: task.status
  }, {
    preserveScroll: true,
    onError: () => {
      // Revert the status if there's an error
      location.reload();
    }
  });
};
</script>