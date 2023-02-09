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
    <div class="flex justify-center">
        <div class="flex flex-col max-w-md p-6 rounded-md sm:p-10 dark:bg-gray-900 dark:text-gray-100">
            <div class="mb-8 text-center">
                <h1 class="my-3 text-4xl font-bold">Mot de passe oublié</h1>
                <p class="text-sm dark:text-gray-400">Renseignez votre mail afin de réinitialiser votre mot de passe</p>
            </div>
            <DynamicForm :validation-schema="validationSchema" :fields="fields" :on-submit="onSubmit" />
        </div>
    </div>

</template>
