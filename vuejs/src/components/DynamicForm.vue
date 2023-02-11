<script setup>
import { Form, Field, ErrorMessage } from "vee-validate";

defineProps({
    validationSchema: {
        type: Object,
        required: true,
    },
    fields: {
        type: Object,
        required: true,
    },
    onSubmit: {
        type: Function,
        required: true,
    },
});

function setFileInputValue(value) {
    const fileInput = document.querySelector("input[type=file]");

    fileInput.value = value;
}
</script>

<template>
    <Form
        v-slot="{ setFieldValue }"
        @submit="onSubmit"
        :validation-schema="validationSchema"
    >
        <div
            class="mb-4"
            v-for="{ name, label, ...attrs } in fields"
            :key="name"
        >
            <label class="block text-gray-700 mb-2" :for="name">{{
                label
            }}</label>
            <Field
                class="border-2 rounded-lg w-full py-2 px-3 text-gray-700 leading-tight"
                :id="name"
                :name="name"
                v-bind="attrs"
            />
            <button
                v-if="attrs.type === 'file'"
                @click.prevent="
                    setFieldValue(name, null);
                    setFileInputValue('');
                "
                type="button"
            >
                Remove
            </button>
            <ErrorMessage class="text-red-500" :name="name" />
        </div>
        <div class="flex justify-center">
            <button
                class="bg-blue-500 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg"
            >
                Submit
            </button>
        </div>
    </Form>
</template>
