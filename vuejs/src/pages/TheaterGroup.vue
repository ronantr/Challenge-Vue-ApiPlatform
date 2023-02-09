<script setup>
import { computed, ref, onMounted } from "vue";
import { apiFetch } from "../utils/apiFetch";
import { useToast } from "vue-toastification";

const props = defineProps({
    id: {
        type: String,
        required: true,
    },
});

const theaterGroup = ref(null);
const isLoading = ref(true);
const toast = useToast();

onMounted(async () => {
    try {
        const { data } = await apiFetch("/theater_groups/" + props.id);

        theaterGroup.value = data;
    } catch (error) {
        toast.error("something went wrong");
    } finally {
        isLoading.value = false;
    }
});

const source = computed(
    () => import.meta.env.VITE_API_URL + theaterGroup.value?.contentUrl
);
</script>

<template>
    <section
        v-if="!isLoading"
        class="flex flex-col items-center justify-center"
    >
        <h1 class="text-xl">Theater group</h1>
        <div class="flex flex-row gap-3">
            <div class="flex flex-col gap-1">
                <h2 class="text-lg">Name</h2>
                <p>{{ theaterGroup.name }}</p>
            </div>
            <div class="flex flex-col gap-1">
                <h2 class="text-lg">Status</h2>
                <p>{{ theaterGroup.status }}</p>
            </div>
        </div>
        <iframe :src="source" width="1080" height="720" />
        <a :href="source" target="_blank">Download</a>
    </section>
</template>
