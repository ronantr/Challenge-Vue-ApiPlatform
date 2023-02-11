import { useAuthStore } from "../stores";

export async function apiFetch(endpoint, body, options = {}) {
  const { token } = useAuthStore();
  const apiURL = new URL(endpoint, import.meta.env.VITE_API_URL);

  const isFormData = body instanceof FormData;
  const isJSON = body && !isFormData;

  const headers = {
    ...(isJSON ? { "Content-Type": "application/json" } : {}),
    ...(token ? { Authorization: "Bearer " + token } : {}),
    ...options.headers,
  };

  const response = await fetch(apiURL, {
    ...options,
    headers,
    body: isJSON ? JSON.stringify(body) : body,
  });

  if (!response.ok) {
    const error = new Error(response.statusText);
    error.response = response;

    throw error;
  }

  try {
    const data = await response.json();

    return {
      data,
    };
  } catch (error) {
    return {
      data: null,
    };
  }
}
