<template>
    <div class="inline-block m-5">
        <div class="relative h-64">
            <img class="object-cover h-full w-64"
                src="https://d1k4bi32qf3nf2.cloudfront.net/thumb@3x/product/2022/12/ladelicatesse_1671639392.jpg.webp"
                alt="" />
        </div>
        <div class="text-center mt-2">
            <p class="text-black">La délicatesse</p>
            <p class="text-gray-500">Durée : 1 heure 15 minutes</p>
            <p class="text-blue-400">15€</p>
        </div>
    </div>
</template>

<script>
import { computed } from "vue";
import { useRouter } from "vue-router";
import { storeToRefs } from "pinia";
import { useAuthStore } from "../stores";

const authStore = useAuthStore();
const router = useRouter();
const currentUser = computed(() => {
    const { user } = storeToRefs(authStore);
    return user.value;
});

if (!currentUser.value) {
    router.push("/login");
}

console.log("test", currentUser.value);
</script>