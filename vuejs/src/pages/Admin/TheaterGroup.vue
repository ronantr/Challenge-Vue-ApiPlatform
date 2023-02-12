<script setup>
import { computed, ref, onMounted } from "vue";
import { useToast } from "vue-toastification";
import { apiFetch } from "../../utils/apiFetch";

const props = defineProps({
    theaterGroupId: {
        type: Number,
        required: true,
    },
});

const theaterGroup = ref({});
const isLoading = ref(true);
const toast = useToast();

onMounted(async () => {
    try {
        const { data } = await apiFetch(
            "/theater_groups/" + props.theaterGroupId
        );

        theaterGroup.value = data;
    } catch (error) {
        toast.error(error.message);
    } finally {
        isLoading.value = false;
    }
});

async function verify() {
    try {
        const { data } = await apiFetch(
            "/theater_groups/" + props.theaterGroupId,
            {
                status: "verified",
            },
            {
                headers: {
                    "Content-Type": "application/merge-patch+json",
                },
                method: "PATCH",
            }
        );

        theaterGroup.value.status = data.status;

        toast.success("Theater group verified");
    } catch (error) {
        toast.error(error.message);
    }
}

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
        <router-link to="/admin/theater-groups">Back</router-link>
        <div class="flex flex-row gap-3">
            <div class="flex flex-col gap-1">
                <div class="text-lg">Name</div>
                <div>{{ theaterGroup.name }}</div>
            </div>
            <div class="flex flex-col gap-1">
                <div class="text-lg">Phone number</div>
                <div>{{ theaterGroup.phoneNumber }}</div>
            </div>
            <div class="flex flex-col gap-1">
                <div class="text-lg">Status</div>
                <div>{{ theaterGroup.status }}</div>
            </div>
        </div>
        <iframe :src="source" width="1080" height="720" />
        <a :href="source" target="_blank">Download</a>
        <button @click="verify">Verify</button>
    </section>
</template>
