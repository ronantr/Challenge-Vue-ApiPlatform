import { defineStore } from "pinia";
import { computed, ref } from "vue";
import { axios } from "../libs";
import decode from "jwt-decode";
import dayjs from "dayjs";

export const useAuthStore = defineStore("auth", () => {
  const user = ref(null);
  const isAuthenticated = computed(() => !!user.value);
  const isAdmin = ref(false);
  const isAttempted = ref(false);

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
  }

  async function register(credentials) {
    const { data } = await axios.post("/register", credentials);

    if (data["@id"]) {
      user.value = data;

      login(credentials);
    }
  }

  return {
    attempt,
    isAdmin,
    isAttempted,
    isAuthenticated,
    login,
    logout,
    register,
    user,
  };
});
