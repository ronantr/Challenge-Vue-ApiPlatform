<template>
    <div class="inline-block m-5">
        <div class="relative h-64">
            <img class="object-cover h-full w-64"
                src="https://fr.web.img6.acsta.net/pictures/22/05/10/16/46/2110017.jpg"
                alt="The Shawshank Redemption" />
        </div>
        <div class="text-center mt-2">
            <p class="text-black">Shark Bay</p>
            <p class="text-gray-500">2022</p>
            <p class="text-blue-400">15€</p>
        </div>
    </div>
    <div class="inline-block m-5">
        <div class="relative h-64">
            <img class="object-cover h-full w-64"
                src="https://c8.alamy.com/compfr/cb6d8e/le-parrain-1972-poster-godf-001vs-moviestore-collection-ltd-cb6d8e.jpg"
                alt="The Godfather" />
        </div>
        <div class="text-center mt-2">
            <p class="text-black">The Godfather</p>
            <p class="text-gray-500">1972</p>
            <p class="text-blue-400">15€</p>
        </div>
    </div>
    <div class="inline-block m-5">
        <div class="relative h-64">
            <img class="object-cover h-full w-64"
                src="https://fr.web.img2.acsta.net/medias/nmedia/18/63/97/89/18949761.jpg" alt="The Dark Knight" />
        </div>
        <div class="text-center mt-2">
            <p class="text-black">The Dark Knight</p>
            <p class="text-gray-500">2008</p>
            <p class="text-blue-400">20€</p>
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

// get orders of the current user
const orders = computed(() => {
    const { orders } = storeToRefs(authStore);
    // return orders.value;
    console.log(orders.value);
});

// get movies of the current user

</script>