<script setup>
import Card from '@/Components/Card.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextArea from '@/Components/TextArea.vue';
import { useForm } from '@inertiajs/vue3';

import EventBus from '@/Services/EventBus.js';

const props = defineProps({ threadPath: { type: String, required: true } });
const emits = defineEmits(['created']);
const form = useForm({ body: '' });

const addReply = () => {
    form.post(`${props.threadPath}/replies`, {
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
    <Card>
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
</template>
