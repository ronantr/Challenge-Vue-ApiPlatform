<script setup>
import { object, string } from "yup";
import { useToast } from "vue-toastification";
import { useRouter } from "vue-router";
import DynamicForm from "../components/DynamicForm.vue";
import { axios } from "../libs";
import { formatConstraintViolation, isConstraintViolation } from "../errors";

const toast = useToast();
const router = useRouter();

const validationSchema = object({
    name: string().min(3).max(255).required(),
    phoneNumber: string()
        .matches(
            /^\+((?:9[679]|8[035789]|6[789]|5[90]|42|3[578]|2[1-689])|9[0-58]|8[1246]|6[0-6]|5[1-8]|4[013-9]|3[0-469]|2[70]|7|1)(?:\W*\d){0,13}\d$/,
            "Invalid phone number"
        )
        .required(),
});

const fields = [
    {
        label: "Name",
        name: "name",
        as: "input",
        type: "text",
    },
    {
        label: "Phone Number",
        name: "phoneNumber",
        as: "input",
        type: "text",
    },
];

async function onSubmit(fields, { setErrors }) {
    try {
        await axios.post("/join", fields);

        router.push("/theater");
    } catch (error) {
        if (isConstraintViolation(error)) {
            const errors = formatConstraintViolation(error);

            return setErrors(errors);
        }

        if (error.status === 403) {
            return toast.error(error.data["hydra:description"]);
        }

        toast.error("Something went wrong!");
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
