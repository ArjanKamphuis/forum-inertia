<script setup>
import Card from '@/Components/Card.vue';
import FavoriteButton from './FavoriteButton.vue';
const props = defineProps({ reply: Object });
</script>

<template>
    <Card>
        <template #header>
            <div class="flex items-center justify-between">
                <h4 class="font-semibold">
                    <a href="#" class="text-blue-500 hover:underline">
                        {{ reply.owner.name }}
                    </a> replied {{ reply.created_at }}...
                </h4>
                <FavoriteButton :reply="reply" />
            </div>
        </template>
        <template #body>
            {{ reply.body }}
        </template>
    </Card>
</template>
