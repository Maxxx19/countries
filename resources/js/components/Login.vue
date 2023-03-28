<template>
  <div class="container h-100 m-5">
    <div class="row h-100 align-items-center">
      <div class="col-12 col-md-6 offset-md-3">
        <div class="card shadow sm">
          <div class="card-body">
            <h1 class="text-center">Login</h1>
            <hr />
            <form action="javascript:void(0)" class="row" method="post">
              <div
                class="col-12"
                v-if="Object.keys(validationErrors).length > 0"
              >
                <div class="alert alert-danger">
                  <ul class="mb-0">
                    <li v-for="(value, key) in validationErrors" :key="key">
                      {{ value[0] }}
                    </li>
                  </ul>
                </div>
              </div>
              <div class="form-group col-12">
                <label for="email" class="font-weight-bold">Email</label>
                <input
                  type="text"
                  v-model="auth.email"
                  name="email"
                  id="email"
                  class="form-control"
                />
              </div>
              <div class="form-group col-12 my-2">
                <label for="password" class="font-weight-bold">Password</label>
                <input
                  type="password"
                  v-model="auth.password"
                  name="password"
                  id="password"
                  class="form-control"
                />
              </div>
              <div class="col-12 mb-2">
                <button
                  type="submit"
                  :disabled="processing"
                  @click="login"
                  class="btn btn-primary btn-block"
                >
                  {{ processing ? "Please wait" : "Login" }}
                </button>
              </div>
              <div class="col-12 text-center">
                <label
                  >Don't have an account?
                  <router-link :to="{ name: 'register' }"
                    >Register Now!</router-link
                  ></label
                >
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapActions } from "vuex";

export default {
  name: "login",
  data() {
    return {
      user: {
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
      },
      auth: {
        email: "",
        password: "",
        device_name: "browser",
      },
      validationErrors: {},
      processing: false,
    };
  },
  methods: {
    async login() {
      this.processing = true;
      await axios
        .post("/login", this.auth)
        .then(({ data }) => {
          localStorage.setItem("token", data);
          this.$router.push({ name: "countriesList" });
        })
        .catch(({ response }) => {
          this.validationErrors = response.data.errors;
        })
        .finally(() => {
          this.processing = false;
        });
    },
  },
};
</script>