<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed, defineAsyncComponent, ref } from 'vue';

import Card from '@/Components/Card.vue';
import axios from 'axios';
import EventBus from '@/Services/EventBus';

const DangerButton = defineAsyncComponent(() => import('@/Components/DangerButton.vue'));
const FavoriteButton = defineAsyncComponent(() => import('@/Pages/Threads/Partials/FavoriteButton.vue'));
const PrimaryButton = defineAsyncComponent(() => import('@/Components/PrimaryButton.vue'));
const SecondaryButton = defineAsyncComponent(() => import('@/Components/SecondaryButton.vue'));
const TextArea = defineAsyncComponent(() => import('@/Components/TextArea.vue'));

const props = defineProps({ data: Object });
const emits = defineEmits(['deleted']);
const signedIn = computed(() => !! usePage().props.auth.user);
const id = computed(() => `reply-${props.data.id}`);

const editing = ref(false);
const body = ref(props.data.body);

const update = () => {
    axios.patch(`/replies/${props.data.id}`, { body: body.value })
        .then(() => {
            editing.value = false;
            EventBus.emit('flash', 'Updated!');
        })
        .catch(error => { console.log(error.message); });
};

const destroy = () => {
    axios.delete(`/replies/${props.data.id}`)
        .then(() => {
            EventBus.emit('flash', 'Reply has been deleted!');
            emits('deleted', props.data.id); 
        })
        .catch(error => { console.log(error.message); });
};
</script>

<template>
    <Card :id="id" v-cloak>
        <template #header>
            <div class="flex items-center justify-between">
                <h4 class="font-semibold">
                    <Link :href="route('profiles.show', data.owner.name)" class="text-blue-500 hover:underline" v-text="data.owner.name" /> replied {{ data.created_at }}...
                </h4>
                <FavoriteButton v-if="signedIn" :reply="data" />
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
        <template v-if="data.can_update" #footer>
            <div class="flex space-x-2">
                <SecondaryButton class="h-6" @click="editing = true">Edit</SecondaryButton>
                <DangerButton class="h-6" @click="destroy">Delete</DangerButton>
            </div>
        </template>
    </Card>
</template>
