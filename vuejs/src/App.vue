<script setup>
import { useAuthStore } from "./stores";
import { storeToRefs } from "pinia";
import { onBeforeMount } from "vue";

const authStore = useAuthStore();
const { attempt, logout } = authStore;
const { user, isAuthenticated, isAdmin, isAttempted } = storeToRefs(authStore);

onBeforeMount(() => {
    attempt();
});
</script>

<template>
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@mdi/font@5.8.55/css/materialdesignicons.min.css"
    />
    <link rel="stylesheet" href="https://unpkg.com/buefy/dist/buefy.min.css" />
    <div id="app">
        <nav class="bg-gray-900">
            <div
                class="container mx-auto flex items-center justify-between px-4 py-3"
            >
                <div class="flex">
                    <div class="ml-4">
                        <router-link
                            to="/home"
                            class="text-white hover:text-gray-500"
                        >
                            <font-awesome-icon icon="home" /> Home
                        </router-link>
                    </div>
                    <div v-if="showAdminBoard" class="ml-4">
                        <router-link
                            to="/admin"
                            class="text-white hover:text-gray-500"
                            >Admin Board</router-link
                        >
                    </div>
                    <div v-if="showModeratorBoard" class="ml-4">
                        <router-link
                            to="/mod"
                            class="text-white hover:text-gray-500"
                            >Moderator Board</router-link
                        >
                    </div>
                    <div class="ml-4">
                        <router-link
                            v-if="currentUser"
                            to="/user"
                            class="text-white hover:text-gray-500"
                            >User</router-link
                        >
                    </div>
                </div>

                <div v-if="!currentUser" class="ml-auto">
                    <div class="ml-4">
                        <router-link
                            to="/register"
                            class="text-white hover:text-gray-500"
                        >
                            <font-awesome-icon icon="user-plus" /> Sign Up
                        </router-link>
                    </div>
                    <div class="ml-4">
                        <router-link
                            to="/login"
                            class="text-white hover:text-gray-500"
                        >
                            <font-awesome-icon icon="sign-in-alt" /> Login
                        </router-link>
                    </div>
                </div>

                <div v-if="currentUser" class="ml-auto">
                    <li class="">
                        <router-link to="/profile" class="text-blue-500">
                            <font-awesome-icon icon="user" />
                            {{ currentUser.email }}
                        </router-link>
                    </li>
                    <li class="">
                        <a class="text-blue-500" @click.prevent="logOut">
                            <font-awesome-icon icon="sign-out-alt" /> LogOut
                        </a>
                    </li>
                </div>
            </div>
        </nav>

        <div class="p-4">
            <router-view />
        </div>
    </div>
</template>
