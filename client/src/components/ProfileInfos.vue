<template>
	<div class="flex justify-center">
		<div class="max-w-md p-8 sm:flex sm:space-x-6 dark:bg-gray-900 dark:text-gray-100">
			<div class="flex-shrink-0 w-full mb-6 h-44 sm:h-32 sm:w-32 sm:mb-0">
				<img src="https://static.vecteezy.com/system/resources/previews/002/387/693/original/user-profile-icon-free-vector.jpg"
					alt="" class="object-cover object-center w-full h-full rounded dark:bg-gray-500">
			</div>
			<div class="flex flex-col space-y-4">
				<h2 class="text-2xl font-semibold">{{ currentUser.firstName }} {{ currentUser.lastName }}</h2>
				<div>
					Niveau 
					<span class="text-sm dark:text-gray-400">
					{{ currentUser.level ? currentUser.level.split("/").pop() : "non disponible" }}
					</span>
				</div>
				<div>
					Crédit: <span class="text-sm dark:text-gray-400 text-green-700">{{ currentUser.credit }}€</span>
				</div>
				<div>
					Points: <span class="text-sm dark:text-gray-400">{{ currentUser.points }}</span>
				</div>
				<div class="space-y-1">
					<span class="flex items-center space-x-2">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" aria-label="Email address"
							class="w-4 h-4">
							<path fill="currentColor"
								d="M274.6,25.623a32.006,32.006,0,0,0-37.2,0L16,183.766V496H496V183.766ZM464,402.693,339.97,322.96,464,226.492ZM256,51.662,454.429,193.4,311.434,304.615,256,268.979l-55.434,35.636L57.571,193.4ZM48,226.492,172.03,322.96,48,402.693ZM464,464H48V440.735L256,307.021,464,440.735Z">
							</path>
						</svg>
						<span class="dark:text-gray-400">{{ currentUser.email }}</span>
					</span>
				</div>
			</div>
		</div>
	</div>

</template>

<script setup>
import { computed } from "vue";
import { useRouter } from "vue-router";
import { storeToRefs } from "pinia";
import { useAuthStore } from "../stores";
import { useToast } from "vue-toastification";


const toast = useToast();
const toastOptions = {
	position: "top-right",
	timeout: 5000,
	closeOnClick: true,
	pauseOnFocusLoss: true,
	pauseOnHover: true,
	draggable: true,
	draggablePercent: 0.6,
	showCloseButtonOnHover: false,
	hideProgressBar: false,
	closeButton: "button",
	icon: true,
	rtl: false,
};

const authStore = useAuthStore();
const router = useRouter();
const currentUser = computed(() => {
	const { user } = storeToRefs(authStore);
	return user.value;
});


if (!currentUser.value) {
	router.push("/login");
}



toast.success(`Hello ${currentUser.value.firstName} !`, toastOptions);

console.log(currentUser.value);

</script>