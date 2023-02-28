<script setup>
import Card from '@/Components/Card.vue';
const props = defineProps({ reply: Object });
</script>

<template>
    <Card>
        <template #header>
            <h4 class="font-semibold">
                <a href="#" class="text-blue-500 hover:underline">
                    {{ reply.owner.name }}
                </a> replied {{ reply.created }}...
            </h4>
        </template>
        <template #body>
            {{ reply.body }}
        </template>
    </Card>
</template>
