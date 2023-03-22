<script setup>
import { useForm, usePage } from '@inertiajs/vue3';

import Card from '@/Components/Card.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SelectInput from '@/Components/SelectInput.vue';
import TextArea from '@/Components/TextArea.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    channel_id: '',
    title: '',
    body: ''
});
</script>

<template>
    <Card>
        <template #body>
            <form @submit.prevent="form.post('/threads')" id="new-thread-form" class="space-y-4">
                <div>
                    <InputLabel for="channel_id" value="Choose a channel:" />
                    <SelectInput v-model.number="form.channel_id" id="channel_id" class="block w-full" required>
                        <option disabled value="">Choose One...</option>
                        <option v-for="channel in usePage().props.channels" :key="channel.id" :value="channel.id" v-text="channel.name" />
                    </SelectInput>
                    <InputError :message="form.errors.channel_id" class="mt-2" />
                </div>
                <div>
                    <InputLabel for="title" value="Title:" />
                    <TextInput v-model="form.title" id="title" type="text" class="block w-full" required />
                    <InputError :message="form.errors.title" class="mt-2" />
                </div>
                <div>
                    <InputLabel for="body" value="Body:" />
                    <TextArea v-model="form.body" id="body" class="block w-full h-48" required />
                    <InputError :message="form.errors.body" class="mt-2" />
                </div>
            </form>
        </template>
        <template #footer>
            <PrimaryButton form="new-thread-form" :disabled="form.processing">Publish</PrimaryButton>
        </template>
    </Card>
</template>
