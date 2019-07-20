<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex justify-content-between">
              <div>{{ locale_sections }}</div>
              <div>
                <a class="btn btn-sm btn-primary" href="/sections/create">{{ locale_add }}</a>
              </div>
            </div>
          </div>

          <div class="card-body">
            <table class="table">
              <thead></thead>
              <tbody>
                <tr v-for="section in data" :key="section.id">
                  <td>
                    <img width="150" height="150" :src="section.logo" alt />
                  </td>
                  <td>
                    <b>{{ section.name }}</b>
                    <br />
                    {{ section.description.length > 70 ? section.description.slice(0,70) + '...' : section.description }}
                  </td>
                  <td>
                    <b>{{ locale_users}}</b>
                    <ol>
                      <li v-for="user in section.users" :key="user.id">{{user.name}}</li>
                    </ol>
                  </td>
                  <td>
                    <a
                      :href="`/sections/${section.id}/edit`"
                      class="btn btn-sm btn-secondary"
                    >{{ locale_edit }}</a>
                    <button
                      @click="deleteSection(section.id)"
                      class="btn btn-sm btn-danger"
                    >{{ locale_delete }}</button>
                  </td>
                </tr>
              </tbody>
            </table>

            <b-pagination
              :total-rows="total"
              :per-page="10"
              v-model="current_page"
              @input="paginate"
              prev-text="<"
              next-text=">"
              hide-goto-end-buttons
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    locale_sections: {
      type: String
    },
    locale_users: {
      type: String
    },
    locale_edit: {
      type: String
    },
    locale_delete: {
      type: String
    },
    locale_add: {
      type: String
    }
  },
  data() {
    return {
      data: null,
      total: 0,
      current_page: 1,
      per_page: 10
    };
  },
  async created() {
    this.paginate(this.current_page);
  },
  methods: {
    async paginate(page) {
      let { data } = await axios.get(`/api/v1/sections?page=${page}`);
      if (data.status == false) {
        return console.warn("Error");
      }
      this.data = data.data.items;
      this.current_page = data.data.meta.current_page;
      this.per_page = data.data.meta.per_page;
      this.total = data.data.meta.total;
    },
    async deleteSection(sectionId) {
      let { data } = await axios.delete(`/api/v1/sections/${sectionId}`);
      if (data.status == false) {
        return console.warn("Error");
      }
      this.paginate(this.current_page);
    }
  }
};
</script>

<style>
table > thead {
  display: none !important;
}
</style>
