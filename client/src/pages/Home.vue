<template>
    <!-- TODO: revoir espace autour des section : pb -->
    <section class="bg-gray-900 text-white">
        <div
            class="mx-auto max-w-screen-xl px-4 py-32 lg:flex lg:h-screen lg:items-center"
        >
            <div class="mx-auto max-w-3xl text-center">
                <h1
                    class="bg-gradient-to-r from-green-300 via-blue-500 to-purple-600 bg-clip-text text-3xl font-extrabold text-transparent sm:text-5xl"
                >
                    Vivez le théâtre
                    <span class="sm:block"> à son meilleur avec Theatly </span>
                </h1>

                <p class="mx-auto mt-4 max-w-xl sm:text-xl sm:leading-relaxed">
                    Bienvenue sur Theatly, le site dédié au théâtre et à tout ce
                    qui l'entoure. Nous sommes ravis de vous accueillir ici pour
                    vous offrir un aperçu unique et passionnant de l'univers du
                    théâtre.
                </p>

                <div class="mt-8 flex flex-wrap justify-center gap-4">
                    <a
                        class="block w-full rounded border border-blue-600 bg-blue-600 px-12 py-3 text-sm font-medium text-white hover:bg-transparent hover:text-white focus:outline-none focus:ring active:text-opacity-75 sm:w-auto"
                        href="/get-started"
                    >
                        Réserver
                    </a>

                    <router-link
                        class="block w-full rounded border border-blue-600 px-12 py-3 text-sm font-medium text-white hover:bg-blue-600 focus:outline-none focus:ring active:bg-blue-500 sm:w-auto"
                        to="/join"
                    >
                        Rejoindre l'aventure !
                    </router-link>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-gray-200 text-gray my-5">
        <div>
            <h2 class="text-2xl font-medium text-center my-4">
                Actuellement au théatre
            </h2>
            <div class="flex flex-wrap justify-center">
                <div
                    class="max-w-sm m-2 bg-gray-800 border border-gray-200 rounded-lg shadow-md"
                >
                    <img
                        class="rounded-t-lg mx-auto mt-5"
                        alt="film poster"
                        src="https://cdn.sortiraparis.com/images/80/237/32672-les-miserables-de-retour-a-paris.jpg"
                        style="max-width: 300px; max-height: 300px"
                    />
                    <div class="p-5">
                        <h5
                            class="mb-2 text-2xl font-bold tracking-tight text-white"
                        >
                            Les misérables
                        </h5>
                        <p class="mb-3 font-normal text-gray-300">
                            "Les Misérables" est un musical populaire basé sur
                            le roman éponyme de Victor Hugo. Il a été créé pour
                            la première fois en 1980 et a été joué à travers le
                            monde entier depuis. Le spectacle suit l'histoire
                            émouvante de Jean Valjean, un homme qui passe du
                            statut de prisonnier à celui de citoyen respecté,
                            tout en poursuivant son poursuivant implacable,
                            l'inspecteur Javert.
                        </p>
                        <a
                            href="#"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300"
                        >
                            En savoir plus
                        </a>
                    </div>
                </div>
                <div
                    class="max-w-sm m-2 bg-gray-800 border border-gray-200 rounded-lg shadow-md"
                >
                    <img
                        class="rounded-t-lg mx-auto mt-5"
                        alt="film poster"
                        src="https://tpa.fr/user/img/24/0x1200x24212-or.jpg"
                        style="max-width: 300px; max-height: 300px"
                    />
                    <div class="p-5">
                        <h5
                            class="mb-2 text-2xl font-bold tracking-tight text-white"
                        >
                            Cyrano de Bergerac
                        </h5>
                        <p class="mb-3 font-normal text-gray-300">
                            "Cyrano de Bergerac est une pièce de théâtre écrite
                            par Edmond Rostand au début du XXe siècle. Elle
                            raconte l'histoire d'un homme doté d'un grand talent
                            pour les mots et d'une grande générosité, mais doté
                            d'un nez très long qui le rend timide. Malgré cela,
                            il tombe amoureux d'une belle jeune fille et fait
                            tout ce qui est en son pouvoir pour la séduire, même
                            si cela signifie se cacher derrière l'identité d'un
                            autre."
                        </p>
                        <a
                            href="#"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300"
                        >
                            En savoir plus
                        </a>
                    </div>
                </div>
                <div
                    class="max-w-sm m-2 bg-gray-800 border border-gray-200 rounded-lg shadow-md"
                >
                    <img
                        class="rounded-t-lg mx-auto mt-5"
                        alt="film poster"
                        src="https://cdn.sortiraparis.com/images/80/1461/89425-image.png"
                        style="max-width: 300px; max-height: 300px"
                    />
                    <div class="p-5">
                        <h5
                            class="mb-2 text-2xl font-bold tracking-tight text-white"
                        >
                            Roméo et Juliette
                        </h5>
                        <p class="mb-3 font-normal text-gray-300">
                            "Romeo et Juliette est une pièce de théâtre
                            classique écrite par William Shakespeare. Cette
                            histoire d'amour tragique entre deux jeunes amoureux
                            de familles ennemies captivera les spectateurs avec
                            sa romance passionnée et son drame intense."
                        </p>
                        <!-- TODO: mettre la route pour l'event selectionné -->
                        <a
                            href="#"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300"
                        >
                            En savoir plus
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-6 bg-gray-900 text-white">
        <div
            class="container mx-auto flex flex-col items-center justify-center p-4 space-y-8 md:p-10 md:px-24 xl:px-48"
        >
            <h1
                class="bg-gradient-to-r from-green-300 via-blue-500 to-purple-600 bg-clip-text text-3xl font-extrabold text-transparent sm:text-5xl"
            >
                Accumulez des points à chaque réservation
                <span class="sm:block">
                    pour des avantages exclusifs avec Thealty
                </span>
            </h1>
            <p class="pt-2 pb-8 text-xl font-medium text-center">
                Découvrez les détails de notre système de cumul de points pour
                une expérience de réservation de théâtre encore plus
                enrichissante !
            </p>
            <a
                href="/fidelitycard"
                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300"
            >
                En savoir plus
            </a>
        </div>
    </section>
    <section>
        <div class="mx-auto max-w-screen-2xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="bg-blue-600 p-8 md:p-12 lg:px-16 lg:py-24">
                    <div class="mx-auto max-w-xl text-center">
                        <h2 class="text-2xl font-bold text-white md:text-3xl">
                            Vivez l'expérience de théâtre comme jamais
                            auparavant avec Thealty, votre porte d'entrée pour
                            les meilleures pièces de théâtre en ligne.
                        </h2>

                        <p class="hidden text-white/90 sm:mt-4 sm:block">
                            Explorez notre vaste sélection de théâtres en ligne
                            disponibles et réservez dès maintenant pour vivre
                            une expérience de théâtre unique.
                        </p>

                        <div class="mt-4 md:mt-8">
                            <!-- TODO: mettre la route pour la liste des events -->
                            <a
                                href="#"
                                class="inline-block rounded border border-white bg-white px-12 py-3 text-sm font-medium text-blue-500 transition hover:bg-transparent hover:text-white focus:outline-none focus:ring focus:ring-yellow-400"
                            >
                                Parcourir
                            </a>
                        </div>
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 gap-4 md:grid-cols-1 lg:grid-cols-2"
                >
                    <img
                        alt="theater"
                        src="https://perso.unamur.be/lanciaux/affiches/antigone.jpg/download"
                        class="h-40 w-full object-cover sm:h-56 md:h-full"
                    />

                    <img
                        alt="theater"
                        src="https://tpa.fr/user/img/23/0x1200x22527-or.jpg"
                        class="h-40 w-full object-cover sm:h-56 md:h-full"
                    />
                </div>
            </div>
        </div>
    </section>
    <section class="bg-gray-900">
        <div
            class="mx-auto max-w-screen-xl px-4 py-12 sm:px-6 md:py-16 lg:px-8"
        >
            <div class="mx-auto max-w-3xl text-center">
                <h2 class="text-3xl font-bold text-white sm:text-4xl">
                    Découvrez les statistiques étonnantes de notre plateforme de
                    réservation de théâtre en ligne
                </h2>

                <p class="mt-4 text-gray-300 sm:text-xl">
                    Rejoignez la communauté de théâtre en ligne la plus en vogue
                    avec Theatly. Avec plus de X spectacles à son actif et Y
                    clients satisfaits, vous êtes assuré de vivre une expérience
                    de théâtre unique et inoubliable.
                </p>
            </div>

            <div class="mt-8 sm:mt-12">
                <dl class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div
                        class="flex flex-col rounded-lg border border-gray-100 px-4 py-8 text-center"
                    >
                        <dt
                            class="order-last text-lg font-medium text-gray-300"
                        >
                            Nombre de spectacles
                        </dt>

                        <dd
                            class="text-4xl font-extrabold text-blue-600 md:text-5xl"
                        >
                            24
                        </dd>
                    </div>

                    <div
                        class="flex flex-col rounded-lg border border-gray-100 px-4 py-8 text-center"
                    >
                        <dt
                            class="order-last text-lg font-medium text-gray-300"
                        >
                            Nombre de réservations effectuées
                        </dt>

                        <dd
                            class="text-4xl font-extrabold text-blue-600 md:text-5xl"
                        >
                            153
                        </dd>
                    </div>

                    <div
                        class="flex flex-col rounded-lg border border-gray-100 px-4 py-8 text-center"
                    >
                        <dt
                            class="order-last text-lg font-medium text-gray-300"
                        >
                            Client satisfait
                        </dt>

                        <dd
                            class="text-4xl font-extrabold text-blue-600 md:text-5xl"
                        >
                            86%
                        </dd>
                    </div>
                </dl>
            </div>
            <div class="p-8 md:p-12 lg:px-16 lg:py-24">
                <div class="mx-auto max-w-xl text-center">
                    <h2 class="text-2xl font-bold text-white md:text-3xl">
                        Alors convaincu ?
                    </h2>

                    <p class="hidden text-white/90 sm:mt-4 sm:block">
                        Rejoignez maintenant la communauté de théâtre en ligne
                        la plus en vogue avec Theatly.
                    </p>

                    <div class="mt-4 md:mt-8">
                        <!-- TODO: mettre la route pour la liste des events -->
                        <a
                            href="register"
                            class="inline-block rounded border border-white bg-white px-12 py-3 text-sm font-medium text-blue-500 transition hover:bg-transparent hover:text-white focus:outline-none focus:ring focus:ring-yellow-400"
                        >
                            S'inscrire
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    data() {
        return {
            hover: false,
        };
    },
    methods: {
        showHoverEffect() {
            this.hover = true;
        },
        hideHoverEffect() {
            this.hover = false;
        },
    },
};
</script>

<style>
.home-page {
    text-align: center;
    margin-top: 100px;
}

header {
    font-size: 40px;
    font-weight: bold;
    margin-bottom: 20px;
}

main {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 20px;
}

h1 {
    font-size: 400px;
    font-weight: bold;
    margin-bottom: 20px;
}

.hover\:bg-blue-700 {
    transition: background-color 0.2s ease;
}

[v-cloak] {
    display: none;
}
</style>
