<script setup>
import { object, string } from "yup";
import DynamicForm from "../components/DynamicForm.vue";
import { axios } from "../libs";

const validationSchema = object({
    email: string().required().email(),
});

const fields = [
    {
        label: "Email",
        name: "email",
        as: "input",
        type: "email",
    },
];

function resetPassword({ email }) {
    try {
        const { data } = axios.post("/reset-password", {
            email,
        });

        console.log("TODO: handle reset succes", data);
    } catch (error) {
        console.error(error);
    }
}
</script>

<template>
    <DynamicForm
        :validation-schema="validationSchema"
        :fields="fields"
        :on-submit="resetPassword"
    />
</template>
