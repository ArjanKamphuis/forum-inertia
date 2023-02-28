<script setup>

</script>

<template>
    <article class="rounded-lg bg-white shadow-lg dark:bg-neutral-700">
        <header v-if="$slots.header" class="border-b-2 border-neutral-100 py-3 px-6 dark:border-neutral-600 dark:text-neutral-50">
            <slot name="header" />
        </header>
        <main v-if="$slots.body" class="p-6">
            <slot name="body" />
        </main>
        <footer v-if="$slots.footer" class="border-t-2 border-neutral-100 py-3 px-6 dark:border-neutral-600 dark:text-neutral-50">
            <slot name="footer" />
        </footer>
    </article>
</template>
