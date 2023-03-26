<script setup>
import { computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import Card from '@/Components/Card.vue';
import DefaultLayout from '@/Layouts/DefaultLayout.vue';

const props = defineProps({ threads: Object });
const title = computed(() => 'Forum Threads');
</script>

<template>
    <Head :title="title" />
    <DefaultLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ title }}</h2>
        </template>
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="space-y-4">
                <Card v-for="thread in threads" :key="thread.id">
                    <template #header>
                        <div class="flex justify-between items-center">
                            <h4 class="text-lg font-semibold">
                                <Link :href="thread.path" class="text-blue-500 hover:underline">{{ thread.title }}</Link>
                            </h4>
                            <Link :href="thread.path" class="text-blue-500 hover:underline">{{ thread.replies_count }} {{ thread.reply_noun }}</Link>
                        </div>
                    </template>
                    <template #body>
                        {{ thread.body }}
                    </template>
                </Card>
            </div>
        </div>
    </DefaultLayout>
</template>
