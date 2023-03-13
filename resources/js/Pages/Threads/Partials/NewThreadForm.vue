<script setup>
import { useForm } from '@inertiajs/vue3';
import Card from '@/Components/Card.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextArea from '@/Components/TextArea.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    title: '',
    body: ''
});
</script>

<template>
    <Card>
        <template #body>
            <form @submit.prevent="form.post('/threads')" id="new-thread-form" class="space-y-4">
                <div>
                    <InputLabel for="title" value="Title" />
                    <TextInput v-model="form.title" id="title" type="text" class="block w-full" />
                    <InputError :message="form.errors.title" class="mt-2" />
                </div>
                <div>
                    <InputLabel for="body" value="Body" />
                    <TextArea v-model="form.body" id="body" class="block w-full h-48" />
                    <InputError :message="form.errors.body" class="mt-2" />
                </div>
            </form>
        </template>
        <template #footer>
            <PrimaryButton form="new-thread-form" :disabled="form.processing">Publish</PrimaryButton>
        </template>
    </Card>
</template>
