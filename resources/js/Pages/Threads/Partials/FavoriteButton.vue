<script setup>
import { computed, ref } from 'vue';

const props = defineProps({ reply: Object });

const favoritesCount = ref(props.reply.favorites_count);
const favoriteNoun = computed(() => favoritesCount.value === 1 ? 'favorite' : 'favorites');

const disabled = ref(props.reply.is_favorited);
const extraClasses = computed(() => disabled.value 
    ? 'disabled:opacity-50 disabled:cursor-not-allowed' 
    : 'hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800'
);

const favorite = async () => {
    try {
        const response = await axios.post(`/replies/${props.reply.id}/favorites`);
        if (response.data) {
            favoritesCount.value++;
            disabled.value = true;
        }
    } catch (error) {
        console.error(error.message);
    }
};
</script>

<template>
    <form @submit.prevent="favorite">
        <button type="submit" :disabled="disabled" :class="extraClasses" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest transition ease-in-out duration-150">
            {{ favoritesCount }} {{ favoriteNoun }}
        </button>
    </form>
</template>
