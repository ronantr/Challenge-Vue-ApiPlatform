<script setup>
import { object, string } from "yup";
import DynamicForm from "../components/DynamicForm.vue";
import { useAuthStore } from "../stores";
import { useRouter } from "vue-router";
import { watch } from "vue";
import { storeToRefs } from "pinia";

const router = useRouter();
const authStore = useAuthStore();
const { login } = authStore;
const { isAuthenticated, isAdmin } = storeToRefs(authStore);

watch(isAuthenticated, () => {
    if (isAdmin.value) {
        return router.push({ name: "admin" });
    }

    if (isAuthenticated.value) {
        return router.push({ name: "profile" });
    }
});

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
</script>

<template>
    <DynamicForm
        :validation-schema="validationSchema"
        :fields="fields"
        :on-submit="login"
    />
    <RouterLink to="reset-password">I forgot my password</RouterLink>
</template>
