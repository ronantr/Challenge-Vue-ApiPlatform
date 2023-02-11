<script setup>
import { object, string } from "yup";
import DynamicForm from "../components/DynamicForm.vue";
import { useRouter } from "vue-router";
import decode from "jwt-decode";
import { useAuthStore } from "../stores";
import { useToast } from "vue-toastification";
import { apiFetch } from "../utils/apiFetch";

const toast = useToast();
const router = useRouter();
const authStore = useAuthStore();
const { setUser, setToken } = authStore;

const validationSchema = object({
    email: string().email().required(),
    password: string().required(),
});

const fields = [
    {
        label: "Email",
        name: "email",
        as: "input",
        type: "email",
    },
    {
        label: "Password",
        name: "password",
        as: "input",
        type: "password",
    },
];

async function onSubmit(credentials) {
    try {
        const response = await apiFetch("/login", credentials, {
            method: "POST",
        });

        const { token } = response.data;

        setToken(token);

        const { roles, sub } = decode(token);
        const { data } = await apiFetch("/users/" + sub);
        const isAdmin = roles.includes("ROLE_ADMIN");

        setUser({
            ...data,
            isAdmin,
        });

        if (isAdmin) {
            return router.push({ name: "admin" });
        }

        return router.push({ name: "profile" });
    } catch (error) {
        if (error.status === 401) {
            return toast.error(error.data.message);
        }

        toast.error("Something went wrong");
    }
}
</script>

<template>
    <div class="flex justify-center">
        <div class="flex flex-col max-w-md p-6 rounded-md sm:p-10 dark:bg-gray-900 dark:text-gray-100">
            <div class="mb-8 text-center">
                <h1 class="my-3 text-4xl font-bold">Se connecter</h1>
                <p class="text-sm dark:text-gray-400">Connectez-vous pour accéder à votre espace</p>
            </div>
            <DynamicForm :validation-schema="validationSchema" :fields="fields" :on-submit="onSubmit" />
            <RouterLink to="reset-password" class="flex justify-center mt-5">Mot de passe oublié ?</RouterLink>
        </div>
    </div>
</template>
