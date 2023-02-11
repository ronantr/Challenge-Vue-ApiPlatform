<template>
    <!-- TODO: revoir espace autour des section : pb -->
    <section class="bg-gray-900 text-white">
        <div class="mx-auto max-w-screen-xl px-4 py-32 lg:flex lg:h-screen lg:items-center"
        >
            <div class="mx-auto max-w-3xl text-center">
                <h1
                    class="bg-gradient-to-r from-green-300 via-blue-500 to-purple-600 bg-clip-text text-3xl font-extrabold text-transparent sm:text-5xl"
                >
                Vivez le théâtre
                    <span class="sm:block"> à son meilleur avec Theatly </span>
                </h1>

                <p class="mx-auto mt-4 max-w-xl sm:text-xl sm:leading-relaxed">
                    Bienvenue sur Theatly, le site dédié au théâtre et à tout ce qui l'entoure. Nous sommes ravis de vous accueillir ici pour vous offrir un aperçu unique et passionnant de l'univers du théâtre.
                </p>

                <div class="mt-8 flex flex-wrap justify-center gap-4">
                    <a
                        class="block w-full rounded border border-blue-600 bg-blue-600 px-12 py-3 text-sm font-medium text-white hover:bg-transparent hover:text-white focus:outline-none focus:ring active:text-opacity-75 sm:w-auto"
                        href="/get-started"
                    >
                        Réserver
                    </a>

                    <a
                        class="block w-full rounded border border-blue-600 px-12 py-3 text-sm font-medium text-white hover:bg-blue-600 focus:outline-none focus:ring active:bg-blue-500 sm:w-auto"
                        href="/about"
                    >  
                        En savoir plus
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-gray-900 text-white my-5">
        <div>
            <h2 class="text-2xl font-medium text-center my-4">
                Actuellement au théatre
            </h2>
            <div class="flex flex-wrap justify-center">
                <div
                    class="max-w-sm m-2 bg-white border border-gray-200 rounded-lg shadow-md"
                >
                    <img class="rounded-t-lg mx-auto mt-5" alt="film poster" src="https://cdn.sortiraparis.com/images/80/237/32672-les-miserables-de-retour-a-paris.jpg" style="max-width: 300px; max-height: 300px;"/>
                    <div class="p-5">
                        <h5
                            class="mb-2 text-2xl font-bold tracking-tight text-gray-900"
                        >
                            Les misérables
                        </h5>
                        <p class="mb-3 font-normal text-gray-700">
                            "Les Misérables" est un musical populaire basé sur le roman éponyme de Victor Hugo. 
                            Il a été créé pour la première fois en 1980 et a été joué à travers le monde entier depuis. 
                            Le spectacle suit l'histoire émouvante de Jean Valjean, un homme qui passe du statut de prisonnier à celui de citoyen respecté, 
                            tout en poursuivant son poursuivant implacable, l'inspecteur Javert.
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
                    class="max-w-sm m-2 bg-white border border-gray-200 rounded-lg shadow-md"
                >
                    <img class="rounded-t-lg mx-auto mt-5" alt="film poster" src="https://tpa.fr/user/img/24/0x1200x24212-or.jpg" style="max-width: 300px; max-height: 300px;"/>
                    <div class="p-5">
                        <h5
                            class="mb-2 text-2xl font-bold tracking-tight text-gray-900"
                        >
                            Cyrano de Bergerac
                        </h5>
                        <p class="mb-3 font-normal text-gray-700">
                            "Cyrano de Bergerac est une pièce de théâtre écrite par Edmond Rostand au début du XXe siècle. 
                            Elle raconte l'histoire d'un homme doté d'un grand talent pour les mots et d'une grande générosité, 
                            mais doté d'un nez très long qui le rend timide. 
                            Malgré cela, il tombe amoureux d'une belle jeune fille et fait tout ce qui est en son pouvoir pour la séduire, 
                            même si cela signifie se cacher derrière l'identité d'un autre."
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
                    class="max-w-sm m-2 bg-white border border-gray-200 rounded-lg shadow-md"
                >
                    <img class="rounded-t-lg mx-auto mt-5" alt="film poster" src="https://cdn.sortiraparis.com/images/80/1461/89425-image.png" style="max-width: 300px; max-height: 300px;"/>
                    <div class="p-5">
                        <h5
                            class="mb-2 text-2xl font-bold tracking-tight text-gray-900"
                        >
                            Roméo et Juliette
                        </h5>
                        <p class="mb-3 font-normal text-gray-700">
                            "Romeo et Juliette est une pièce de théâtre classique écrite par William Shakespeare. 
                            Cette histoire d'amour tragique entre deux jeunes amoureux de familles ennemies 
                            captivera les spectateurs avec sa romance passionnée et son drame intense."
                        </p>
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
</template>

<script></script>

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
</style>
