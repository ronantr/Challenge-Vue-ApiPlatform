<script setup>
import * as yup from "yup";
import DynamicForm from "./DynamicForm.vue";

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

async function login(user) {
    const response = await fetch("https://localhost/login", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(user),
    });

    console.debug(response);
}
</script>

<template>
    <DynamicForm :schema="schema" :onSubmit="login" />
</template>
