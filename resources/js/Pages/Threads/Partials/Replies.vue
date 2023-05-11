<script setup>
import { computed, defineAsyncComponent, ref, watch } from 'vue';
import { Link, usePage } from '@inertiajs/vue3'

const NewReplyForm = defineAsyncComponent(() => import('@/Pages/Threads/Partials/NewReplyForm.vue'));
//const Pagination = defineAsyncComponent(() => import('@/Components/Pagination.vue'));
const Reply = defineAsyncComponent(() => import('@/Pages/Threads/Partials/Reply.vue'));

const props = defineProps({ data: Array, threadPath: String });
const emits = defineEmits(['added', 'removed']);

const signedIn = computed(() => !! usePage().props.auth.user);
const repliesRef = ref(null);
const items = ref(props.data);
    
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
    <NewReplyForm v-if="signedIn" :threadPath="threadPath" @created="add" />
    <p v-else class="text-center">
        Please <Link class="text-blue-500 hover:underline" :href="route('login')">sign in</Link> 
        or <Link class="text-blue-500 hover:underline" :href="route('register')">register</Link> 
        to participate in this discussion.
    </p>
</template>
