<script setup>

import { computed, ref, onMounted } from "vue";
import { apiFetch } from "../utils/apiFetch";
import { useToast } from "vue-toastification";

const tickets = ref({
    
});

</script>

<template>
    <div>
        <div v-for="ticket in tickets" :key="ticket.id">
            <div class="inline-block m-5">
                <div class="relative h-64">
                    <img class="object-cover h-full w-64"
                        :src="ticket.image"
                        alt="" />
                </div>
                <div class="text-center mt-2">
                    <p class="text-black">{{ ticket.name }}</p>
                    <p class="text-gray-500">Durée : {{ ticket.duration }}</p>
                    <p class="text-blue-400">{{ ticket.price }}€</p>
                </div>
            </div>
        </div>
    </div>
</template>