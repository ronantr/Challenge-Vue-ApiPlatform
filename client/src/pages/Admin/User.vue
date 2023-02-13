<script setup>
import { ref, onMounted } from "vue";
import { useToast } from "vue-toastification";
import { apiFetch } from "../../utils/apiFetch";

const props = defineProps({
    userId: {
        type: Number,
        required: true,
    },
});

const user = ref({});
const isLoading = ref(true);
const toast = useToast();

onMounted(async () => {
    try {
        const { data } = await apiFetch("/users/" + props.userId);

        user.value = data;
    } catch (error) {
        toast.error(error.message);
    } finally {
        isLoading.value = false;
    }
});
</script>

<template>
    <section
        v-if="!isLoading"
        class="flex flex-col items-center justify-center gap-3"
    >
        <h1 class="text-xl">User</h1>
        <router-link to="/admin/users">Back</router-link>
        <div class="flex flex-col gap-3">
            <h2>Informations</h2>
            <div class="flex flex-col gap-3">
                <div class="flex flex-col gap-1">
                    <div class="text-lg">Prénom</div>
                    <div>{{ user.firstName }}</div>
                </div>
                <div class="flex flex-col gap-1">
                    <div class="text-lg">Nom</div>
                    <div>{{ user.lastName }}</div>
                </div>
                <div class="flex flex-col gap-1">
                    <div class="text-lg">Email</div>
                    <div>{{ user.email }}</div>
                </div>
            </div>
        </div>
        <div class="flex flex-col gap-3">
            <h2>Transactions</h2>
            <ul class="flex flex-col gap-1">
                <li>
                    <div>Transaction #1</div>
                    <div>Transaction #2</div>
                    <div>Transaction #3</div>
                </li>
            </ul>
        </div>
    </section>
</template>
