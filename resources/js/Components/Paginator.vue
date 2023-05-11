<script setup>
import { computed, ref, watch } from 'vue';

const props = defineProps({ meta: Object, links: Object });
const emits = defineEmits(['changed']);

const page = ref(props.meta.current_page);
const elements = computed(() => props.meta.links.slice(1, props.meta.links.length - 1));
const shouldPaginate = computed(() => !! props.links.prev || !! props.links.next);

const firstElement = computed(() => {
    const first = props.meta.per_page * (props.meta.current_page - 1) + 1;
    return props.meta.current_page <= props.meta.last_page ? first : 0;
});
const lastElement = computed(() =>  {
    const last = props.meta.per_page * props.meta.current_page;
    return last < props.meta.total ? last : props.meta.total;
});

const broadcast = () => {
    emits('changed', page.value);
};
const updateUrl = () => {
    history.pushState(null, null, `?page=${page.value}`);
};

watch(page, () => {
    broadcast();
    updateUrl();
});
</script>

<template>
    <nav v-if="shouldPaginate" class="flex items-center justify-between">
        <div class="flex justify-between flex-1 sm:hidden">
            <span v-if="links.prev" @click="page--" class="cursor-pointer relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                Previous
            </span>
            <span v-else class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                Previous
            </span>
            <span v-if="links.next" @click="page++" class="cursor-pointer relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                Next
            </span>
            <span v-else class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                Next
            </span>
        </div>
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between  sm:space-x-2">
            <p class="text-sm text-gray-700 leading-5">
                Showing 
                <span v-if="firstElement > 0">
                    <span class="font-medium">{{ firstElement }}</span> to <span class="font-medium">{{ lastElement }}</span>
                </span>
                <span v-else>{{ firstElement }}</span> 
                of <span class="font-medium">{{ meta.total }}</span> results
            </p>
            <div>
                <span class="relative z-0 inline-flex shadow-sm rounded-md">
                    <!-- Previous Page Link -->
                    <span v-if="links.prev" rel="prev" @click="page--" class="cursor-pointer relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md leading-5 hover:text-gray-400 hover:bg-gray-100 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" aria-label="Previous">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    <span v-else aria-disabled="true" aria-label="Previous">
                        <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5" aria-hidden="true">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </span>
                    <!-- Pagination Elements -->
                    <div v-for="element in elements">
                        <div v-if="element.url">
                            <span v-if="element.active" :aria-current="`Page: ${element.label}`">
                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-white bg-gray-500 border border-gray-300 cursor-default leading-5">{{ element.label }}</span>
                            </span>
                            <span v-else @click="page = parseInt(element.label)" class="cursor-pointer relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 hover:bg-gray-100 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" :aria-label="`Go to page: ${element.label}`">
                                {{ element.label }}
                            </span>
                        </div>
                        <span v-else aria-disabled="true">
                            <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default leading-5">{{ element.label }}</span>
                        </span>
                    </div>
                    <!-- Next Page Link -->
                    <span v-if="links.next" rel="next" @click="page++" class="cursor-pointer relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400 hover:bg-gray-100 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" aria-label="Next">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    <span v-else aria-disabled="true" aria-label="Next">
                        <span class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-r-md leading-5" aria-hidden="true">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </span>
                </span>
            </div>
        </div>
    </nav>
</template>
