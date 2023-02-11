<template>
    <li v-for="event in events">
        <a href="#" class="block overflow-hidden group">
            <img :src="event.image"
                alt=""
                class="h-[350px] w-full object-cover transition duration-500 group-hover:scale-105 sm:h-[450px]" />
        </a>
        <div class="relative pt-3 bg-white">
            <h3 class="text-xl text-gray-700 group-hover:underline group-hover:underline-offset-4">
                {{ event.name }}
            </h3>

            <p class="mt-2">
                <span class="sr-only"> {{ event.date }}</span>

                <span class="tracking-wider text-sm text-gray-900">Capacité : {{ event.capacity }} personnes</span>
            </p>
        </div>
    </li>
</template>

<script setup>

import { computed } from "vue";
import { useRouter } from "vue-router";
import { storeToRefs } from "pinia";
import { useAuthStore } from "../stores";
import { ref } from "vue";


const authStore = useAuthStore();
const router = useRouter();
const currentUser = computed(() => {
    const { user } = storeToRefs(authStore);
    return user.value;
});

if (!currentUser.value) {
    router.push("/login");
}

const events = ref([
    {
        "@id": "/events/1",
        "@type": "Event",
        "id": 1,
        "name": "alias",
        "date": "2023-02-19T00:49:49+00:00",
        "location": "82, chemin Teixeira\n00759 ClementBourg",
        "description": "Dolores ut quas optio eligendi numquam praesentium deserunt. Nulla provident nihil dolor possimus.",
        "image": "https://via.placeholder.com/640x480.png/008822?text=eum",
        "video": "http://guyot.fr/nam-tempora-saepe-incidunt-quia-at-dolore-sit-ducimus",
        "theater_group": "/users/3",
        "capacity": 164,
        "tickets": [
            "/tickets/6",
            "/tickets/8"
        ],
        "theaterGroup": "/users/3"
    },
    {
        "@id": "/events/2",
        "@type": "Event",
        "id": 2,
        "name": "dolor",
        "date": "2023-02-24T06:07:25+00:00",
        "location": "7, boulevard Émile Roger\n83281 Blanchetdan",
        "description": "Quia cumque qui praesentium. Ut consequatur sed tenetur sapiente soluta aut delectus. Ut cumque non et reiciendis ut. Sint ab sit autem fugit laborum.",
        "image": "https://via.placeholder.com/640x480.png/000088?text=similique",
        "video": "https://www.delmas.fr/ipsam-vitae-aut-accusamus-alias",
        "theater_group": "/users/3",
        "capacity": 199,
        "tickets": [],
        "theaterGroup": "/users/3"
    },
    {
        "@id": "/events/3",
        "@type": "Event",
        "id": 3,
        "name": "unde",
        "date": "2023-02-19T00:22:57+00:00",
        "location": "9, impasse Thierry Joseph\n72058 Noel",
        "description": "Non non qui porro ratione. Sint natus ad aut maxime. Ipsam aut autem est nemo sequi unde nostrum.",
        "image": "https://via.placeholder.com/640x480.png/0011aa?text=doloribus",
        "video": "https://www.grondin.fr/sit-voluptatem-voluptate-rerum-ab-est-perferendis-in",
        "theater_group": "/users/3",
        "capacity": 124,
        "tickets": [],
        "theaterGroup": "/users/3"
    },
    {
        "@id": "/events/4",
        "@type": "Event",
        "id": 4,
        "name": "sint",
        "date": "2023-03-26T08:56:53+00:00",
        "location": "8, rue Brigitte Klein\n53 579 Loiseaudan",
        "description": "Suscipit omnis et et vel. Accusamus explicabo nisi qui animi et doloremque exercitationem. Voluptatibus tempora dolor nihil soluta qui.",
        "image": "https://via.placeholder.com/640x480.png/00ff88?text=rerum",
        "video": "https://www.techer.org/asperiores-ut-perferendis-dolorem",
        "theater_group": "/users/3",
        "capacity": 159,
        "tickets": [
            "/tickets/2"
        ],
        "theaterGroup": "/users/3"
    },
    {
        "@id": "/events/5",
        "@type": "Event",
        "id": 5,
        "name": "aut",
        "date": "2023-02-14T22:58:28+00:00",
        "location": "49, impasse de Clerc\n54 489 Pascal",
        "description": "Quia corrupti in repudiandae aut sit. Et et sit quam necessitatibus delectus.",
        "image": "https://via.placeholder.com/640x480.png/005522?text=et",
        "video": "https://www.salmon.com/voluptatum-est-aut-vero-aut-praesentium-quae-blanditiis-ut",
        "theater_group": "/users/3",
        "capacity": 61,
        "tickets": [
            "/tickets/5",
            "/tickets/10",
            "/tickets/16"
        ],
        "theaterGroup": "/users/3"
    },
    {
        "@id": "/events/6",
        "@type": "Event",
        "id": 6,
        "name": "ut",
        "date": "2023-02-12T19:52:51+00:00",
        "location": "63, rue de Vidal\n45276 Becker",
        "description": "Quia recusandae reprehenderit non eligendi nostrum. Est possimus velit soluta odit qui aut. Doloremque velit optio ratione quia quia deleniti.",
        "image": "https://via.placeholder.com/640x480.png/00aa00?text=aspernatur",
        "video": "http://legros.org/architecto-aut-et-non-aut",
        "theater_group": "/users/3",
        "capacity": 100,
        "tickets": [
            "/tickets/14",
            "/tickets/19"
        ],
        "theaterGroup": "/users/3"
    },
    {
        "@id": "/events/7",
        "@type": "Event",
        "id": 7,
        "name": "maxime",
        "date": "2023-03-03T02:10:18+00:00",
        "location": "12, rue Charrier\n78544 Pelletier",
        "description": "Quia porro eveniet non. Sit qui necessitatibus amet quod recusandae blanditiis eos. Incidunt commodi pariatur dolor.",
        "image": "https://via.placeholder.com/640x480.png/004455?text=dolores",
        "video": "http://legros.com/ut-quia-error-consequatur.html",
        "theater_group": "/users/3",
        "capacity": 92,
        "tickets": [],
        "theaterGroup": "/users/3"
    },
    {
        "@id": "/events/8",
        "@type": "Event",
        "id": 8,
        "name": "sint",
        "date": "2023-03-13T22:03:24+00:00",
        "location": "344, impasse Laroche\n71 385 Loiseau-sur-Mer",
        "description": "Non neque sit sunt vel reiciendis temporibus itaque. Expedita nihil soluta debitis et rerum aliquid. Aut itaque perspiciatis impedit fuga perspiciatis reiciendis et.",
        "image": "https://via.placeholder.com/640x480.png/004411?text=nobis",
        "video": "https://ramos.net/non-aliquid-perspiciatis-et-iure-voluptates-cumque-architecto.html",
        "theater_group": "/users/3",
        "capacity": 52,
        "tickets": [
            "/tickets/3",
            "/tickets/4",
            "/tickets/11",
            "/tickets/12"
        ],
        "theaterGroup": "/users/3"
    },
    {
        "@id": "/events/9",
        "@type": "Event",
        "id": 9,
        "name": "sed",
        "date": "2023-03-01T07:10:58+00:00",
        "location": "89, impasse de Francois\n70784 HardyVille",
        "description": "Consectetur voluptate vel quam quis. Et est earum ut voluptas consequuntur ab. Consequuntur quis sunt quia ad hic rerum.",
        "image": "https://via.placeholder.com/640x480.png/001122?text=repellendus",
        "video": "http://rossi.com/",
        "theater_group": "/users/3",
        "capacity": 100,
        "tickets": [
            "/tickets/1",
            "/tickets/7",
            "/tickets/9",
            "/tickets/13"
        ],
        "theaterGroup": "/users/3"
    },
    {
        "@id": "/events/10",
        "@type": "Event",
        "id": 10,
        "name": "suscipit",
        "date": "2023-03-05T05:02:38+00:00",
        "location": "rue Paris\n08908 Bonninboeuf",
        "description": "Explicabo hic ut voluptatem voluptatem aut fugiat. Laudantium nulla ab et cum dolorem voluptas. Consectetur magnam pariatur aperiam dolor eaque eveniet aut. Itaque sunt et quia aut ut.",
        "image": "https://via.placeholder.com/640x480.png/008822?text=ipsum",
        "video": "http://laine.fr/",
        "theater_group": "/users/3",
        "capacity": 131,
        "tickets": [
            "/tickets/15",
            "/tickets/17",
            "/tickets/18",
            "/tickets/20"
        ],
        "theaterGroup": "/users/3"
    }
]
);

</script>