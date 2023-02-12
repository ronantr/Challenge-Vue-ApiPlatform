<template>
    <section>
        <div class="max-w-screen-xl px-4 py-8 mx-auto sm:px-6 sm:py-12 lg:px-8">
            <header>
                <h2 class="text-xl font-bold text-gray-900 sm:text-3xl">
                    Liste des événements
                </h2>
            </header>

            <div class="flex items-center justify-between mt-8">
                <div>
                    <label for="SortBy" class="sr-only">Trier par</label>

                    <select id="SortBy" class="h-10 text-sm border-gray-300 rounded">
                        <option>Trier par</option>
                        <option value="Title, DESC">Titre, DESC</option>
                        <option value="Title, ASC">Titre, ASC</option>
                        <option value="Price, DESC">Prix, DESC</option>
                        <option value="Price, ASC">Prix, ASC</option>
                    </select>
                </div>
            </div>

            <ul class="grid gap-4 mt-4 sm:grid-cols-2 lg:grid-cols-4">
                <li v-for="event in events">
                    <TheatherCard :event="event"/>
                    <button @click="addToCart(item)">Add to Cart</button>
                </li>
            </ul>
        </div>
    </section>
</template>

<script setup>
import { onBeforeMount, ref } from "vue";
import TheatherCard from "../../components/TheatherCard.vue";
import { apiFetch } from "../../utils/apiFetch";

const events = ref([]);
const addToCart = (item) => {
    console.log(item);
};

const fetchEvents = async () => {
    const response = await apiFetch("events");
    events.value = await response.data["hydra:member"]
};


fetchEvents();


</script>