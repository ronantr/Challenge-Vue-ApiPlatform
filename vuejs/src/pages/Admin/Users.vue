<script setup>
import { ref, watchEffect } from "vue";
import { useToast } from "vue-toastification";
import { useRouter } from "vue-router";
import { apiFetch } from "../../utils/apiFetch";

const users = ref([]);
const isLoading = ref(true);
const toast = useToast();
const router = useRouter();
const searchField = ref("email");
const searchValue = ref("");
const serverItemsLength = ref(0);
const serverOptions = ref({
    page: 1,
    rowsPerPage: 10,
    sortBy: "email",
    sortType: "asc",
});

const roles = {
    ["ROLE_ADMIN"]: "Administrateur",
    ["ROLE_USER"]: "Utilisateur",
};

const writables = ["lastName", "firstName", "email"];
const selectables = ["roles"];
const searchables = [...writables, ...selectables];

const headers = [
    { text: "ID", value: "id" },
    { text: "Prénom", value: "firstName", sortable: true },
    { text: "Nom", value: "lastName", sortable: true },
    { text: "Email", value: "email", sortable: true },
    { text: "Rôle", value: "roles" },
    { text: "Group de théâtre", value: "theaterGroup" },
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

        const { data } = await apiFetch("/users?" + urlSearchParams.toString());

        users.value = data["hydra:member"].map((user) => {
            const theaterGroup = user.theaterGroups?.find(
                (theaterGroup) => theaterGroup.status === "verified"
            );

            return {
                ...user,
                id: user["@id"].split("/").pop(),
                roles: user.roles.map((role) => roles[role]),
                ...(theaterGroup && {
                    theaterGroup: {
                        id: theaterGroup["@id"].split("/").pop(),
                        name: theaterGroup.name,
                    },
                }),
            };
        });

        serverItemsLength.value = data["hydra:totalItems"];
    } catch (error) {
        toast.error(error.message);
    } finally {
        isLoading.value = false;
    }
});

function onClickRow(item) {
    router.push({
        name: "admin-user",
        params: { userId: item.id },
    });
}
</script>

<template>
    <h1 class="text-xl">Users</h1>
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
                        v-for="name in searchables"
                        :key="name"
                        :value="name"
                    >
                        {{
                            headers.find((header) => header.value === name)
                                ?.text
                        }}
                    </option>
                </select>
            </div>
            <div class="flex flex-row gap-1">
                <label for="search-value">Valeur</label>
                <input
                    v-if="writables.includes(searchField)"
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
                        v-for="(value, key) in roles"
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
            :items="users"
            :loading="isLoading"
            alternating
            :rows-items="[10, 25, 50]"
            :rows-of-page-separator-message="'sur'"
            :rows-per-page-message="'Résultats par page'"
            :empty-message="'Aucun résultat'"
            must-sort
            @click-row="onClickRow"
        >
            <template #item-theaterGroup="item">
                <router-link
                    v-if="item.theaterGroup"
                    :to="{
                        name: 'admin-theater-group',
                        params: { theaterGroupId: item.theaterGroup.id },
                    }"
                >
                    {{ item.theaterGroup.name }}
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
