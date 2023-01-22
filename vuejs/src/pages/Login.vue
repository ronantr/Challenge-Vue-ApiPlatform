<script setup>
import * as yup from "yup";
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
        return router.push({ name: "home" });
    }
});

const schema = {
    fields: [
        {
            label: "Email",
            name: "email",
            as: "input",
            type: "email",
            rules: yup
                .string()
                .email("Email is invalid!")
                .required("Email is required!"),
        },
        {
            label: "Password",
            name: "password",
            as: "input",
            type: "password",
            rules: yup.string().required("Password is required!"),
        },
    ],
};
</script>

<template>
    <DynamicForm :schema="schema" :onSubmit="login" />
</template>
