<script setup>
import { object, string, ref } from "yup";
import { useToast } from "vue-toastification";
import DynamicForm from "../components/DynamicForm.vue";
import { apiFetch } from "../utils/apiFetch";

const props = defineProps({
    token: {
        type: String,
        required: true,
    },
});

const toast = useToast();

const validationSchema = object({
    password: string()
        .matches(
            /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).{8,}$/,
            "Password must contain at least 8 characters, 1 uppercase letter, 1 lowercase letter, 1 number and 1 special character"
        )
        .required("Please enter your password"),
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

async function onSubmit({ password }, { setErrors }) {
    try {
        const { data } = await apiFetch(
            "/update-password",
            {
                token: props.token,
                password,
            },
            {
                method: "PATCH",
            }
        );

        toast.success(data.message);
    } catch (error) {
        if (error.status === 422) {
            setErrors(error.data);
        }

        toast.error("Something went wrong");
    }
}
</script>

<template>
    <DynamicForm
        :validation-schema="validationSchema"
        :fields="fields"
        :onSubmit="onSubmit"
    />
</template>
