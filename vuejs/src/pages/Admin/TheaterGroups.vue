<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import { useToast } from "vue-toastification";
import { apiFetch } from "../../utils/apiFetch";

const theaterGroups = ref([]);
const isLoading = ref(true);
const router = useRouter();
const toast = useToast();
const searchField = ref("name");
const searchValue = ref("");

const status = {
    closed: "Fermé",
    verified: "Vérifié",
    pending: "En attente",
};

const searchables = ["id", "name", "phoneNumber"];
const selectables = ["status"];

onMounted(async () => {
    try {
        const { data } = await apiFetch("/theater_groups");

        theaterGroups.value = data["hydra:member"].map((theaterGroup) => ({
            ...theaterGroup,
            id: theaterGroup["@id"].split("/").pop(),
            status: status[theaterGroup.status],
        }));
    } catch (error) {
        toast.error(error.message);
    } finally {
        isLoading.value = false;
    }
});

const headers = [
    { text: "ID", value: "id" },
    { text: "Nom", value: "name" },
    { text: "Numéro de téléphone", value: "phoneNumber" },
    { text: "Status", value: "status" },
];

const onClickRow = (item) => {
    router.push({
        name: "admin-theater-group",
        params: { theaterGroupId: item.id },
    });
};
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
                        v-for="value in Object.values(status)"
                        :key="value"
                        :value="value"
                    >
                        {{ value }}
                    </option>
                </select>
                <button @click="searchValue = ''">Réinitialiser</button>
            </div>
        </div>
        <EasyDataTable
            :headers="headers"
            :items="theaterGroups"
            :search-field="searchField"
            :search-value="searchValue"
            :loading="isLoading"
            @click-row="onClickRow"
            alternating
        />
    </div>
</template>
