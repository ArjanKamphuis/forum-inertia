<script setup>
import { Link, router, useForm } from '@inertiajs/vue3';
import { computed, defineAsyncComponent, ref } from 'vue';

import Card from '@/Components/Card.vue';
import FavoriteButton from '@/Pages/Threads/Partials/FavoriteButton.vue';
import axios from 'axios';
import EventBus from '@/Services/EventBus';

const DangerButton = defineAsyncComponent(() => import('@/Components/DangerButton.vue'));
const PrimaryButton = defineAsyncComponent(() => import('@/Components/PrimaryButton.vue'));
const SecondaryButton = defineAsyncComponent(() => import('@/Components/SecondaryButton.vue'));
const TextArea = defineAsyncComponent(() => import('@/Components/TextArea.vue'));

const props = defineProps({ reply: Object });
const form = useForm({});
const id = computed(() => `reply-${props.reply.id}`);

const editing = ref(false);
const body = ref(props.reply.body);

const update = () => {
    axios.patch(`/replies/${props.reply.id}`, { body: body.value })
        .then(() => {
            editing.value = false;
            EventBus.emit('flash', 'Updated!');
        })
        .catch(error => { console.log(error.message); });
};
</script>

<template>
    <Card :id="id" v-cloak>
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
            <div v-if="editing">
                <TextArea class="w-full" v-model="body"></TextArea>
                <div class="space-x-2">
                    <PrimaryButton class="h-6" @click="update">Update</PrimaryButton>
                    <SecondaryButton class="h-6" @click="editing = false">Cancel</SecondaryButton>
                </div>
            </div>
            <div v-else v-text="body"></div>
        </template>
        <template v-if="reply.can_update" #footer>
            <div class="flex space-x-2">
                <SecondaryButton class="h-6" @click="editing = true">Edit</SecondaryButton>
                <form @submit.prevent="form.delete(`/replies/${reply.id}`)">
                    <DangerButton class="h-6">Delete</DangerButton>
                </form>
            </div>
        </template>
    </Card>
</template>
