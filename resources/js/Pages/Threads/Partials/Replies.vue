<script setup>
import { computed, defineAsyncComponent, ref, watch } from 'vue';
import NewReplyForm from '@/Pages/Threads/Partials/NewReplyForm.vue';

//const Pagination = defineAsyncComponent(() => import('@/Components/Pagination.vue'));
const Reply = defineAsyncComponent(() => import('@/Pages/Threads/Partials/Reply.vue'));

const props = defineProps({ data: Array });
const emits = defineEmits(['added', 'removed']);

const repliesRef = ref(null);
const items = ref(props.data);
const endpoint = computed(() => `${location.pathname}/replies`);
    
if (location.hash) {
    watch(repliesRef, () => {
        document.querySelector(location.hash)?.scrollIntoView();
    });
}

const add = (reply) => {
    items.value.push(reply);
    emits('added');
};

const remove = index => {
    items.value.splice(index, 1);
    emits('removed');
};
</script>

<template>
    <Reply ref="repliesRef" v-for="(reply, index) in items" :key="reply.id" :data="reply" @deleted="remove(index)" />
    <!-- <Pagination v-if="hasPages" :meta="replies.meta" :links="replies.links" /> -->
    <NewReplyForm :endpoint="endpoint" @created="add" />
</template>
