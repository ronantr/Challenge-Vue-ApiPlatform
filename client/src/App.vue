<script setup>
import { computed } from "vue";
import { useAuthStore } from "./stores";
import { storeToRefs } from "pinia";
import { useCartStore } from "./stores/cartStore";

const cart = useCartStore();

const authStore = useAuthStore();
const { logout } = authStore;
const { user, isAuthenticated, isAttempted } = storeToRefs(authStore);

const theaterGroupLink = computed(() => {
    if (!user.value.theaterGroup) {
        return null;
    }

    return `/theater-group/${user.value.theaterGroup["@id"].split("/").pop()}`;
});
</script>

<template>
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@mdi/font@5.8.55/css/materialdesignicons.min.css"
    />
    <Transition>
        <div v-if="isAttempted">
            <nav class="bg-gray-800 px-2">
                <div class="container mx-auto flex items-center justify-between px-4 py-3">
                    <div class="flex">
                        <div class="ml-4">
                            <router-link
                                to="/"
                                class="text-white hover:text-gray-500"
                            >
                                <!-- TODO: revoir le logo dans la nav -->
                                <div
                                    class="flex items-center justify-center w-10 h-10 rounded-full dark:bg-violet-400"
                                >
                                    <svg
                                        data-v-423bf9ae=""
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 337 90"
                                        class="footer-logo"
                                    >
                                        <!---->
                                        <defs data-v-423bf9ae="">
                                            <linearGradient
                                                data-v-423bf9ae=""
                                                gradientTransform="rotate(25)"
                                                id="529cf020-644b-460e-be69-2085fa83c783"
                                                x1="0%"
                                                y1="0%"
                                                x2="100%"
                                                y2="0%"
                                            >
                                                <stop
                                                    data-v-423bf9ae=""
                                                    offset="0%"
                                                    style="
                                                        stop-color: rgb(
                                                            24,
                                                            36,
                                                            113
                                                        );
                                                        stop-opacity: 1;
                                                    "
                                                ></stop>
                                                <stop
                                                    data-v-423bf9ae=""
                                                    offset="100%"
                                                    style="
                                                        stop-color: rgb(
                                                            38,
                                                            100,
                                                            200
                                                        );
                                                        stop-opacity: 1;
                                                    "
                                                ></stop>
                                            </linearGradient>
                                        </defs>
                                        <!---->
                                        <g
                                            data-v-423bf9ae=""
                                            id="8f499a8d-7cc5-4698-9164-033de71d5f75"
                                            fill="#fff"
                                            transform="matrix(4.909983142910657,0,0,4.909983142910657,113.76551967632193,-3.7561350397233895)"
                                        >
                                            <path
                                                d="M4.54 13.50L4.54 4.68L7.84 4.68L7.84 3.82L0.35 3.82L0.35 4.68L3.63 4.68L3.63 13.50ZM9.65 13.50L9.65 9.90C9.65 9.16 9.74 8.58 10.02 8.13C10.30 7.69 10.98 7.14 11.94 7.14C12.63 7.14 13.08 7.34 13.36 7.64C13.64 7.95 13.83 8.47 13.83 9.45L13.83 13.50L14.70 13.50L14.70 9.35C14.70 8.23 14.52 7.62 14.22 7.21C13.80 6.64 13.13 6.34 12.18 6.34C10.95 6.34 9.94 7.03 9.65 7.90L9.65 3.82L8.81 3.82L8.81 13.50ZM23.10 11.38L22.27 11.20C22.02 12.15 21.18 12.88 19.92 12.88C18.89 12.88 17.40 12.32 17.39 10.19L23.13 10.19C23.13 7.62 21.91 6.33 19.85 6.33C17.99 6.33 16.49 7.71 16.49 9.97C16.49 12.19 17.72 13.66 19.89 13.66C21.60 13.66 22.76 12.71 23.10 11.38ZM17.39 9.51C17.53 7.91 18.59 7.11 19.84 7.11C21.50 7.11 22.13 8.19 22.23 9.51ZM31.08 13.48L31.00 12.78C30.87 12.81 30.73 12.82 30.56 12.82C30.34 12.82 30.17 12.74 30.06 12.53C29.96 12.36 29.95 12.05 29.95 11.69L29.95 9.30C29.95 8.72 29.95 8.22 29.81 7.76C29.53 6.78 28.73 6.33 27.38 6.33C25.42 6.33 24.44 7.22 24.44 8.83L25.26 8.88C25.31 7.29 26.36 7.13 27.33 7.13C28.39 7.13 28.77 7.60 28.95 7.98C29.05 8.20 29.12 8.71 29.12 9.20L29.12 9.49L28.29 9.49C26.61 9.49 25.66 9.69 25.07 10.01C24.49 10.33 24.16 10.88 24.16 11.62C24.16 12.84 25.05 13.66 26.66 13.66C27.68 13.66 28.73 13.27 29.16 12.36C29.22 13.06 29.46 13.58 30.37 13.58C30.58 13.58 30.87 13.55 31.08 13.48ZM29.12 10.18L29.12 10.89C29.12 11.17 29.05 11.61 28.88 11.91C28.63 12.35 27.94 12.92 26.78 12.92C25.90 12.92 25.00 12.57 25.00 11.56C25.00 11.00 25.34 10.63 25.83 10.46C26.35 10.28 27.17 10.18 28.31 10.18ZM33.12 13.50L33.12 3.82L32.28 3.82L32.28 13.50ZM38.58 13.44L38.40 12.73C38.21 12.81 37.86 12.89 37.51 12.89C36.99 12.89 36.72 12.67 36.61 12.32C36.54 12.08 36.53 11.70 36.53 11.20L36.53 7.24L38.30 7.24L38.30 6.51L36.53 6.51L36.53 4.62L35.67 4.62L35.67 6.51L34.58 6.51L34.58 7.24L35.67 7.24L35.67 11.27C35.67 11.84 35.69 12.26 35.80 12.68C35.99 13.38 36.61 13.66 37.31 13.66C37.83 13.66 38.28 13.57 38.58 13.44ZM39.02 15.90C39.21 15.97 39.63 16.04 39.94 16.04C40.70 16.04 41.33 15.85 41.82 15.05C42.20 14.45 42.49 13.68 42.70 13.17L45.42 6.51L44.49 6.51C42.74 10.88 42.46 11.59 42.20 12.32C41.94 11.68 41.71 11.09 39.72 6.51L38.75 6.51L41.72 13.27L41.55 13.65C41.36 14.11 41.09 14.62 40.92 14.83C40.73 15.09 40.42 15.26 39.97 15.26C39.76 15.26 39.41 15.20 39.19 15.12Z"
                                            ></path>
                                        </g>
                                        <!---->
                                        <g
                                            data-v-423bf9ae=""
                                            id="0a380221-10ca-47b5-8ca3-1635412c98bf"
                                            transform="matrix(1.1281589388469204,0,0,1.1281589388469204,-7.726390007383813,-11.29594324926434)"
                                            stroke="none"
                                            fill="#fff"
                                        >
                                            <path
                                                d="M68.86 40.432c-11.74 0-23.532-3.731-23.532-3.731v41.363c-.02-.981 15.67 11.824 23.506 11.824 7.854 0 23.484-11.824 23.484-11.824V36.7c.001 0-11.714 3.732-23.458 3.732zM49.403 52.379h3.626c0 1.054 1.807 2.236 4.227 2.236 2.421 0 4.226-1.183 4.226-2.236h3.622c0 3.285-3.443 5.862-7.848 5.862-4.401 0-7.853-2.577-7.853-5.862zm23.655 25.724c0-1.065-1.812-2.242-4.23-2.242-2.424 0-4.23 1.177-4.23 2.242h-3.62c0-3.285 3.447-5.867 7.851-5.867 4.406 0 7.85 2.582 7.85 5.867h-3.621zm7.711-19.862c-4.403 0-7.851-2.577-7.851-5.862h3.625c0 1.054 1.808 2.236 4.226 2.236 2.42 0 4.23-1.183 4.23-2.236h3.619c0 3.285-3.443 5.862-7.849 5.862z"
                                            ></path>
                                            <path
                                                d="M44.007 33.812c.07.027 4.554 1.428 10.664 2.487V10.112s-11.724 3.726-23.458 3.726c-11.744 0-23.532-3.726-23.532-3.726v41.363c-.017-.982 15.662 11.818 23.515 11.818 3.001 0 7.153-1.734 11.122-3.876v-26.13l1.689.525zm-28.632-2.16h-3.614c0-3.296 3.441-5.867 7.845-5.867s7.856 2.571 7.856 5.867h-3.625c0-1.064-1.807-2.242-4.23-2.242-2.419 0-4.232 1.178-4.232 2.242zm15.801 19.857c-4.403 0-7.848-2.577-7.848-5.868h3.614c0 1.061 1.816 2.248 4.233 2.248 2.423 0 4.23-1.188 4.23-2.248h3.625c.002 3.291-3.453 5.868-7.854 5.868zm7.714-19.857h-3.62c0-3.296 3.447-5.867 7.853-5.867 4.4 0 7.85 2.571 7.85 5.867H47.35c0-1.064-1.807-2.242-4.228-2.242-2.422 0-4.232 1.178-4.232 2.242z"
                                            ></path>
                                        </g>
                                        <!---->
                                    </svg>
                                </div>
                            </router-link>
                        </div>
                        <div class="mt-2 ml-12 mx-5">
                            <router-link
                                to="/about"
                                class="text-white hover:text-gray-500 ml-4"
                                >À propos de nous
                            </router-link>
                        </div>
                        <div class="mt-2 mx-5">
                            <router-link
                                to="/events"
                                class="text-white hover:text-gray-500"
                            >
                                <FontAwesomeIcon icon="cart-shopping" />
                                Evénements
                            </router-link>
                        </div>
                        <div class="mt-2 mx-5">
                            <router-link
                                to="/cart"
                                class="text-white hover:text-gray-500"
                            >
                                <FontAwesomeIcon icon="cart-shopping" /> Panier
                                <span
                                    v-if="cart.cartTotalItems() > 0"
                                    class="text-red-500"
                                >
                                    {{ cart.cartTotalItems() }}
                                </span>
                            </router-link>
                        </div>
                        <div v-if="user?.isAdmin" class="mt-2 mx-5">
                            <router-link
                                to="/admin"
                                class="text-white hover:text-gray-500"
                                >Admin Board</router-link
                            >
                        </div>
                    </div>
                    <div v-if="!isAuthenticated" class="ml-auto">
                        <div class="ml-4">
                            <router-link
                                to="/register"
                                class="text-white hover:text-gray-500"
                            >
                                <FontAwesomeIcon icon="user-plus" /> S'inscrire
                            </router-link>
                        </div>
                        <div class="ml-4">
                            <router-link
                                to="/login"
                                class="text-white hover:text-gray-500"
                            >
                                <FontAwesomeIcon icon="sign-in-alt" /> Se
                                connecter
                            </router-link>
                        </div>
                    </div>

                    <div v-if="isAuthenticated" class="ml-auto">
                        <div class="ml-4">
                            <router-link to="/profile" class="text-blue-500">
                                <FontAwesomeIcon icon="user" />
                                {{ user.email }}
                            </router-link>
                        </div>
                        <div class="ml-4" v-if="user?.theaterGroup">
                            <router-link
                                :to="theaterGroupLink"
                                class="text-blue-500"
                            >
                                <FontAwesomeIcon icon="user" />
                                {{ user.theaterGroup.name }}
                            </router-link>
                        </div>
                        <div class="ml-4">
                            <a class="text-blue-500" @click.prevent="logout">
                                <FontAwesomeIcon icon="sign-out-alt" /> Se
                                déconnecter
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
            <div>
                <router-view />
            </div>
        </div>
    </Transition>
    <!-- TODO: revoir footer fixe en bas : pb  position:fixed;-->
    <footer
        class="px-4 divide-y bg-gray-800 text-gray-100 relative bottom-0 left-0 right-0"
    >
        <div
            class="container flex flex-col justify-between py-10 mx-auto space-y-8 lg:flex-row lg:space-y-0">
            <div class="lg:w-1/3">
                <a
                    rel="noopener noreferrer"
                    href="/"
                    class="flex justify-center space-x-3 lg:justify-start"
                >
                    <div
                        class="flex items-center justify-center w-12 h-12 rounded-full dark:bg-violet-400"
                    >
                        <svg
                            data-v-423bf9ae=""
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 337 90"
                            class="footer-logo"
                        >
                            <!---->
                            <defs data-v-423bf9ae="">
                                <linearGradient
                                    data-v-423bf9ae=""
                                    gradientTransform="rotate(25)"
                                    id="529cf020-644b-460e-be69-2085fa83c783"
                                    x1="0%"
                                    y1="0%"
                                    x2="100%"
                                    y2="0%"
                                >
                                    <stop
                                        data-v-423bf9ae=""
                                        offset="0%"
                                        style="
                                            stop-color: rgb(24, 36, 113);
                                            stop-opacity: 1;
                                        "
                                    ></stop>
                                    <stop
                                        data-v-423bf9ae=""
                                        offset="100%"
                                        style="
                                            stop-color: rgb(38, 100, 200);
                                            stop-opacity: 1;
                                        "
                                    ></stop>
                                </linearGradient>
                            </defs>
                            <!---->
                            <g
                                data-v-423bf9ae=""
                                id="8f499a8d-7cc5-4698-9164-033de71d5f75"
                                fill="#fff"
                                transform="matrix(4.909983142910657,0,0,4.909983142910657,113.76551967632193,-3.7561350397233895)"
                            >
                                <path
                                    d="M4.54 13.50L4.54 4.68L7.84 4.68L7.84 3.82L0.35 3.82L0.35 4.68L3.63 4.68L3.63 13.50ZM9.65 13.50L9.65 9.90C9.65 9.16 9.74 8.58 10.02 8.13C10.30 7.69 10.98 7.14 11.94 7.14C12.63 7.14 13.08 7.34 13.36 7.64C13.64 7.95 13.83 8.47 13.83 9.45L13.83 13.50L14.70 13.50L14.70 9.35C14.70 8.23 14.52 7.62 14.22 7.21C13.80 6.64 13.13 6.34 12.18 6.34C10.95 6.34 9.94 7.03 9.65 7.90L9.65 3.82L8.81 3.82L8.81 13.50ZM23.10 11.38L22.27 11.20C22.02 12.15 21.18 12.88 19.92 12.88C18.89 12.88 17.40 12.32 17.39 10.19L23.13 10.19C23.13 7.62 21.91 6.33 19.85 6.33C17.99 6.33 16.49 7.71 16.49 9.97C16.49 12.19 17.72 13.66 19.89 13.66C21.60 13.66 22.76 12.71 23.10 11.38ZM17.39 9.51C17.53 7.91 18.59 7.11 19.84 7.11C21.50 7.11 22.13 8.19 22.23 9.51ZM31.08 13.48L31.00 12.78C30.87 12.81 30.73 12.82 30.56 12.82C30.34 12.82 30.17 12.74 30.06 12.53C29.96 12.36 29.95 12.05 29.95 11.69L29.95 9.30C29.95 8.72 29.95 8.22 29.81 7.76C29.53 6.78 28.73 6.33 27.38 6.33C25.42 6.33 24.44 7.22 24.44 8.83L25.26 8.88C25.31 7.29 26.36 7.13 27.33 7.13C28.39 7.13 28.77 7.60 28.95 7.98C29.05 8.20 29.12 8.71 29.12 9.20L29.12 9.49L28.29 9.49C26.61 9.49 25.66 9.69 25.07 10.01C24.49 10.33 24.16 10.88 24.16 11.62C24.16 12.84 25.05 13.66 26.66 13.66C27.68 13.66 28.73 13.27 29.16 12.36C29.22 13.06 29.46 13.58 30.37 13.58C30.58 13.58 30.87 13.55 31.08 13.48ZM29.12 10.18L29.12 10.89C29.12 11.17 29.05 11.61 28.88 11.91C28.63 12.35 27.94 12.92 26.78 12.92C25.90 12.92 25.00 12.57 25.00 11.56C25.00 11.00 25.34 10.63 25.83 10.46C26.35 10.28 27.17 10.18 28.31 10.18ZM33.12 13.50L33.12 3.82L32.28 3.82L32.28 13.50ZM38.58 13.44L38.40 12.73C38.21 12.81 37.86 12.89 37.51 12.89C36.99 12.89 36.72 12.67 36.61 12.32C36.54 12.08 36.53 11.70 36.53 11.20L36.53 7.24L38.30 7.24L38.30 6.51L36.53 6.51L36.53 4.62L35.67 4.62L35.67 6.51L34.58 6.51L34.58 7.24L35.67 7.24L35.67 11.27C35.67 11.84 35.69 12.26 35.80 12.68C35.99 13.38 36.61 13.66 37.31 13.66C37.83 13.66 38.28 13.57 38.58 13.44ZM39.02 15.90C39.21 15.97 39.63 16.04 39.94 16.04C40.70 16.04 41.33 15.85 41.82 15.05C42.20 14.45 42.49 13.68 42.70 13.17L45.42 6.51L44.49 6.51C42.74 10.88 42.46 11.59 42.20 12.32C41.94 11.68 41.71 11.09 39.72 6.51L38.75 6.51L41.72 13.27L41.55 13.65C41.36 14.11 41.09 14.62 40.92 14.83C40.73 15.09 40.42 15.26 39.97 15.26C39.76 15.26 39.41 15.20 39.19 15.12Z"
                                ></path>
                            </g>
                            <!---->
                            <g
                                data-v-423bf9ae=""
                                id="0a380221-10ca-47b5-8ca3-1635412c98bf"
                                transform="matrix(1.1281589388469204,0,0,1.1281589388469204,-7.726390007383813,-11.29594324926434)"
                                stroke="none"
                                fill="#fff"
                            >
                                <path
                                    d="M68.86 40.432c-11.74 0-23.532-3.731-23.532-3.731v41.363c-.02-.981 15.67 11.824 23.506 11.824 7.854 0 23.484-11.824 23.484-11.824V36.7c.001 0-11.714 3.732-23.458 3.732zM49.403 52.379h3.626c0 1.054 1.807 2.236 4.227 2.236 2.421 0 4.226-1.183 4.226-2.236h3.622c0 3.285-3.443 5.862-7.848 5.862-4.401 0-7.853-2.577-7.853-5.862zm23.655 25.724c0-1.065-1.812-2.242-4.23-2.242-2.424 0-4.23 1.177-4.23 2.242h-3.62c0-3.285 3.447-5.867 7.851-5.867 4.406 0 7.85 2.582 7.85 5.867h-3.621zm7.711-19.862c-4.403 0-7.851-2.577-7.851-5.862h3.625c0 1.054 1.808 2.236 4.226 2.236 2.42 0 4.23-1.183 4.23-2.236h3.619c0 3.285-3.443 5.862-7.849 5.862z"
                                ></path>
                                <path
                                    d="M44.007 33.812c.07.027 4.554 1.428 10.664 2.487V10.112s-11.724 3.726-23.458 3.726c-11.744 0-23.532-3.726-23.532-3.726v41.363c-.017-.982 15.662 11.818 23.515 11.818 3.001 0 7.153-1.734 11.122-3.876v-26.13l1.689.525zm-28.632-2.16h-3.614c0-3.296 3.441-5.867 7.845-5.867s7.856 2.571 7.856 5.867h-3.625c0-1.064-1.807-2.242-4.23-2.242-2.419 0-4.232 1.178-4.232 2.242zm15.801 19.857c-4.403 0-7.848-2.577-7.848-5.868h3.614c0 1.061 1.816 2.248 4.233 2.248 2.423 0 4.23-1.188 4.23-2.248h3.625c.002 3.291-3.453 5.868-7.854 5.868zm7.714-19.857h-3.62c0-3.296 3.447-5.867 7.853-5.867 4.4 0 7.85 2.571 7.85 5.867H47.35c0-1.064-1.807-2.242-4.228-2.242-2.422 0-4.232 1.178-4.232 2.242z"
                                ></path>
                            </g>
                            <!---->
                        </svg>
                    </div>
                </a>
            </div>
            <div
                class="grid grid-cols-2 text-sm gap-x-3 gap-y-8 lg:w-2/3 sm:grid-cols-4"
            >
                <div class="space-y-3">
                    <h3 class="tracking-wide uppercase dark:text-gray-50">
                        Informations légales
                    </h3>
                    <ul class="space-y-1">
                        <li>
                            <a rel="noopener noreferrer" href="/cgv"
                                >Conditions générales de vente</a
                            >
                        </li>
                        <li>
                            <a rel="noopener noreferrer" href="/privacypolicy"
                                >Politique de confidentialité</a
                            >
                        </li>
                        <li>
                            <a rel="noopener noreferrer" href="/legalnotices"
                                >Mentions legales</a
                            >
                        </li>
                    </ul>
                </div>
                <div class="space-y-3">
                    <h3 class="tracking-wide uppercase dark:text-gray-50">
                        Aide
                    </h3>
                    <ul class="space-y-1">
                        <li>
                            <a rel="noopener noreferrer" href="/faq">FAQ</a>
                        </li>
                        
                    </ul>
                </div>
            </div>
        </div>
        <div class="py-6 text-sm text-center dark:text-gray-400">
            © 2023 Theatly. Tous droit réservé.
        </div>
    </footer>
</template>

<style>
.footer-logo {
    transform: scale(4);
    margin-left: 10px;
}

.nav-logo {
    transform: scale(2);
    margin-left: 10px;
}
</style>
