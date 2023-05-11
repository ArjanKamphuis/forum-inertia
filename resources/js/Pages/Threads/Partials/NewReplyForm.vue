<script setup>
import { computed } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

import Card from '@/Components/Card.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextArea from '@/Components/TextArea.vue';
import EventBus from '@/Services/EventBus.js';

const emits = defineEmits(['created']);

const signedIn = computed(() => !! usePage().props.auth.user);
const form = useForm({ body: '' });

const addReply = () => {
    form.post(`${location.pathname}/replies`, {
        preserveScroll: true,
        onSuccess: page => {
            form.reset();
            EventBus.emit('flash', 'Your reply has been left.');
            emits('created', page.props.flash.newReply);
        }
    });
};
</script>

<template>
    <Card v-if="signedIn">
        <template #body>
            <form @submit.prevent="addReply" id="new-reply-form">
                <TextArea v-model="form.body" id="body" class="block w-full h-24" placeholder="Have something to say?" required />
                <InputError :message="form.errors.body" class="mt-2" />
            </form>
        </template>
        <template #footer>
            <PrimaryButton form="new-reply-form" :disabled="form.processing">Post</PrimaryButton>
        </template>
    </Card>
    <p v-else class="text-center">
        Please <Link class="text-blue-500 hover:underline" :href="route('login')">sign in</Link> 
        or <Link class="text-blue-500 hover:underline" :href="route('register')">register</Link> 
        to participate in this discussion.
    </p>
</template>
