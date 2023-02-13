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

        toast.success("Groupe de théâtre vérifié");
    } catch (error) {
        toast.error(error.message);
    }
}

const source = computed(
    () => import.meta.env.VITE_API_URL + theaterGroup.value?.contentUrl
);
</script>

<template>
    <section v-if="!isLoading" class="flex flex-col items-center justify-center mt-40 mb-40">
        <div class="w-full max-w-lg bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-4 bg-gray-100 border-b">
                <h1 class="text-xl">{{ theaterGroup.name }}</h1>
            </div>
            <div class="p-4">
                <div class="flex flex-row gap-3 mb-4">
                    <div class="flex flex-col gap-1">
                        <div class="text-lg">Nom</div>
                        <div>{{ theaterGroup.name }}</div>
                    </div>
                    <div class="flex flex-col gap-1">
                        <div class="text-lg">Numéro de téléphone</div>
                        <div>{{ theaterGroup.phoneNumber }}</div>
                    </div>
                    <div class="flex flex-col gap-1">
                        <div class="text-lg">Status</div>
                        <div :class="{'text-orange-500': theaterGroup.status === 'pending', 'text-red-500': theaterGroup.status === 'cancelled', 'text-green-500': theaterGroup.status === 'reserved'}">{{ theaterGroup.status }}</div>
                    </div>

                </div>
                <div class="relative h-0" style="padding-bottom: 56.25%;">
                    <iframe :src="source" class="absolute top-0 left-0 w-full h-full"></iframe>
                </div>
                <div class="flex justify-center mt-4">
                    <a :href="source" target="_blank"
                        class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue active:bg-blue-800">
                        Télécharger
                    </a>
                    <button @click="verify"
                        class="ml-4 px-4 py-2 text-white bg-green-500 rounded-lg hover:bg-green-700 focus:outline-none focus:shadow-outline-green active:bg-green-800">
                        Vérifier
                    </button>
                </div>
            </div>
            <div class="p-4 bg-gray-100 border-t flex justify-end">
                <router-link to="/admin/theater-groups">Retour</router-link>
            </div>
        </div>
    </section>
</template>
  
