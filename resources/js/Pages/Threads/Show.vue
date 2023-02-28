<script setup>
import { Head } from '@inertiajs/vue3';
import Card from '@/Components/Card.vue';
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import Reply from '@/Pages/Threads/Partials/Reply.vue';

const props = defineProps({ thread: Object });
</script>

<template>
    <Head :title="thread.title" />
    <DefaultLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ thread.title }}</h2>
        </template>
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="space-y-4">
                <Card>
                    <template #header>
                        <h4 class="font-semibold">
                            <a href="#" class="text-blue-500 hover:underline">
                                {{ thread.owner.name }}
                            </a> posted: {{ thread.title }}
                        </h4>
                    </template>
                    <template #body>
                        {{ thread.body }}
                    </template>
                </Card>
                <Reply v-for="reply in thread.replies" :key="reply.id" :reply="reply" />
            </div>
        </div>
    </DefaultLayout>
</template>
