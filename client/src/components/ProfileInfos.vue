<template>
    <div class="flex">
        <div class="w-1/3">
            <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="Profile Picture"
                class="w-32 h-32 rounded-lg mx-auto mb-6" />
        </div>
        <div class="w-2/3 p-4">
            <h3 class="text-lg font-medium text-gray-700 mb-2">
                {{ currentUser.lastname }} {{ currentUser.firstname }}
            </h3>
            <p class="text-gray-700 font-medium mb-2">
                {{ currentUser.email }}
            </p>
            <h3 class="text-lg font-medium text-gray-700 mb-2">
                Votre crédit :
                <p class="text-red-400 font-medium">
                    {{ currentUser.credit }}€
                </p>
            </h3>
        </div>
    </div>

</template>

<script setup>
import { computed } from "vue";
import { useRouter } from "vue-router";
import { storeToRefs } from "pinia";
import { useAuthStore } from "../stores";
import { useToast } from "vue-toastification";


const toast = useToast();

const authStore = useAuthStore();
const router = useRouter();
const currentUser = computed(() => {
    const { user } = storeToRefs(authStore);
    return user.value;
});


if (!currentUser.value) {
    router.push("/login");
}

// toast.success(`Bienvenue, ${currentUser.firstname}`);


</script>