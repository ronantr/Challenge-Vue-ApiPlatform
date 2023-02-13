<template>
    <nav class="flex justify-between items-center bg-gray-700 p-3">
        <h1 class="text-lg font-bold text-white mt-4">
            <a href="/admin">Theatly Admin</a>
        </h1>
        <ul class="flex flex-row gap-3 mr-auto ml-10">
            <li>
                <router-link class="text-gray-400 hover:text-white transition duration-300 ease-in-out"
                    to="/admin/theater-groups">
                    Groupes de théâtre
                </router-link>
            </li>
            <li>
                <router-link class="text-gray-400 hover:text-white transition duration-300 ease-in-out"
                    to="/admin/users">
                    Utlisateurs
                </router-link>
            </li>
        </ul>
    </nav>
    <div class="container mx-auto my-8">
        <router-view />
    </div>
</template>
  
  

<script setup>
import { computed } from "vue";
import { useRouter } from "vue-router";
import { storeToRefs } from "pinia";
import { useAuthStore } from "../../stores";
import { useToast } from "vue-toastification";


const authStore = useAuthStore();
const router = useRouter();
const currentUser = computed(() => {
    const { user } = storeToRefs(authStore);
    return user.value;
});


if (!currentUser.value) {
    router.push("/login");
}


console.log(currentUser.value);

</script>