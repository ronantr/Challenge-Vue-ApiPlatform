<script setup>
import DynamicForm from "../components/DynamicForm.vue";
import { object, mixed } from "yup";
import { apiFetch } from "../utils/apiFetch";

const validationSchema = object({
    file: mixed().required(),
});

const fields = [
    {
        label: "Receipt",
        name: "file",
        as: "input",
        type: "file",
    },
];

async function onSubmit({ file }) {
    const formData = new FormData();

    formData.append("file", file);

    await apiFetch("/media_objects", formData, {
        method: "POST",
    });
}
</script>

<template>
    <DynamicForm
        :validation-schema="validationSchema"
        :fields="fields"
        :on-submit="onSubmit"
    />
</template>
