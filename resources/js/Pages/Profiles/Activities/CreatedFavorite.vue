<script setup>
import { Link } from '@inertiajs/vue3';
import Card from '@/Components/Card.vue';
const props = defineProps({ author: String, subject: Object });
</script>

<template>
    <Card>
        <template #header>
            <h4 class="font-semibold text-lg">
                <Link :href="subject.favorited.path" class="text-blue-500 hover:underline">
                    {{ author }} favorited a reply.
                </Link>
            </h4>
        </template>
        <template #body>
            {{ subject.favorited.body }}
        </template>
    </Card>
</template>
