<script setup>
import { object, string, ref } from "yup";
import DynamicForm from "../components/DynamicForm.vue";
import { axios } from "../libs";

const props = defineProps({
    token: {
        type: String,
        required: true,
    },
});

async function updatePassword({ password }) {
    try {
        const { data } = await axios.patch("/update-password", {
            token: props.token,
            password,
        });

        console.log("TODO: Display success message", data);
    } catch (error) {
        console.error("TODO: handle reset password errors", error);
    }
}

const validationSchema = object({
    password: string().required("Please enter your password"),
    passwordConfirmation: string().oneOf(
        [ref("password"), null],
        "Passwords must match"
    ),
});

const fields = [
    {
        label: "Password",
        name: "password",
        as: "input",
        type: "password",
    },
    {
        label: "Confirm Password",
        name: "passwordConfirmation",
        as: "input",
        type: "password",
    },
];
</script>

<template>
    <DynamicForm
        :validation-schema="validationSchema"
        :fields="fields"
        :onSubmit="updatePassword"
    />
</template>
