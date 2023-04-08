<script setup>
import { usePage } from '@inertiajs/vue3';
import { onBeforeUnmount, onMounted, ref } from 'vue';

import EventBus from '@/Services/EventBus.js';

const body = ref('');
const show = ref(false);
const timerId = ref(0);

onMounted(() => {
    if (usePage().props.flash) {
        flash(usePage().props.flash);
    }
    EventBus.on('flash', flash);
});

onBeforeUnmount(() => {
    EventBus.off('flash', flash);
})

const flash = (message) => {
    body.value = message;
    show.value = true;
    hide();
};

const hide = () => {
    clearTimeout(timerId);
    timerId.value = setTimeout(() => { show.value = false }, 3000);
};
</script>

<template>
    <div class="fixed bottom-6 right-6 px-5 py-3 text-green-700 bg-green-100 border border-green-200 rounded" role="alert" v-show="show">
        <strong>Success!</strong> {{ body }}
    </div>
</template>
