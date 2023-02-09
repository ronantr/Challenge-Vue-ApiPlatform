<script setup>
import { ref, onMounted } from "vue";
import { axios } from "../../libs";
import { useRouter } from "vue-router";
import { useToast } from "vue-toastification";

const theaterGroups = ref([]);
const isLoading = ref(true);
const router = useRouter();
const toast = useToast();

onMounted(async () => {
    try {
        const { data } = await axios.get("/theater_groups");

        theaterGroups.value = data["hydra:member"].map((theaterGroup) => ({
            ...theaterGroup,
            id: theaterGroup["@id"].split("/").pop(),
        }));
    } catch (error) {
        toast.error(error.message);
    } finally {
        isLoading.value = false;
    }
});

const headers = [
    { text: "ID", value: "id" },
    { text: "Name", value: "name" },
    { text: "Phone Number", value: "phoneNumber" },
    { text: "Status", value: "status" },
    { text: "Actions", value: "actions", sortable: false },
];

const onClickRow = (item) => {
    router.push({ name: "admin-theater-group", params: { id: item.id } });
};
</script>

<template>
    <h1 class="text-xl">Theater groups</h1>
    <EasyDataTable
        :headers="headers"
        :items="theaterGroups"
        alternating
        :loading="isLoading"
        @click-row="onClickRow"
    />
</template>
