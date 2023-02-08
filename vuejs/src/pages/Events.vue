<template>
    <!-- title  -->
    <!-- make entire div center -->
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
    <CrudTable :columns="columns" :rows="rows" :actions="actions"> </CrudTable>
</template>

<script setup>
import CrudTable from "../components/CrudTable.vue";

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

const view = (id) => {
    console.log("view", id);
};
const edit = (id) => {
    console.log("edit", id);
};
const deleteRow = (id) => {
    console.log("delete", id);
};

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
