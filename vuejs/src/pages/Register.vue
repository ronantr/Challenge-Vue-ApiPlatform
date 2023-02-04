<script setup>
import DynamicForm from "../components/DynamicForm.vue";
import { object, string } from "yup";
import { useAuthStore } from "../stores";
import { storeToRefs } from "pinia";
import { watch } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();
const authStore = useAuthStore();
const { register } = authStore;
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
    firstName: string().required("First name is required!"),
    lastName: string().required("Last name is required!"),
    email: string()
        .email()
        .max(50, "Must be maximum 50 characters!")
        .required("Email is required!"),
    password: string()
        .min(6, "Must be at least 6 characters!")
        .max(40, "Must be maximum 40 characters!")
        .required("Password is required!"),
});

const fields = [
    {
        label: "First name",
        name: "firstName",
        as: "input",
        type: "text",
    },
    {
        label: "Last Name",
        name: "lastName",
        as: "input",
        type: "text",
    },
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
        :on-submit="register"
    />
</template>
