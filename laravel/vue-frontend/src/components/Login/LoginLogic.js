import API, { getCsrfToken } from "../../api";
import { useRouter } from "vue-router";

export default {
  data() {
    return {
      email: "",
      password: "",
      errorMessage: "",
      isLoading: false
    };
  },
  setup() {
    const router = useRouter();
    return { router };
  },
  methods: {
    async login() {
      this.isLoading = true;
      this.errorMessage = "";

      try {
        await getCsrfToken();
        const response = await API.post("/login", {
          email: this.email,
          password: this.password
        });

        localStorage.setItem("token", response.data.token);
        this.$router.push("/dashboard");
      } catch (error) {
        if (error.response && error.response.status === 401) {
          this.errorMessage = "Invalid email or password";
        } else {
          this.errorMessage = "Something went wrong. Please try again.";
        }
      } finally {
        this.isLoading = false;
      }
    }
  }
};
