<script setup>
import { computed, defineAsyncComponent } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import DefaultLayout from '@/Layouts/DefaultLayout.vue';

const Card = defineAsyncComponent(() => import('@/Components/Card.vue'));

const props = defineProps({ threads: Array });
const title = computed(() => 'Forum Threads');
</script>

<template>
    <Head :title="title" />
    <DefaultLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ title }}</h2>
        </template>
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div v-if="threads.length" class="space-y-4">
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
            <div v-else class="text-center">There are no relevant results at this time. &#128064;</div>
        </div>
    </DefaultLayout>
</template>
