<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { defineAsyncComponent, computed, ref } from 'vue';

import Card from '@/Components/Card.vue';
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import Replies from '@/Pages/Threads/Partials/Replies.vue';

const DangerButton = defineAsyncComponent(() => import('@/Components/DangerButton.vue'));

const props = defineProps({ thread: Object, replies: Object, hasPages: Boolean });
const form = useForm({});

const repliesCount = ref(props.thread.replies_count);
const replyNoun = computed(() => repliesCount.value === 1 ? 'comment' : 'comments');

</script>

<template>
    <Head :title="thread.title" />
    <DefaultLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ thread.title }}</h2>
        </template>
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="flex space-x-12">
                <div class="w-2/3 space-y-4">
                    <Card>
                        <template #header>
                            <div class="flex justify-between items-center">
                                <h4 class="font-semibold">
                                    <Link :href="route('profiles.show', thread.owner.name)" class="text-blue-500 hover:underline">
                                        {{ thread.owner.name }}
                                    </Link> posted: {{ thread.title }}
                                </h4>
                                <form v-if="thread.can_update" @submit.prevent="form.delete(thread.path)">
                                    <DangerButton class="disabled:opacity-50 disabled:cursor-not-allowed" :disabled="form.processing">Delete Thread</DangerButton>
                                </form>
                            </div>
                        </template>
                        <template #body>
                            {{ thread.body }}
                        </template>
                    </Card>
                    <Replies :data="replies.data" :threadPath="thread.path" @added="repliesCount++" @removed="repliesCount--" />                    
                </div>
                <div class="flex-1">
                    <Card>
                        <template #body>
                            <p>
                                This thread was published <time>{{ thread.created_at }}</time> by 
                                <Link class="text-blue-500 hover:underline" :href="route('profiles.show', thread.owner.name)">{{ thread.owner.name }}</Link>, 
                                and currently has <span v-text="`${repliesCount} ${replyNoun}`" />.
                            </p>
                        </template>
                    </Card>
                </div>
            </div>
        </div>
    </DefaultLayout>
</template>
