<script setup>
import { object, string } from "yup";
import { useToast } from "vue-toastification";
import DynamicForm from "../components/DynamicForm.vue";
import { axios } from "../libs";

const toast = useToast();

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

async function onSubmit(values, { resetForm }) {
    try {
        const { data } = await axios.post("/reset-password", values);

        resetForm();

        toast.success(data.message);
    } catch (error) {
        if (error.status) {
            return toast.error(error.data["hydra:description"]);
        }

        toast.error("Something went wrong");
    }
}
</script>

<template>
    <DynamicForm
        :validation-schema="validationSchema"
        :fields="fields"
        :on-submit="onSubmit"
    />
</template>
