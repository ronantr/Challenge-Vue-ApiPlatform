<script setup>
import { ref, onMounted } from "vue";
import { useToast } from "vue-toastification";
import { apiFetch } from "../../utils/apiFetch";

const props = defineProps({
    id: {
        type: Number,
        required: true,
    },
});

const theaterGroup = ref({});
const isLoading = ref(true);
const toast = useToast();

onMounted(async () => {
    try {
        const { data } = await apiFetch("/theater_groups/" + props.id);

        theaterGroup.value = data;
    } catch (error) {
        toast.error(error.message);
    } finally {
        isLoading.value = false;
    }
});

const verify = async () => {
    try {
        await apiFetch(
            "/theater_groups/" + props.id,
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

        toast.success("Theater group verified");
    } catch (error) {
        toast.error(error.message);
    }
};
</script>

<template>
    <section class="flex flex-col items-center justify-center">
        <h1 class="text-xl">Theater group</h1>
        <router-link to="/admin/theater-groups">Back</router-link>
        <button @click="verify">Verify</button>
    </section>
</template>
