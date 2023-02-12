<script setup>
import { ref, watchEffect } from "vue";
import { useRouter } from "vue-router";
import { useToast } from "vue-toastification";
import { apiFetch } from "../../utils/apiFetch";

const theaterGroups = ref([]);
const isLoading = ref(true);
const router = useRouter();
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
];

const onClickRow = (item) => {
    router.push({
        name: "admin-theater-group",
        params: { theaterGroupId: item.id },
    });
};

watchEffect(async () => {
    try {
        isLoading.value = true;

        const urlSearchParams = new URLSearchParams();

        urlSearchParams.append("page", serverOptions.value.page);
        urlSearchParams.append("itemsPerPage", serverOptions.value.rowsPerPage);
        urlSearchParams.append(
            `order[${serverOptions.value.sortBy ?? "status"}]`,
            serverOptions.value.sortType ?? "desc"
        );

        if (searchables.includes(searchField.value)) {
            urlSearchParams.append(searchField.value, searchValue.value);
        } else if (selectables.includes(searchField.value)) {
            if (searchValue.value) {
                urlSearchParams.append(searchField.value, searchValue.value);
            }
        }

        const { data } = await apiFetch(
            "/theater_groups?" + urlSearchParams.toString()
        );

        theaterGroups.value = data["hydra:member"].map((theaterGroup) => ({
            ...theaterGroup,
            id: theaterGroup["@id"].split("/").pop(),
            status: status[theaterGroup.status],
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
            @click-row="onClickRow"
            alternating
        />
    </div>
</template>
