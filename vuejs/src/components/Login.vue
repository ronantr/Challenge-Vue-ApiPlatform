<script setup>
import * as yup from "yup";
import DynamicForm from "./DynamicForm.vue";
import { useAuth } from "../stores";

const { login } = useAuth();

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
