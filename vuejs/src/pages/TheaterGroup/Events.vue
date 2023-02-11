<script setup>
defineProps({
    id: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <section>
        <h1 class="text-xl">Events</h1>
        <router-link :to="`/theater-group/${id}`">Back</router-link>
        <router-link :to="`/theater-group/${id}/events/create`"
            >Create Event</router-link
        >
    </section>
</template>
