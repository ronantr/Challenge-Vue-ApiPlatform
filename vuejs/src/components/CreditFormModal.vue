<template>
    <div class="container mx-auto">
        <div class="flex justify-center">
            <button
                @click="openModal"
                class="px-6 py-2 text-white bg-blue-600 rounded shadow mb-4"
                type="button"
            >
                Ajouter du crédit
            </button>

            <div
                v-show="isOpen"
                class="absolute inset-0 flex items-center justify-center bg-gray-700 bg-opacity-80"
            >
                <div class="relative w-full h-full max-w-md md:h-auto z-50">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow">
                        <button
                            @click="closeModal"
                            type="button"
                            class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                            data-modal-hide="authentication-modal"
                        >
                            <svg
                                aria-hidden="true"
                                class="w-5 h-5"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                        <div class="px-6 py-6 lg:px-8">
                            <h3
                                class="mb-4 text-xl font-medium text-gray-900 dark:text-black"
                            >
                                Ajouter du crédit
                            </h3>
                            <form
                                class="space-y-6"
                                @submit.prevent="handleSubmit"
                            >
                                <div>
                                    <label for="amount">Montant</label>
                                    <input
                                        type="number"
                                        name="amount"
                                        v-model="amount"
                                        class="block w-full max-w-xs mx-auto bg-gray-100 border-transparent rounded-lg px-3 py-3 font-semibold text-gray-700 focus:border-gray-500 focus:bg-white focus:ring-0"
                                    />
                                </div>
                                <label for="card-element">
                                    Credit or debit card
                                </label>
                                <div id="card-element"></div>

                                <div>
                                    <button
                                        class="block w-full max-w-xs mx-auto bg-indigo-500 hover:bg-indigo-700 focus:bg-indigo-700 text-white rounded-lg px-3 py-3 font-semibold"
                                    >
                                        <i
                                            class="mdi mdi-lock-outline mr-1"
                                        ></i>
                                        PAY NOW
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { axios } from "../libs";
import { loadStripe } from "@stripe/stripe-js";
import { onMounted, ref } from "vue";
import { storeToRefs } from "pinia";
import { useAuthStore } from "../stores";

const authStore = useAuthStore();
const { user } = storeToRefs(authStore);

const isOpen = ref(false);
let stripe;
const amount = ref(null);

let cardElement = null;
onMounted(async () => {
    stripe = await loadStripe(import.meta.env.VITE_APP_STRIPE_PUBLIC_KEY);
    cardElement = stripe.elements().create("card");
    cardElement.mount("#card-element");
});

const openModal = () => {
    console.log("openModal");
    isOpen.value = true;
};

const closeModal = () => {
    console.log("closeModal");
    isOpen.value = false;
};
const resetForm = () => {
    amount.value = null;
    cardElement.clear();
};
async function handleSubmit() {
    console.log("handlePayment");
    console.log("cardElement", cardElement);

    try {
        const { token } = await stripe.createToken(cardElement);
        // Send the token, user ID, and amount to the API endpoint
        // const response = await axios.post(`${user.value["@id"]}/payment/pay`, {
        //     token: token.id,
        //     amount: amount.value,
        // });
        const response = await axios.post("transactions", {
            token: token.id,
            user: user.value["@id"],
            amount: amount.value,
        });
        // Handle successful response
        if (response.status === 200) {
            // Show success message
            console.log("Payment succeeded");
            closeModal();
            resetForm();
        }
    } catch (error) {
        // Handle error
        console.log(error);
    }
}
</script>
