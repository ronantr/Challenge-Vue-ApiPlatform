<script setup>
import { Form, Field, ErrorMessage } from "vee-validate";
import { defineProps } from "vue";

defineProps({
    schema: {
        type: Object,
        required: true,
    },
    onSubmit: {
        type: Function,
        required: true,
    },
});
</script>

<template>
    <Form @submit="onSubmit">
        <div v-for="{ name, label, ...attrs } in schema.fields" :key="name">
            <label :for="name">{{ label }}</label>
            <Field :id="name" :name="name" v-bind="attrs" />
            <ErrorMessage :name="name" />
        </div>
        <button>Submit</button>
    </Form>
</template>
