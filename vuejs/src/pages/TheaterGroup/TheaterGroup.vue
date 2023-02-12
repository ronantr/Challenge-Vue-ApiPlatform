<script setup>
defineProps({
    theaterGroupId: {
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
                    <router-link :to="`/theater-group/${theaterGroupId}/events`"
                        >Events</router-link
                    >
                </li>
            </ul>
        </nav>
        <router-view />
    </section>
</template>
