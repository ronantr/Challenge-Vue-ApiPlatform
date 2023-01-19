<template>
  <div class="container mx-auto">
    <div class="flex">
    <div class="w-1/3">
      <img
          src="https://randomuser.me/api/portraits/men/1.jpg"
          alt="Profile Picture"
          class="w-32 h-32 rounded-lg mx-auto mb-6"
          />
    </div>
    <div class="w-2/3 p-4">
      <h3 class="text-lg font-medium text-gray-700 mb-2">John Doe</h3>
      <p class="text-gray-700 font-medium mb-2">johndoe@test.fr</p>
      <h3 class="text-lg font-medium text-gray-700 mb-2">Votre crédit : <p class="text-red-400 font-medium">50€</p></h3>
      
    </div>
  </div>
    <section class="bg-gray-100 p-6 rounded-lg">
      <div class="relative overflow-hidden">
    <div class="relative z-10 flex items-center justify-center h-48 bg-gray-800">
      <h1 class="text-white text-lg font-medium">Récement vu</h1>
    </div>
    <div class="relative z-0">
      <div class="overflow-x-auto">
        <div class="inline-block  m-5">
          <div class="relative h-64">
            <img
              class="object-cover h-full w-64"
              src="https://fr.web.img6.acsta.net/pictures/22/05/10/16/46/2110017.jpg"
              alt="The Shawshank Redemption"
            />
          </div>
          <div class="text-center mt-2">
            <p class="text-black">Shark Bay</p>
            <p class="text-gray-500">2022</p>
            <p class="text-blue-400">15€</p>
          </div>
        </div>
        <div class="inline-block m-5">
          <div class="relative h-64">
            <img
              class="object-cover h-full w-64"
              src="https://c8.alamy.com/compfr/cb6d8e/le-parrain-1972-poster-godf-001vs-moviestore-collection-ltd-cb6d8e.jpg"
              alt="The Godfather"
            />
          </div>
          <div class="text-center mt-2">
            <p class="text-black">The Godfather</p>
            <p class="text-gray-500">1972</p>
            <p class="text-blue-400">15€</p>
          </div>
        </div>
        <div class="inline-block  m-5">
          <div class="relative h-64">
            <img
              class="object-cover h-full w-64"
              src="https://fr.web.img2.acsta.net/medias/nmedia/18/63/97/89/18949761.jpg"
              alt="The Dark Knight"
            />
          </div>
          <div class="text-center mt-2">
            <p class="text-black">The Dark Knight</p>
            <p class="text-gray-500">2008</p>
            <p class="text-blue-400">20€</p>
          </div>
        </div>
      </div>
    </div>
  </div>
    </section>
  </div>
</template>


<script>
export default {
    name: "Profile",
    computed: {
        // TODO: update with pinia
        currentUser() {
            return "todo";
        },
    },
    mounted() {
        if (!this.currentUser) {
            this.$router.push("/login");
        }
    },
};
</script>
