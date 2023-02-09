<script setup>
import { useAuthStore } from "./stores";
import { storeToRefs } from "pinia";

const authStore = useAuthStore();
const { logout } = authStore;
const { user, isAuthenticated, isAttempted } = storeToRefs(authStore);
</script>

<template>
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@mdi/font@5.8.55/css/materialdesignicons.min.css"
    />
    <Transition>
        <div id="app" v-if="isAttempted">
            <nav class="bg-gray-900">
                <div
                    class="container mx-auto flex items-center justify-between px-4 py-3"
                >
                    <div class="flex">
                        <div class="ml-4">
                            <router-link
                                to="/"
                                class="text-white hover:text-gray-500"
                            >
                                <FontAwesomeIcon icon="home" /> Home
                            </router-link>
                        </div>
                        <div v-if="user?.isAdmin" class="ml-4">
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
                                <FontAwesomeIcon icon="user-plus" /> Sign Up
                            </router-link>
                        </div>
                        <div class="ml-4">
                            <router-link
                                to="/login"
                                class="text-white hover:text-gray-500"
                            >
                                <FontAwesomeIcon icon="sign-in-alt" /> Login
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
                        <div class="ml-4">
                            <a class="text-blue-500" @click.prevent="logout">
                                <FontAwesomeIcon icon="sign-out-alt" /> Log out
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
            <div class="p-4">
                <router-view />
            </div>
        </div>
    </Transition>
</template>
