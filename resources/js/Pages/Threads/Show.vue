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
            <Card v-for="reply in thread.replies" :key="reply.id">
                <template #header>
                    <h4 class="font-semibold">
                        <a href="#" class="text-blue-500 hover:underline">
                            {{ reply.owner.name }}
                        </a> said {{ reply.created }}...
                    </h4>
                </template>
                <template #body>
                    {{ reply.body }}
                </template>
            </Card>
        </div>
    </DefaultLayout>
</template>
