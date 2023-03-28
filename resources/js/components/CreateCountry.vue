<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h1 class="text-center">Create Country</h1>
            <hr />
            <form
              action="javascript:void(0)"
              @submit="createCountry"
              class="row"
              method="post"
            >
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
              <div class="form-group col-6">
                <label for="code" class="font-weight-bold">Code</label>
                <input
                  type="text"
                  name="code"
                  v-model="country.code"
                  id="code"
                  placeholder="Enter code"
                  class="form-control"
                />
              </div>
              <div class="form-group col-6 my-2">
                <label for="name" class="font-weight-bold">Name</label>
                <input
                  type="text"
                  name="name"
                  v-model="country.name"
                  id="name"
                  placeholder="Enter country name"
                  class="form-control"
                />
              </div>
              <div class="form-group col-6">
                <label for="full_name" class="font-weight-bold"
                  >Full Name</label
                >
                <input
                  type="text"
                  name="full_name"
                  v-model="country.full_name"
                  id="full_name"
                  placeholder="Enter full country name"
                  class="form-control"
                />
              </div>
              <div class="form-group col-6 my-2">
                <label for="ISO3" class="font-weight-bold">ISO3</label>
                <input
                  type="text"
                  name="ISO3"
                  v-model="country.iso3"
                  id="ISO3"
                  placeholder="Enter ISO3"
                  class="form-control"
                />
              </div>
              <div class="form-group col-6 my-2">
                <label for="number" class="font-weight-bold">Number</label>
                <input
                  type="text"
                  name="number"
                  v-model="country.number"
                  id="number"
                  placeholder="Enter number"
                  class="form-control"
                />
              </div>
              <div class="form-group col-6 my-2">
                <label for="continent_code" class="font-weight-bold"
                  >Continent code</label
                >
                <select
                  name="continent_code"
                  @change="change"
                  v-model="country.continent_code"
                  class="form-select"
                >
                  <option value="" disabled selected>Continents</option>
                  <option
                    v-for="continent in continents"
                    :value="continent.code"
                    v-bind:key="continent.id"
                  >
                    {{ continent.name }}
                  </option>
                </select>
              </div>
              <div class="form-group col-6 my-2">
                <label for="display_order" class="font-weight-bold"
                  >Display order</label
                >
                <input
                  type="text"
                  name="display_order"
                  v-model="country.display_order"
                  id="display_order"
                  placeholder="Enter display order"
                  class="form-control"
                />
              </div>
              <div class="row text-center">
                <div class="col-6 mb-3">
                  <button
                    type="submit"
                    :disabled="processing"
                    class="btn btn-primary btn-block"
                  >
                    {{ processing ? "Please wait" : "Create" }}
                  </button>
                </div>
                <div class="col-6 mb-3">
                  <button
                    class="btn btn-primary btn-block"
                    @click="$router.go(-1)"
                  >
                    Back
                  </button>
                </div>
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
  name: "CreateCountry",
  data() {
    return {
      country: {
        name: "",
        code: "",
        full_name: "",
        iso3: "",
        number: "",
        continent_code: "",
        display_order: "",
      },
      validationErrors: {},
      processing: false,
      continents: "",
    };
  },
  mounted() {
    this.GetContinents();
  },
  methods: {
    ...mapActions({
      signIn: "auth/login",
    }),
    async createCountry() {
      this.processing = true;
      await axios
        .post("/country/create", this.country)
        .then((response) => {
          this.validationErrors = {};
          this.$router.push({ name: "countriesList" });
        })
        .catch(({ response }) => {
          if (response.status === 422) {
            this.validationErrors = response.data.errors;
          } else {
            this.validationErrors = {};
            alert(response.data.message);
          }
        })
        .finally(() => {
          this.processing = false;
        });
    },
    GetContinents() {
      axios.get(`/continents`).then(({ data }) => {
        let result = JSON.parse(JSON.stringify(data));
        this.continents = result.continents;
      });
    },
    change(event) {
      this.continent_code = event.target.value;
    },
  },
};
</script>