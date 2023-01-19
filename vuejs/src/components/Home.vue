<template>
  <div class="bg-gradient-to-r from-yellow-400 via-red-500 to-pink-500 ...">
    
  </div>
</template>

<script>
import UserService from "../services/user.service";


export default {
  name: "Home",
  data() {
    return {
      content: "",
    };
  },
  mounted() {
    UserService.getPublicContent().then(
      (response) => {
        this.content = response.data;
      },
      (error) => {
        this.content =
          (error.response &&
            error.response.data &&
            error.response.data.message) ||
          error.message ||
          error.toString();
      }
    );
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

</style>
