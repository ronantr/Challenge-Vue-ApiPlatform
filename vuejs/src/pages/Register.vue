<script setup>
import DynamicForm from "../components/DynamicForm.vue";
import { object, string } from "yup";
import { useToast } from "vue-toastification";
import { isConstraintViolation, formatConstraintViolation } from "../errors";
import { apiFetch } from "../utils/apiFetch";

const toast = useToast();

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

async function onSubmit(credentials, { setErrors, resetForm }) {
    try {
        await apiFetch("/register", credentials, {
            method: "POST",
        });

        resetForm();

        toast.success(
            "You have successfully registered ! An email has been sent to you, please confirm your account.",
            {
                timeout: false,
            }
        );
    } catch (error) {
        if (isConstraintViolation(error)) {
            const errors = formatConstraintViolation(error);

            return setErrors(errors);
        }

        toast.error("Something went wrong!");
    }
}
</script>

<template>
    <div class="flex justify-center">
        <div class="flex flex-col max-w-md p-6 rounded-md sm:p-10 dark:bg-gray-900 dark:text-gray-100">
            <div class="mb-8 text-center">
                <h1 class="my-3 text-4xl font-bold">S'inscrire</h1>
                <p class="text-sm dark:text-gray-400">Inscrivez-vous afin de gérer votre espace</p>
            </div>
            <DynamicForm :validation-schema="validationSchema" :fields="fields" :on-submit="onSubmit" />
        </div>
    </div>
</template>
