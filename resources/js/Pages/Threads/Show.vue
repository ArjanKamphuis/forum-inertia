<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

import Card from '@/Components/Card.vue';
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import NewReplyForm from '@/Pages/Threads/Partials/NewReplyForm.vue';
import Pagination from '@/Components/Pagination.vue';
import Reply from '@/Pages/Threads/Partials/Reply.vue';

const props = defineProps({ thread: Object, replies: Object });
const signedIn = computed(() => usePage().props.auth.user ?? false);
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
                            <h4 class="font-semibold">
                                <Link href="#" class="text-blue-500 hover:underline">
                                    {{ thread.owner.name }}
                                </Link> posted: {{ thread.title }}
                            </h4>
                        </template>
                        <template #body>
                            {{ thread.body }}
                        </template>
                    </Card>
                    <Reply v-for="reply in replies.data" :key="reply.id" :reply="reply" />
                    <Pagination :meta="replies.meta" :links="replies.links" />
                    <NewReplyForm v-if="signedIn" :thread-path="thread.path" />
                    <p v-else class="text-center">
                        Please <Link class="text-blue-500 hover:underline" :href="route('login')">sign in</Link> 
                        or <Link class="text-blue-500 hover:underline" :href="route('register')">register</Link> 
                        to participate in this discussion.
                    </p>
                </div>
                <div class="flex-1">
                    <Card>
                        <template #body>
                            <p>
                                This thread was published <time>{{ thread.created_at }}</time> by 
                                <Link class="text-blue-500 hover:underline" href="#">{{ thread.owner.name }}</Link>, 
                                and currently has {{ thread.replies_count }} {{ thread.comment_noun }}.
                            </p>
                        </template>
                    </Card>
                </div>
            </div>
        </div>
    </DefaultLayout>
</template>
