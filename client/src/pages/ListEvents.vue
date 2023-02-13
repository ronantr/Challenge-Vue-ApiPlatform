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

                    <select
                        id="SortBy"
                        class="h-10 text-sm border-gray-300 rounded"
                    >
                        <option>Trier par</option>
                        <option value="Title, DESC">Titre, DESC</option>
                        <option value="Title, ASC">Titre, ASC</option>
                        <option value="Price, DESC">Prix, DESC</option>
                        <option value="Price, ASC">Prix, ASC</option>
                    </select>
                </div>
            </div>

            <ul class="grid gap-4 mt-4 sm:grid-cols-2 lg:grid-cols-4">
                <li v-for="event in events" :key="event.id">
                    <TheaterCard :event="event" />
                    <button
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                        @click="addToCart(event)"
                    >
                        Ajouter au panier
                    </button>
                </li>
            </ul>
        </div>
    </section>
</template>

<script setup>
import { onBeforeMount, ref } from "vue";
import { useCartStore } from "../stores/cartStore";
import TheaterCard from "../components/TheatherCard.vue";
import { apiFetch } from "../utils/apiFetch";

const events = ref([]);
const { addToCart } = useCartStore();
// const cart = JSON.parse(localStorage.getItem("cart")) || [];
// const addToCart = (item) => {
//     item.price = 25;
//     //add to cart array in local storage
//     const itemAlreadyExist = cart.find((i) => i.id === item.id);
//     if (itemAlreadyExist) {
//         itemAlreadyExist.quantity++;
//         localStorage.setItem("cart", JSON.stringify(cart));
//         return;
//     }
//     cart.push({...item, quantity: 1});
//     localStorage.setItem("cart", JSON.stringify(cart));
// };

const fetchEvents = async () => {
    const response = await apiFetch("events");
    events.value = await response.data["hydra:member"];
};

fetchEvents();
</script>
