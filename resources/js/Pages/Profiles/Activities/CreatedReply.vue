<script setup>
import { Link } from '@inertiajs/vue3';
import Card from '@/Components/Card.vue';
const props = defineProps({ author: String, subject: Object });
</script>

<template>
    <Card>
        <template #header>
            <h4 class="font-semibold text-lg">
                {{ author }} replied to: <Link :href="subject.thread.path" class="text-blue-500 hover:underline">"{{ subject.thread.title }}"</Link>
            </h4>
        </template>
        <template #body>
            {{ subject.body }}
        </template>
    </Card>
</template>
