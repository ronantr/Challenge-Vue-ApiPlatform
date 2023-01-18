import axios from "axios";

const API_URL = "https://localhost/";

class AuthService {
  login(user) {
    return axios
      .post(API_URL + "auth", {
        email: user.email,
        password: user.password,
      })
      .then((response) => {
        if (response.data.accessToken) {
          localStorage.setItem("user", JSON.stringify(response.data));
        }

        return response.data;
      });
  }

  logout() {
    localStorage.removeItem("user");
  }

  register(user) {
    return axios.post(API_URL + "users", {
      firstname: user.firstname,
      lastname: user.lastname,
      email: user.email,
      password: user.password,
    });
  }
}

export default new AuthService();
