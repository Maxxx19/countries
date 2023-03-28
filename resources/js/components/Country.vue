<template>
  <div class="card m-5">
    <div v-if="country">
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
          <tr>
            <td v-text="country.country_id"></td>
            <td v-text="country.code"></td>
            <td v-text="country.name"></td>
            <td v-text="country.full_name"></td>
            <td v-text="country.iso3"></td>
            <td v-text="country.number"></td>
            <td v-text="country.continent_code"></td>
            <td v-text="country.display_order"></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="col-6 m-3">
      <button class="btn btn-primary btn-block" @click="$router.go(-1)">
        Back
      </button>
    </div>
  </div>
</template>
<script>
import axios from "axios";
export default {
  name: "Country",
  props: ["id"],
  data() {
    return {
      country: null,
    };
  },
  methods: {
    async getCountry(id) {
      await axios("/country/" + id)
        .then((response) => {
          this.country = response.data.country;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  created() {
    this.getCountry(this.id);
  },
};
</script>
