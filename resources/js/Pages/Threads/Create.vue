<script setup>
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import NewThreadForm from '@/Pages/Threads/Partials/NewThreadForm.vue';

const title = computed(() => 'Create a New Thread');
</script>

<template>
    <Head :title="title" />
    <DefaultLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ title }}</h2>
        </template>
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <NewThreadForm />
        </div>
    </DefaultLayout>
</template>
