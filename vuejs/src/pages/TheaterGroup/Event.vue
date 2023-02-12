<script setup>
import { object, string, date, number } from "yup";
import { computed, ref, onMounted } from "vue";
import { useToast } from "vue-toastification";
import dayjs from "../../libs/day";
import DynamicForm from "../../components/DynamicForm.vue";
import { apiFetch } from "../../utils/apiFetch";
import { formatConstraintViolation, isConstraintViolation } from "../../errors";

const props = defineProps({
    eventId: {
        type: String,
        required: true,
    },
    theaterGroupId: {
        type: String,
        required: true,
    },
});

const event = ref(null);
const isLoading = ref(true);
const toast = useToast();
const coverInput = ref(null);
const cover = ref(null);

onMounted(async () => {
    try {
        const { data } = await apiFetch("/events/" + props.eventId);

        event.value = data;
    } catch (error) {
        toast.error("something went wrong");
    } finally {
        isLoading.value = false;
    }
});

const imageSrc = computed(
    () => import.meta.env.VITE_API_URL + event.value.contentUrl
);

const validationSchema = object({
    name: string().min(3).max(255).required(),
    date: date().required(),
    price: number().min(0).max(200).required(),
    location: string().required(),
    description: string().max(2000).required(),
    video: string().matches(
        /^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube(-nocookie)?\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$|^$/,
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
        label: "Price",
        name: "price",
        as: "input",
        type: "number",
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
        label: "Capacity",
        name: "capacity",
        as: "input",
        type: "number",
    },
    {
        label: "Video",
        name: "video",
        as: "input",
        type: "text",
    },
];

async function updateEvent(payload, { setErrors }) {
    try {
        const fields = {
            ...payload,
            ...(payload.date && {
                date: dayjs(payload.date).utc().format("YYYY-MM-DDTHH:mm:ssZ"),
            }),
            ...(payload.price && { priceInCents: payload.price * 100 }),
            price: undefined,
        };

        const updatedFields = Object.keys(fields).reduce((acc, key) => {
            if (fields[key] !== event.value[key]) {
                acc[key] = fields[key];
            }

            return acc;
        }, {});

        const isAnyFieldUpdated = Object.keys(updatedFields).length > 0;

        if (!isAnyFieldUpdated) {
            toast.info("No changes to update");

            return;
        }

        const { data } = await apiFetch(
            "/events/" + props.eventId,
            updatedFields,
            {
                method: "PATCH",
                headers: {
                    "Content-Type": "application/merge-patch+json",
                },
            }
        );

        event.value = data;

        toast.success("Event updated");
    } catch (error) {
        if (isConstraintViolation(error)) {
            const errors = formatConstraintViolation(error);

            return setErrors({
                ...errors,
                price: errors.priceInCents,
            });
        }

        toast.error("something went wrong");
    }
}

const publish = () =>
    updateEvent(
        { isPublished: true },
        {
            setErrors: null,
        }
    );

const unpublish = () =>
    updateEvent(
        { isPublished: false },
        {
            setErrors: null,
        }
    );

const initialValues = computed(() => ({
    ...event.value,
    date: dayjs.utc(event.value.date).local().format("YYYY-MM-DDTHH:mm"),
    price: event.value.priceInCents / 100,
}));

function deleteImage() {
    coverInput.value.value = null;
    cover.value = null;
}

async function updateImage() {
    try {
        if (!cover.value) {
            toast.info("No image to update");

            return;
        }

        const formData = new FormData();

        formData.append("cover", cover.value);

        const { data } = await apiFetch(
            "/update_cover/" + props.eventId,
            formData,
            {
                method: "POST",
            }
        );

        event.value = data;

        coverInput.value.value = null;
        cover.value = null;

        toast.success("Image updated");
    } catch (error) {
        toast.error("something went wrong");
    }
}
</script>

<template>
    <section v-if="!isLoading">
        <h1 class="text-xl">Event</h1>
        <router-link :to="`/theater-group/${props.theaterGroupId}/events`">
            Back
        </router-link>
        <div class="flex flex-col gap-3">
            <img :src="imageSrc" alt="event cover" />
            <div class="flex flex-row gap-1">
                <input
                    type="file"
                    ref="coverInput"
                    @change="cover = $event.target.files[0]"
                />
                <div v-if="cover" class="flex flex-col gap-1">
                    <button v-show="cover" @click="updateImage">Update</button>
                    <button @click="deleteImage">Cancel</button>
                </div>
            </div>
            <div v-if="event.isPublished" class="flex flex-col gap-1">
                <span>Published</span>
            </div>
            <div v-else class="flex flex-col gap-1">
                <span>Not published</span>
            </div>
            <button
                v-if="event.isPublished"
                @click="unpublish"
                class="bg-red-500 text-white"
            >
                Mark as not published
            </button>
            <button v-else @click="publish" class="bg-blue-500 text-white">
                Publish
            </button>
        </div>
        <DynamicForm
            :fields="fields"
            :validationSchema="validationSchema"
            :initial-values="initialValues"
            @submit="updateEvent"
        />
    </section>
</template>
