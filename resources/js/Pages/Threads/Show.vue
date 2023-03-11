<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import Card from '@/Components/Card.vue';
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import NewReplyForm from '@/Pages/Threads/Partials/NewReplyForm.vue';
import Reply from '@/Pages/Threads/Partials/Reply.vue';

const props = defineProps({ thread: Object });
const signedIn = computed(() => usePage().props.auth.user ?? false);
</script>

<template>
    <Head :title="thread.title" />
    <DefaultLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ thread.title }}</h2>
        </template>
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="space-y-4">
                <Card>
                    <template #header>
                        <h4 class="font-semibold">
                            <a href="#" class="text-blue-500 hover:underline">
                                {{ thread.owner.name }}
                            </a> posted: {{ thread.title }}
                        </h4>
                    </template>
                    <template #body>
                        {{ thread.body }}
                    </template>
                </Card>
                <Reply v-for="reply in thread.replies" :key="reply.id" :reply="reply" />
                <NewReplyForm v-if="signedIn" :thread-id="thread.id" />
                <p v-else class="text-center">
                    Please <Link class="text-blue-500 hover:underline" :href="route('login')">sign in</Link> 
                    or <Link class="text-blue-500 hover:underline" :href="route('register')">register</Link> 
                    to participate in this discussion.
                </p>
            </div>
        </div>
    </DefaultLayout>
</template>
