<script setup>
defineProps({
    id: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <section
        v-if="!isLoading"
        class="flex flex-col items-center justify-center"
    >
        <nav>
            <ul class="flex flex-row gap-3">
                <li>
                    <router-link :to="`/theater-group/${id}/events`"
                        >Events</router-link
                    >
                </li>
            </ul>
        </nav>
        <router-view />
    </section>
</template>
