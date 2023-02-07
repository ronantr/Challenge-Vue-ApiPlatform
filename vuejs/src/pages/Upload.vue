<script setup>
import DynamicForm from "../components/DynamicForm.vue";
import { object, mixed } from "yup";
import { axios } from "../libs";

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

    await axios.post("/media_objects", formData);
}
</script>

<template>
    <DynamicForm
        :validation-schema="validationSchema"
        :fields="fields"
        :on-submit="onSubmit"
    />
</template>
