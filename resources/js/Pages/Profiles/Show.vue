<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Card from '@/Components/Card.vue';
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({ profile: Object, threads: Object });
</script>

<template>
    <Head :title="profile.name" />
    <DefaultLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ profile.name }}
                <small>Since <time>{{ profile.created_at }}</time></small>
            </h2>
        </template>
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="space-y-4">
                <Card v-for="thread in threads.data" :key="thread.id">
                    <template #header>
                        <div class="flex justify-between items-center">
                            <h4 class="font-semibold">
                                <Link :href="route('profiles.show', profile.name)" class="text-blue-500 hover:underline">{{ profile.name }}</Link>
                                <span> posted: </span>
                                <Link :href="thread.path" class="text-blue-500 hover:underline">{{ thread.title }}</Link>
                            </h4>
                            <time>{{ thread.created_at }}</time>
                        </div>
                    </template>
                    <template #body>
                        {{ thread.body }}
                    </template>
                </Card>
                <Pagination :links="threads.links" :meta="threads.meta" />
            </div>
        </div>
    </DefaultLayout>
</template>
