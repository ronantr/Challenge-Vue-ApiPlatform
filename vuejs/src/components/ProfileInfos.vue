<template>
    <!-- component -->
    <link rel="stylesheet" href="https://demos.creative-tim.com/notus-js/assets/styles/tailwind.css">
    <link rel="stylesheet"
        href="https://demos.creative-tim.com/notus-js/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">

    <main class="profile-page">
        <section class="relative block h-500-px">
            <div class="absolute top-0 w-full h-full bg-center bg-cover" style="
            background-image: url('https://images.unsplash.com/photo-1499336315816-097655dcfbda?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=2710&amp;q=80');
          ">
                <span id="blackOverlay" class="w-full h-full absolute opacity-50 bg-black"></span>
            </div>
            <div class="top-auto bottom-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden h-70-px"
                style="transform: translateZ(0px)">
                <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg"
                    preserveAspectRatio="none" version="1.1" viewBox="0 0 2560 100" x="0" y="0">
                    <polygon class="text-blueGray-200 fill-current" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </section>
        <section class="relative py-16 bg-blueGray-200">
            <div class="container mx-auto px-4">
                <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-xl rounded-lg -mt-64">
                    <div class="px-6">
                        <div class="flex flex-wrap justify-center">
                            <div class="w-full lg:w-3/12 px-4 lg:order-2 flex justify-center">
                                <div class="relative">
                                    <img alt="..."
                                        src="https://demos.creative-tim.com/notus-js/assets/img/team-2-800x800.jpg"
                                        class="shadow-xl rounded-full h-auto align-middle border-none absolute -m-16 -ml-20 lg:-ml-16 max-w-150-px">
                                </div>
                            </div>
                            <div class="w-full lg:w-4/12 px-4 lg:order-3 lg:text-right lg:self-center">
                                <div class="py-6 px-3 mt-32 sm:mt-0">
                                    <CreditFormModal />
                                </div>
                            </div>
                            <div class="w-full lg:w-4/12 px-4 lg:order-1">
                                <div class="flex justify-center py-4 lg:pt-4 pt-8">
                                    <div class="mr-4 p-3 text-center">
                                        <span
                                            class="text-xl font-bold block uppercase tracking-wide text-blueGray-600">{{
                                                currentUser.credit
                                            }}€</span><span class="text-sm text-blueGray-400">Crédits</span>
                                    </div>
                                    <div class="mr-4 p-3 text-center">
                                        <span
                                            class="text-xl font-bold block uppercase tracking-wide text-blueGray-600">{{
                                                currentUser.points
                                            }}</span><span class="text-sm text-blueGray-400">Points</span>
                                    </div>
                                    <div class="lg:mr-4 p-3 text-center">
                                        <span
                                            class="text-xl font-bold block uppercase tracking-wide text-blueGray-600">{{
                                                currentUser.level.split('/')[2]
                                            }}</span><span class="text-sm text-blueGray-400">Niveau</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-2">
                            <h3 class="text-4xl font-semibold leading-normal mb-2 text-blueGray-700 mb-2">
                                {{ currentUser.lastName.toUpperCase() }} {{ currentUser.firstName }}
                            </h3>
                            <div class="text-sm leading-normal mt-0 mb-2 text-blueGray-400 font-bold uppercase">
                                {{ currentUser.email }}
                            </div>
                        </div>
                        <div class="flex flex-wrap items-center md:justify-between my-10 justify-center">
                            <div class="w-full px-4 mx-auto text-center">
                                <div class="relative overflow-hidden">
                                    <div class="relative z-10 flex items-center justify-center h-48 bg-gray-800 rounded-lg">
                                        <h1 class="text-white text-lg font-medium">Récement vu</h1>
                                    </div>
                                    <div class="relative z-0 my-10">
                                        <div class="overflow-x-auto">
                                            <TheatherCard />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="relative overflow-hidden">
                            <div class="relative z-10 flex items-center justify-center h-48 bg-gray-800 rounded-lg">
                                <h1 class="text-white text-lg font-medium">Mes billets</h1>
                            </div>
                            <div class="relative z-0">
                                <div class="overflow-x-auto">
                                    <UserTickets />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="relative bg-blueGray-200 pt-8 pb-6 mt-8">
            </footer>
        </section>
    </main>

</template>

<script setup>
import { computed } from "vue";
import { useRouter } from "vue-router";
import { storeToRefs } from "pinia";
import { useAuthStore } from "../stores";
import { useToast } from "vue-toastification";
import TheatherCard from "./TheatherCard.vue";
import UserTickets from "./UserTickets.vue";
import CreditFormModal from "./CreditFormModal.vue";


const toast = useToast();

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