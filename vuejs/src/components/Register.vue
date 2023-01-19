<script setup>
import DynamicForm from "./DynamicForm.vue";
import * as yup from "yup";
import { useAuthStore } from "../stores";

const { register } = useAuthStore();

const schema = {
    fields: [
        {
            label: "First name",
            name: "firstname",
            as: "input",
            type: "text",
            rules: yup.string().required("First name is required!"),
        },
        {
            label: "Last Name",
            name: "lastname",
            as: "input",
            type: "text",
            rules: yup.string().required("Last name is required!"),
        },
        {
            label: "Email",
            name: "email",
            as: "input",
            type: "email",
            rules: yup
                .string()
                .email("Email is invalid!")
                .max(50, "Must be maximum 50 characters!")
                .required("Email is required!"),
        },
        {
            label: "Password",
            name: "password",
            as: "input",
            type: "password",
            rules: yup
                .string()
                .min(6, "Must be at least 6 characters!")
                .max(40, "Must be maximum 40 characters!")
                .required("Password is required!"),
        },
    ],
};
</script>

<template>
    <DynamicForm :schema="schema" :onSubmit="register" />
</template>
