<template>
        <a href="#" class="block overflow-hidden group">
            <img :src="props.event.image"
                alt=""
                class="h-[350px] w-full object-cover transition duration-500 group-hover:scale-105 sm:h-[450px]" />
        </a>
        <div class="relative pt-3 bg-white">
            <h3 class="text-xl text-gray-700 group-hover:underline group-hover:underline-offset-4">
                {{ props.event.name }}
            </h3>

            <p class="mt-2">
                <span class="sr-only"> {{ props.event.date }}</span>

                <span class="tracking-wider text-sm text-gray-900">Capacité : {{ props.event.capacity }} personnes</span>
            </p>
        </div>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
    event: {
        type: Object,
        required: true,
    },
});

</script>