<template>
    <div class="container">
        <div class="row">
            <div class="inline-block m-5" v-for="order in orders" :key="order.id">
                <div class="relative h-64">
                    <img class="object-cover h-full w-64"
                        src="https://img.freepik.com/vecteurs-premium/ticket-cinema_1459-2366.jpg?w=2000" alt="" />
                </div>
                <div class="text-center mt-2">
                    <p class="text-gray-500">Date de commande: {{ formatDate(order.date) }}</p>
                    <p class="text-gray-500">Montant: {{ order.amount }}€</p>
                    <p class="text-gray-500">
                        Statut: 
                        <span class="text-red-400" v-if="order.status === 'failed'">Echoué</span>
                        <span class="text-orange-400" v-else-if="order.status === 'cancelled'">Annulé</span>
                        <span class="text-green-600" v-else>Réservé</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { computed } from "vue";
import { useRouter } from "vue-router";
import { storeToRefs } from "pinia";
import { useAuthStore } from "../stores";
import { ref } from "vue";

const authStore = useAuthStore();
const router = useRouter();
const currentUser = computed(() => {
    const { user } = storeToRefs(authStore);
    return user.value;
});

if (!currentUser.value) {
    router.push("/login");
}

export default {
    
    computed: {
        computedOrders() {
            return this.orders.value;
        }
    },
    setup() {
        
        const orders = ref([
            {
                "@id": "/orders/41",
                "@type": "Order",
                "id": 41,
                "customer": "/users/2218",
                "amount": 25,
                "date": "2023-02-27T09:03:39+00:00",
                "status": "failed",
                "tickets": [
                    "/tickets/55"
                ]
            },
            {
                "@id": "/orders/42",
                "@type": "Order",
                "id": 42,
                "customer": "/users/2218",
                "amount": 72,
                "date": "2023-03-18T23:40:04+00:00",
                "status": "cancelled",
                "tickets": [
                    "/tickets/53",
                    "/tickets/60"
                ]
            },
            {
                "@id": "/orders/43",
                "@type": "Order",
                "id": 43,
                "customer": "/users/2218",
                "amount": 96,
                "date": "2023-04-08T03:37:59+00:00",
                "status": "reserved",
                "tickets": [
                    "/tickets/50",
                    "/tickets/54"
                ]
            },
            {
                "@id": "/orders/44",
                "@type": "Order",
                "id": 44,
                "customer": "/users/2218",
                "amount": 20,
                "date": "2023-04-06T05:31:56+00:00",
                "status": "reserved",
                "tickets": []
            },
            {
                "@id": "/orders/45",
                "@type": "Order",
                "id": 45,
                "customer": "/users/2218",
                "amount": 51,
                "date": "2023-04-07T00:26:20+00:00",
                "status": "failed",
                "tickets": [
                    "/tickets/45"
                ]
            },
            {
                "@id": "/orders/46",
                "@type": "Order",
                "id": 46,
                "customer": "/users/2218",
                "amount": 39,
                "date": "2023-04-05T16:34:04+00:00",
                "status": "cancelled",
                "tickets": [
                    "/tickets/46"
                ]
            }
        ]);
        function formatDate(date) {
            const options = { year: 'numeric', month: '2-digit', day: '2-digit' };
            return new Date(date).toLocaleDateString("fr-FR", options);
        }
        return { orders, formatDate };

    }
    
};


</script>