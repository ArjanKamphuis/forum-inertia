<script setup>
import { Head } from '@inertiajs/vue3';
import Card from '@/Components/Card.vue';
import DefaultLayout from '@/Layouts/DefaultLayout.vue';

const props = defineProps({ thread: Object });
</script>

<template>
    <Head :title="thread.title" />
    <DefaultLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ thread.title }}</h2>
        </template>
        <div class="py-12 space-y-4">
            <Card>
                <template #body>
                    {{ thread.body }}
                </template>
            </Card>
        </div>
    </DefaultLayout>
</template>
