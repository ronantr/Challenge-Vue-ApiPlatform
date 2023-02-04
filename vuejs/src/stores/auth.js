import { defineStore } from "pinia";
import { computed, ref } from "vue";
import { axios } from "../libs";
import decode from "jwt-decode";
import dayjs from "dayjs";
import { useRouter } from "vue-router";

export const useAuthStore = defineStore("auth", () => {
  const router = useRouter();
  const user = ref(null);
  const isAuthenticated = computed(() => !!user.value);
  const isAdmin = ref(false);
  const isAttempted = ref(false);
  // TODO: Use it to welcome the user on the profile page
  const isVerified = ref(false);

  async function attempt() {
    try {
      const token = localStorage.getItem("token");

      if (!token) {
        return;
      }

      const decodedToken = decode(token);
      const isExpired = dayjs().isAfter(dayjs.unix(decodedToken.exp));

      if (isExpired) {
        return localStorage.removeItem("token");
      }

      const { data } = await axios.get("/users/" + decodedToken.sub);

      if (data["@id"]) {
        user.value = data;
        isAdmin.value = decodedToken.roles.includes("ROLE_ADMIN");
        axios.defaults.headers["Authorization"] = "Bearer " + token;
      }
    } finally {
      isAttempted.value = true;
    }
  }

  async function login(credentials) {
    const { data } = await axios.post("/login", credentials);

    const { token } = data;

    if (token) {
      localStorage.setItem("token", token);

      const decodedToken = decode(token);

      const { data } = await axios.get("/users/" + decodedToken.sub);

      if (data["@id"]) {
        user.value = data;
        isAdmin.value = decodedToken.roles.includes("ROLE_ADMIN");
        axios.defaults.headers["Authorization"] = "Bearer " + token;
      }
    }
  }

  function logout() {
    localStorage.removeItem("token");

    user.value = null;

    delete axios.defaults.headers["Authorization"];

    router.push({ name: "home" });
  }

  async function register(credentials) {
    const { data } = await axios.post("/register", credentials);

    if (data["@id"]) {
      user.value = data;

      login(credentials);
    }
  }

  async function verify(confirmationToken) {
    try {
      const { data } = await axios.post("/verify", {
        token: confirmationToken,
      });

      const { token } = data;

      if (token) {
        localStorage.setItem("token", token);

        isVerified.value = true;
      }
    } catch (error) {
      // TODO: Handle error
      console.error("TODO: handle email verification errors", error);
    }
  }

  return {
    attempt,
    isAdmin,
    isAttempted,
    isAuthenticated,
    isVerified,
    login,
    logout,
    register,
    user,
    verify,
  };
});
