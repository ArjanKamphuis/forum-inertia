<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

import Card from '@/Components/Card.vue';
import DangerButton from '@/Components/DangerButton.vue';
import FavoriteButton from '@/Pages/Threads/Partials/FavoriteButton.vue';

const props = defineProps({ reply: Object });
const form = useForm({});
const id = computed(() => `reply-${props.reply.id}`);
</script>

<template>
    <Card :id="id">
        <template #header>
            <div class="flex items-center justify-between">
                <h4 class="font-semibold">
                    <Link :href="route('profiles.show', reply.owner.name)" class="text-blue-500 hover:underline">
                        {{ reply.owner.name }}
                    </Link> replied {{ reply.created_at }}...
                </h4>
                <FavoriteButton :reply="reply" />
            </div>
        </template>
        <template #body>
            {{ reply.body }}
        </template>
        <template v-if="reply.can_update" #footer>
            <form @submit.prevent="form.delete(`/replies/${reply.id}`)">
                <DangerButton class="h-6">Delete</DangerButton>
            </form>
        </template>
    </Card>
</template>
