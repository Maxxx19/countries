<template>
  <div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav me-auto">
            <li class="nav-item">
              <router-link
                :to="{ name: 'countriesList' }"
                class="nav-link"
                >Home <span class="sr-only"></span
              ></router-link>
            </li>
          </ul>
          <div class="d-flex">
            <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a
                  class="nav-link dropdown-toggle"
                  href="#"
                  id="navbarDropdownMenuLink"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                >
                </a>
                <div
                  class="dropdown-menu dropdown-menu-end"
                  aria-labelledby="navbarDropdownMenuLink"
                >
                  <a
                    class="dropdown-item"
                    href="javascript:void(0)"
                    @click="logout"
                    >Logout</a
                  >
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
    <main class="mt-3">
      <router-view></router-view>
    </main>
  </div>
</template>
<script>
import { mapActions } from "vuex";
export default {
  name: "default-layout",
  data() {
    return {
      token: localStorage.getItem("token"),
    };
  },
  mounted() {
    window.axios.defaults.headers.common[
      "Authorization"
    ] = `Bearer ${this.token}`;
  },
  methods: {
    ...mapActions({
      signOut: "auth/logout",
    }),
    async logout() {
      await axios.post("/logout", this.user).then(({ data }) => {
        this.signOut();
        this.$router.push({ name: "login" });
      });
    },
  },
};
</script>
