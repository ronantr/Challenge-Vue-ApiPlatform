import redaxios from "redaxios";

export const axios = redaxios.create({
  baseURL: "https://localhost",
  headers: {
    "Content-Type": "application/json",
  },
});
