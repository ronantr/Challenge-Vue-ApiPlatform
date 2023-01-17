import axios from "axios";

const API_URL = "http://localhost:8000/auth/";

class AuthService {
  login(user) {
    return axios
      .post(API_URL + "login", {
        email: user.username,
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
    return axios.post(API_URL + "register", {
      username: user.username,
      email:   user.email,
      password: user.password,
    });
  }
}

export default new AuthService();
