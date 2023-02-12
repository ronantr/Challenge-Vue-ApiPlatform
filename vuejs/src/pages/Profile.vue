<template>
    <div class="container mx-auto">
        <ProfileInfos />
    </div>
</template>

<script setup>
import CreditFormModal from "../components/CreditFormModal.vue";
import { computed } from "vue";
import { useRouter } from "vue-router";
import { storeToRefs } from "pinia";
import { useAuthStore } from "../stores";
import TheatherCard from "../components/TheatherCard.vue";
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
