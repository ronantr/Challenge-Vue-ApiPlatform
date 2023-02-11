<script setup>
import { computed, ref, onMounted } from "vue";
import { useToast } from "vue-toastification";
import { apiFetch } from "../../utils/apiFetch";

const props = defineProps({
    eventId: {
        type: String,
        required: true,
    },
    theaterGroupId: {
        type: String,
        required: true,
    },
});

const event = ref(null);
const isLoading = ref(true);
const toast = useToast();

onMounted(async () => {
    try {
        const { data } = await apiFetch("/events/" + props.eventId);

        event.value = data;
    } catch (error) {
        toast.error("something went wrong");
    } finally {
        isLoading.value = false;
    }
});

const imageSrc = computed(
    () => import.meta.env.VITE_API_URL + event.value.contentUrl
);

async function updateEvent(fields) {
    try {
        const { data } = await apiFetch("/events/" + props.eventId, fields, {
            method: "PATCH",
            headers: {
                "Content-Type": "application/merge-patch+json",
            },
        });

        event.value = data;

        toast.success("Event updated");
    } catch (error) {
        toast.error("something went wrong");
    }
}

const publish = () => updateEvent({ isPublished: true });

const unpublish = () => updateEvent({ isPublished: false });
</script>

<template>
    <section v-if="!isLoading">
        <h1 class="text-xl">Event</h1>
        <router-link :to="`/theater-group/${props.theaterGroupId}/events`">
            Back
        </router-link>
        <div class="flex flex-col gap-3">
            <img :src="imageSrc" alt="event cover" />
            <div v-if="event.isPublished" class="flex flex-col gap-1">
                <span>Published</span>
            </div>
            <div v-else class="flex flex-col gap-1">
                <span>Not published</span>
            </div>
            <div class="flex flex-col gap-1">
                <span>Name</span>
                <span>{{ event.name }}</span>
            </div>
            <div class="flex flex-col gap-1">
                <span>Date</span>
                <span>{{ event.date }}</span>
            </div>
            <div class="flex flex-col gap-1">
                <span>Description</span>
                <span>{{ event.description }}</span>
            </div>
            <div class="flex flex-col gap-1">
                <span>Capacity</span>
                <span>{{ event.capacity }}</span>
            </div>
            <div class="flex flex-col gap-1">
                <span>Location</span>
                <span>{{ event.location }}</span>
            </div>
            <div v-if="event.video" class="flex flex-col gap-1">
                <span>Video</span>
                <span>{{ event.video }}</span>
            </div>
            <button
                v-if="event.isPublished"
                @click="unpublish"
                class="bg-red-500 text-white"
            >
                Mark as not published
            </button>
            <button v-else @click="publish" class="bg-blue-500 text-white">
                Publish
            </button>
        </div>
    </section>
</template>
