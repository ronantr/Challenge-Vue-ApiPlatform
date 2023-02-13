<template>
    <div class="container mx-auto">
        <ProfileInfos />
        <CreditFormModal />
        <section class="bg-gray-100 p-6 rounded-lg">
            <div class="relative overflow-hidden">
                <div class="relative z-10 flex items-center justify-center h-48 bg-gray-800">
                    <h1 class="text-white text-lg font-medium">Mes billets</h1>
                </div>
                <div class="relative z-0">
                    <div class="overflow-x-auto">
                        <UserTickets />
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import CreditFormModal from "../components/CreditFormModal.vue";
import { computed } from "vue";
import { useRouter } from "vue-router";
import { storeToRefs } from "pinia";
import { useAuthStore } from "../stores";
import ProfileInfos from "../components/ProfileInfos.vue";
import UserTickets from "../components/UserTickets.vue";

const authStore = useAuthStore();
const router = useRouter();
const currentUser = computed(() => {
    const { user } = storeToRefs(authStore);
    return user.value;
});

if (!currentUser.value) {
    router.push("/login");
}


</script>
