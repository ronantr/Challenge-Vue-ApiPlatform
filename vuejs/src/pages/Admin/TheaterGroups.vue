<script setup>
import { ref, watchEffect } from "vue";
import { useToast } from "vue-toastification";
import { apiFetch } from "../../utils/apiFetch";

const theaterGroups = ref([]);
const isLoading = ref(true);
const toast = useToast();
const searchField = ref("name");
const searchValue = ref("");
const serverItemsLength = ref(0);
const serverOptions = ref({
    page: 1,
    rowsPerPage: 10,
    sortBy: "status",
    sortType: "desc",
});

const status = {
    closed: "Fermé",
    verified: "Vérifié",
    pending: "En attente",
};

const searchables = ["id", "name", "phoneNumber"];
const selectables = ["status"];

const headers = [
    { text: "ID", value: "id" },
    { text: "Nom", value: "name", sortable: true },
    { text: "Numéro de téléphone", value: "phoneNumber", sortable: true },
    { text: "Status", value: "status", sortable: true },
    { text: "Représentant", value: "representative" },
];

function getURLSearchParams() {
    const urlSearchParams = new URLSearchParams();

    const { page, rowsPerPage, sortBy, sortType } = serverOptions.value;

    urlSearchParams.append("page", page);
    urlSearchParams.append("itemsPerPage", rowsPerPage);
    urlSearchParams.append(`order[${sortBy}]`, sortType);

    if (searchValue.value) {
        urlSearchParams.append(searchField.value, searchValue.value);
    }

    return urlSearchParams;
}

watchEffect(async () => {
    try {
        isLoading.value = true;

        const urlSearchParams = getURLSearchParams();

        const { data } = await apiFetch(
            "/theater_groups?" + urlSearchParams.toString()
        );

        theaterGroups.value = data["hydra:member"].map((theaterGroup) => ({
            ...theaterGroup,
            id: theaterGroup["@id"].split("/").pop(),
            status: status[theaterGroup.status],
            representative: {
                id: theaterGroup.representative["@id"].split("/").pop(),
                name: `${theaterGroup.representative.firstName} ${theaterGroup.representative.lastName}`,
            },
        }));

        serverItemsLength.value = data["hydra:totalItems"];
    } catch (error) {
        toast.error(error.message);
    } finally {
        isLoading.value = false;
    }
});
</script>

<template>
    <h1 class="text-xl">Theater groups</h1>
    <div class="flex flex-col gap-3">
        <div class="flex flex-row gap-3">
            <div class="flex flex-row gap-1">
                <label for="search-field">Champ</label>
                <select
                    v-model="searchField"
                    id="search-field"
                    @change="searchValue = ''"
                >
                    <option
                        v-for="header in headers"
                        :key="header.value"
                        :value="header.value"
                    >
                        {{ header.text }}
                    </option>
                </select>
            </div>
            <div class="flex flex-row gap-1">
                <label for="search-value">Valeur</label>
                <input
                    v-if="searchables.includes(searchField)"
                    v-model="searchValue"
                    type="text"
                    id="search-value"
                    class="border border-gray-300"
                />
                <select
                    v-else-if="selectables.includes(searchField)"
                    v-model="searchValue"
                    id="search-value"
                    class="border border-gray-300"
                >
                    <option value="">Tous</option>
                    <option
                        v-for="(value, key) in status"
                        :key="key"
                        :value="key"
                    >
                        {{ value }}
                    </option>
                </select>
                <button @click="searchValue = ''">Réinitialiser</button>
            </div>
        </div>
        <EasyDataTable
            v-model:server-options="serverOptions"
            :server-items-length="serverItemsLength"
            buttons-pagination
            :headers="headers"
            :items="theaterGroups"
            :loading="isLoading"
            alternating
            :rows-items="[10, 25, 50]"
            :rows-of-page-separator-message="'sur'"
            :rows-per-page-message="'Résultats par page'"
            :empty-message="'Aucun résultat'"
            must-sort
        >
            <template #item-name="item">
                <router-link
                    :to="{
                        name: 'admin-theater-group',
                        params: { theaterGroupId: item.id },
                    }"
                >
                    {{ item.name }}
                </router-link>
            </template>
            <template #item-representative="item">
                <router-link
                    :to="{
                        name: 'admin-user',
                        params: { userId: item.representative.id },
                    }"
                >
                    {{ item.representative.name }}
                </router-link>
            </template>
        </EasyDataTable>
    </div>
</template>

<style scoped>
a {
    color: black;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}
</style>
