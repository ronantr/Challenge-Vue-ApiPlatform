<script setup>
import { object, string, mixed } from "yup";
import { useToast } from "vue-toastification";
import { useRouter } from "vue-router";
import DynamicForm from "../components/DynamicForm.vue";
import { formatConstraintViolation, isConstraintViolation } from "../errors";
import { apiFetch } from "../utils/apiFetch";

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
    receipt: mixed().required(),
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
    {
        label: "Receipt",
        name: "receipt",
        as: "input",
        type: "file",
    },
];

async function onSubmit(fields, { setErrors }) {
    try {
        const formData = new FormData();

        for (const [key, value] of Object.entries(fields)) {
            if (value) {
                formData.append(key, value);
            }
        }

        const { data } = await apiFetch("/join", formData, {
            method: "POST",
        });

        const id = data["@id"].split("/").pop();

        router.push("/theater-group/" + id);
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
    <div class="bg-gray-100 min-h-screen py-10">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-8">Rejoindre Thealty</h2>
            <p class="text-lg text-gray-600 text-center mb-8">
                Vous êtes prêt à faire partie de notre équipe chez Thealty ? Remplissez le formulaire ci-dessous pour
                nous faire parvenir votre candidature. Un de nos représentants vous contactera sous peu.
            </p>
            <DynamicForm :validation-schema="validationSchema" :fields="fields" :on-submit="onSubmit"
                class="bg-white rounded-lg shadow-md p-4" />
        </div>
    </div>
</template> 