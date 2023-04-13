<script setup>
import { computed, ref } from 'vue';
import axios from 'axios';

const props = defineProps({ reply: Object });

const count = ref(props.reply.favorites_count);
const active = ref(props.reply.is_favorited);
const btn = ref({});

const endpoint = computed(() => `/replies/${props.reply.id}/favorites`);
const classes = computed(() => active.value 
    ? 'inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150'
    : 'inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150'
);

const toggle = async () => {
    try {
        if (active.value) {
            if ((await axios.delete(endpoint.value)).data) {
                active.value = false;
                count.value--;
            }
        } else {
            if ((await axios.post(endpoint.value)).data) {
                active.value = true;
                count.value++;
            }
        }
    } catch (e) {
        console.error(e.message);
    } finally {
        btn.value.blur();
    }
};
</script>

<template>
    <button ref="btn" :class="classes" @click="toggle" v-text="`&#129293; ${count}`" />
</template>
