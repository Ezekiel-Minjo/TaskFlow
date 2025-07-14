<template>
    <div class="container mt-4">
        <h1>TaskFlow Admin</h1>
        <p>Welcome, {{ user.name }}!</p>
        <div class="mb-4">
            <Link href="/admin/dashboard" class="btn btn-primary me-2"
                >Dashboard</Link
            >
            <Link href="/admin/users" class="btn btn-primary me-2"
                >Manage Users</Link
            >
            <Link href="/admin/tasks" class="btn btn-primary me-2"
                >Manage Tasks</Link
            >
            <Link href="/logout" class="btn btn-secondary">Logout</Link>
        </div>

        <slot />
        <!-- Nested routes will render here -->
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";

const user = computed(() => usePage().props.auth.user);
</script>
