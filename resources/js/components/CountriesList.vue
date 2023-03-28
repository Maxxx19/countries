<template>
  <div class="container">
    <div class="row ml-5">
      <select name="continents" @change="change" class="form-select w-25 m-3">
        <option value="" disabled selected>Continent filtration</option>
        <option
          v-for="continent in continents"
          :value="continent.code"
          v-bind:key="continent.id"
        >
          {{ continent.name }}
        </option>
      </select>
      <select name="sorting" @change="sort" class="form-select w-25 m-3">
        <option value="sort" disabled selected>Sorting</option>
        <option value="ASC">ASC</option>
        <option value="DESC">DESC</option>
      </select>
    </div>
    <table class="table table-bordered table-hover countries">
      <thead>
        <tr>
          <th width="50">Id</th>
          <th>Code</th>
          <th>Name</th>
          <th>Full Name</th>
          <th>ISO3</th>
          <th>Number</th>
          <th>Continent Code</th>
          <th>Display Order</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="country in countries" v-bind:key="country.country_id">
          <td v-text="country.country_id"></td>
          <td v-text="country.code"></td>
          <td>
            <router-link
              class="link"
              :to="{ name: 'country', params: { id: country.country_id } }"
              >{{ country.name }}
            </router-link>
          </td>
          <td v-text="country.full_name"></td>
          <td v-text="country.iso3"></td>
          <td v-text="country.number"></td>
          <td v-text="country.continent_code"></td>
          <td v-text="country.display_order"></td>
        </tr>
      </tbody>
    </table>
    <div class="row text-center">
      <div class="col-12 m-3">
        <button
          class="btn btn-primary btn-block"
          @click="$router.push('/create_country')"
        >
          Create new country
        </button>
      </div>
    </div>

    <paginate
      :page-count="this.pages"
      :prev-text="'Prev'"
      :next-text="'Next'"
      :page-range="this.pages"
      :margin-pages="2"
      :click-handler="list"
      :container-class="'pagination'"
      :page-class="'page-item'"
    ></paginate>
  </div>
</template>
<script>
import Paginate from "vuejs-paginate-next";
export default {
  name: "countriesList",
  components: {
    Paginate,
  },
  data() {
    return {
      countries: undefined,
      pages: 1,
      selected: 1,
      continents: [],
      continent: 0,
      sorting: 0,
      token: localStorage.getItem("token"),
    };
  },
  mounted() {
    window.axios.defaults.headers.common[
      "Authorization"
    ] = `Bearer ${this.token}`;
    this.list();
    this.GetContinents();
  },
  methods: {
    list(page = 1, continent = this.continent, sorting = this.sorting) {
      axios
        .get(`/countries/` + continent + `/` + sorting + `?page=${page}`)
        .then(({ data }) => {
          let result = JSON.parse(JSON.stringify(data));
          this.countries = result.countries.data;
          this.pages = result.countries.last_page;
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
      this.continent = event.target.value;
      this.$store.dispatch("current_continent", event.target.value);
      this.$store.dispatch("logout");
      this.list(1, event.target.value);
    },
    sort(event) {
      this.sorting = event.target.value;
      this.list(1, this.continent, this.sorting);
    },
  },
};
</script>