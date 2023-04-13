<script setup>
import { defineAsyncComponent } from 'vue';
import { Head } from '@inertiajs/vue3';
import DefaultLayout from '@/Layouts/DefaultLayout.vue';

const props = defineProps({ profile: Object, activities: Object });

const mapComponents = {
    created_thread: defineAsyncComponent(() => import('@/Pages/Profiles/Activities/CreatedThread.vue')),
    created_reply: defineAsyncComponent(() => import('@/Pages/Profiles/Activities/CreatedReply.vue')),
    created_favorite: defineAsyncComponent(() => import('@/Pages/Profiles/Activities/CreatedFavorite.vue'))
}
</script>

<template>
    <Head :title="profile.name" />
    <DefaultLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ profile.name }}
            </h2>
        </template>
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div v-if="Object.keys(activities).length" class="space-y-12">
                <div v-for="(activity, date) in activities">
                    <h3 class="mb-4 text-lg font-bold text-center"><time class="border-b">{{ date }}</time></h3>
                    <div class="space-y-4">
                        <component v-for="record in activity" :is="mapComponents[record.type]" :author="profile.name" :subject="record.subject" />
                    </div>
                </div>
            </div>
            <div v-else class="text-center">There is no activity for this user yet. &#128542;</div>
        </div>
    </DefaultLayout>
</template>
