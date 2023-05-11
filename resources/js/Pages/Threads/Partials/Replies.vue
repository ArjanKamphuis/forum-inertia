<script setup>
import { computed, defineAsyncComponent, onMounted, ref, watch } from 'vue';
import NewReplyForm from '@/Pages/Threads/Partials/NewReplyForm.vue';
import { useCollection } from '@/Composables/collection';
import axios from 'axios';

const Paginator = defineAsyncComponent(() => import('@/Components/Paginator.vue'));
const Reply = defineAsyncComponent(() => import('@/Pages/Threads/Partials/Reply.vue'));

const emits = defineEmits(['added', 'removed']);
const { items, add, remove } = useCollection(emits);

const repliesRef = ref(null);
const dataSet = ref({});
const hasPages = computed(() => dataSet.value.meta?.total > 1 ?? false);
    
if (location.hash) {
    watch(repliesRef, () => {
        document.querySelector(location.hash)?.scrollIntoView();
    });
}

onMounted(() => { fetch(); });

const fetch = (page) => {
    axios.get(url(page)).then(refresh).catch(ex => { console.error(ex.message); });
};

const url = (page) => {
    if (!page) {
        const query = location.search.match(/page=(\d+)/);
        page = query ? query[1] : 1;
    }
    return `${location.pathname}/replies?page=${page}`;
};

const refresh = ({ data }) => {
    dataSet.value = data;
    items.value = data.data;
};
</script>

<template>
    <Reply ref="repliesRef" v-for="(reply, index) in items" :key="reply.id" :data="reply" @deleted="remove(index)" />
    <Paginator v-if="hasPages" :meta="dataSet.meta" :links="dataSet.links" @changed="fetch" />
    <NewReplyForm @created="add" />
</template>
