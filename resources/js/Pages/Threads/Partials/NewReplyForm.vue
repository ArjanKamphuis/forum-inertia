<script setup>
import Card from '@/Components/Card.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextArea from '@/Components/TextArea.vue';
import { useForm } from '@inertiajs/vue3';

import EventBus from '@/Services/EventBus.js';

const props = defineProps({ 'thread-path': { type: String, required: true } });
const form = useForm({ body: '' });

const addReply = () => {
    form.post(`${props.threadPath}/replies`, {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            EventBus.emit('flash', 'Your reply has been left.');
        }
    });
};
</script>

<template>
    <Card>
        <template #body>
            <form @submit.prevent="addReply" id="new-reply-form">
                <TextArea v-model="form.body" id="body" class="block w-full h-24" placeholder="Have something to say?" />
                <InputError :message="form.errors.body" class="mt-2" />
            </form>
        </template>
        <template #footer>
            <PrimaryButton form="new-reply-form" :disabled="form.processing">Post</PrimaryButton>
        </template>
    </Card>
</template>
