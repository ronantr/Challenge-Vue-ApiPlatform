import { useAuthStore } from "../stores";

export async function apiFetch(endpoint, body, options = {}) {
  const { token } = useAuthStore();
  const apiURL = new URL(endpoint, import.meta.env.VITE_API_URL);

  const headers = {
    "Content-Type": "application/json",
    ...(token ? { Authorization: "Bearer " + token } : {}),
    ...options.headers,
  };

  const isJSON = /json/.test(headers["Content-Type"]);

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

  const data = await response.json();

  return {
    data,
  };
}
