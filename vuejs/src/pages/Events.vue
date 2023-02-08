<template>
    <div>
        <div class="flex items-center justify-center overflow-hidden m-4">
            <h1 class="text-3xl font-bold">Events</h1>
            <div class="flex">
                <button
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mx-3"
                >
                    Create
                </button>
            </div>
        </div>
        <CrudTable :columns="columns" :rows="rows" :actions="actions">
        </CrudTable>

        <Modal v-if="showModal" @close="showModal = false">
            <div class="p-4">
                <h2 class="text-2xl font-bold">Event Details</h2>
                <p class="text-xl font-bold mt-4">ID: {{ selectedEvent.id }}</p>
                <p class="text-xl font-bold mt-4">
                    Name: {{ selectedEvent.name }}
                </p>
                <p class="text-xl font-bold mt-4">
                    Description: {{ selectedEvent.description }}
                </p>
            </div>
        </Modal>

        <Modal v-if="showModal" @close="showModal = false">
            <div class="w-full max-w-xs">
                <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    <div class="mb-4">
                        <label
                            class="block text-gray-700 font-bold mb-2"
                            for="username"
                        >
                            Name
                        </label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="username"
                            type="text"
                            placeholder="Name"
                        />
                    </div>
                    <div class="mb-6">
                        <label
                            class="block text-gray-700 font-bold mb-2"
                            for="password"
                        >
                            Description
                        </label>
                        <textarea
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="password"
                            type="text"
                            placeholder="Description"
                        ></textarea>
                    </div>
                    <div class="flex items-center justify-between">
                        <button
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            type="submit"
                        >
                            Save
                        </button>
                        <a
                            class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800"
                            href="#"
                        >
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </Modal>
    </div>
</template>

<script setup>
import { ref } from "vue";
import CrudTable from "../components/CrudTable.vue";
import Modal from "../components/Modal.vue";

const showModal = ref(false);
const selectedEvent = ref({});

//show form modal if action is edit
const edit = (id) => {
    showModal.value = true;
    selectedEvent.value = rows.find((row) => row.id === id);
};

//show view modal if action is view
const view = (id) => {
    showModal.value = true;
    selectedEvent.value = rows.find((row) => row.id === id);
};

//delete row if action is delete
const deleteRow = (id) => {
    console.log("delete", id);
};

const columns = [
    {
        name: "id",
        label: "ID",
        field: "id",
        align: "left",
        sortable: true,
    },
    {
        name: "name",
        label: "Name",
        field: "name",
        align: "left",
        sortable: true,
    },
    {
        name: "description",
        label: "Description",
        field: "description",
        align: "left",
        sortable: true,
    },
    {
        name: "actions",
        label: "Actions",
        field: "actions",
        align: "center",
    },
];

const rows = [
    {
        id: 1,
        name: "Event 1",
        description: "Description 1",
    },
    {
        id: 2,
        name: "Event 2",
        description: "Description 2",
    },
    {
        id: 3,
        name: "Event 3",
        description: "Description 3",
    },
];

const actions = [
    {
        name: "view",
        label: "View",
        icon: "visibility",
        color: "blue",
        function: view,
    },
    {
        name: "edit",
        label: "Edit",
        icon: "edit",
        color: "green",
        function: edit,
    },
    {
        name: "delete",
        label: "Delete",
        icon: "delete",
        color: "red",
        function: deleteRow,
    },
];
</script>

<style></style>
