import { defineStore } from "pinia";
import { computed, ref } from "vue";
import decode from "jwt-decode";
import dayjs from "dayjs";
import { useRouter } from "vue-router";
import { useStorage } from "@vueuse/core";
import { apiFetch } from "../utils/apiFetch";

export const useAuthStore = defineStore("auth", () => {
  const router = useRouter();
  const user = ref(null);
  const isAuthenticated = computed(() => !!user.value);
  const isAttempted = ref(false);
  // TODO: Use it to welcome the user on the profile page
  const isVerified = ref(false);
  const token = useStorage("token", null);

  function setToken(value) {
    token.value = value;
  }

  function setUser(value) {
    user.value = value;
  }

  async function attempt() {
    try {
      if (!token.value) {
        return;
      }

      const { exp, roles, sub } = decode(token.value);
      const isExpired = dayjs().isAfter(dayjs.unix(exp));

      if (isExpired) {
        token.value = null;

        return;
      }

      const { data } = await apiFetch("/users/" + sub);
      const isAdmin = roles.includes("ROLE_ADMIN");

      setUser({
        ...data,
        isAdmin,
      });
    } catch (error) {
      token.value = null;
    } finally {
      isAttempted.value = true;
    }
  }

  function logout() {
    token.value = null;
    user.value = null;

    router.push({ name: "home" });
  }

  async function verify(confirmationToken) {
    try {
      const { data } = await apiFetch(
        "/verify",
        {
          token: confirmationToken,
        },
        {
          method: "POST",
        }
      );

      token.value = data.token;
      isVerified.value = true;
    } catch (error) {
      // TODO: Handle error
      console.error("TODO: handle email verification errors", error);
    }
  }

  return {
    attempt,
    isAttempted,
    isAuthenticated,
    isVerified,
    logout,
    user,
    verify,
    setToken,
    setUser,
    token,
  };
});
