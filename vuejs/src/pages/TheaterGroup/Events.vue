<script setup>
import { ref, onMounted } from "vue";
import { object, string, mixed, date, number } from "yup";
import dayjs from "../../libs/day";
import DynamicForm from "../../components/DynamicForm.vue";
import { formatConstraintViolation, isConstraintViolation } from "../../errors";
import { apiFetch } from "../../utils/apiFetch";
import { useToast } from "vue-toastification";
import { useRouter } from "vue-router";

const props = defineProps({
    theaterGroupId: {
        type: String,
        required: true,
    },
});

const toast = useToast();
const router = useRouter();
const events = ref([]);
const isLoading = ref(true);

onMounted(async () => {
    try {
        const { data } = await apiFetch(
            "/theater_groups/" + props.theaterGroupId + "/events"
        );

        events.value = data["hydra:member"];
    } catch (error) {
        toast.error("something went wrong");
    } finally {
        isLoading.value = false;
    }
});

const validationSchema = object({
    name: string().min(3).max(255).required(),
    date: date().required(),
    location: string().required(),
    description: string().max(2000).required(),
    cover: mixed().required(),
    video: string().matches(
        /^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube(-nocookie)?\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$/,
        "The url is not a vid youtube url"
    ),
    capacity: number().min(1).max(1000).required(),
});

const fields = [
    {
        label: "Name",
        name: "name",
        as: "input",
        type: "text",
    },
    {
        label: "Date",
        name: "date",
        as: "input",
        type: "datetime-local",
    },
    {
        label: "Location",
        name: "location",
        as: "input",
        type: "text",
    },
    {
        label: "Description",
        name: "description",
        as: "textarea",
    },
    {
        label: "Cover",
        name: "cover",
        as: "input",
        type: "file",
    },
    {
        label: "Video",
        name: "video",
        as: "input",
        type: "text",
    },
    {
        label: "Capacity",
        name: "capacity",
        as: "input",
        type: "number",
    },
];

async function onSubmit(fields, { setErrors }) {
    try {
        const formData = new FormData();

        Object.entries(fields).forEach(([key, value]) => {
            if (value) {
                if (key === "date") {
                    const date = dayjs(value).utc().format();

                    return formData.append(key, date);
                }

                return formData.append(key, value);
            }
        });

        const { data } = await apiFetch("/events", formData, {
            method: "POST",
        });

        const eventId = data["@id"].split("/").pop();

        router.push(`/theater-group/${props.theaterGroupId}/event/${eventId}`);
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
    <section>
        <h1 class="text-xl">Events</h1>
        <router-link :to="`/theater-group/${theaterGroupId}`">Back</router-link>
        <div>
            <DynamicForm
                :validation-schema="validationSchema"
                :fields="fields"
                :on-submit="onSubmit"
            />
            <div>
                <h2>Events</h2>
                <ul>
                    <li v-for="event in events" :key="event.id">
                        <router-link
                            :to="`/theater-group/${theaterGroupId}/event/${event[
                                '@id'
                            ]
                                .split('/')
                                .pop()}`"
                        >
                            {{ event.name }}
                        </router-link>
                    </li>
                </ul>
            </div>
        </div>
    </section>
</template>
