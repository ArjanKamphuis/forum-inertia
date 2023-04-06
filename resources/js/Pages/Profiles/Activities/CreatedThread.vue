<script setup>
import { Link } from '@inertiajs/vue3';
import Card from '@/Components/Card.vue';
const props = defineProps({ author: String, subject: Object });
</script>

<template>
    <Card>
        <template #header>
            <h4 class="font-semibold text-lg">
                {{ author }} published: <Link :href="subject.path" class="text-blue-500 hover:underline">{{ subject.title }}</Link>
            </h4>
        </template>
        <template #body>
            {{ subject.body }}
        </template>
    </Card>
</template>
