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
        <div class="py-12 space-y-4">
            <Card v-for="thread in threads" :key="thread.id">
                <template #header>
                    <h4 class="text-lg font-semibold">
                        <Link :href="thread.path" class="text-blue-500 hover:underline">{{ thread.title }}</Link>
                    </h4>
                </template>
                <template #body>
                    {{ thread.body }}
                </template>
            </Card>
        </div>
    </DefaultLayout>
</template>
