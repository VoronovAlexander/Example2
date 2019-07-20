<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex justify-content-between">
              <div>{{ locale_users }}</div>
              <div>
                <a class="btn btn-sm btn-primary" href="/users/create">{{ locale_add }}</a>
              </div>
            </div>
          </div>

          <div class="card-body">
            <table class="table">
              <thead></thead>
              <tbody>
                <tr v-for="user in data" :key="user.id">
                  <td>{{ user.name }}</td>
                  <td>{{ user.email }}</td>
                  <td>{{ user.created_at }}</td>
                  <td>
                    <a
                      :href="`/users/${user.id}/edit`"
                      class="btn btn-sm btn-secondary"
                    >{{ locale_edit }}</a>
                    <button
                      @click="deleteUser(user.id)"
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
      let { data } = await axios.get(`/api/v1/users?page=${page}`);
      console.log(data);
      if (data.status == false) {
        return console.warn("Error");
      }
      this.data = data.data.items;
      this.current_page = data.data.meta.current_page;
      this.per_page = data.data.meta.per_page;
      this.total = data.data.meta.total;
    },
    async deleteUser(userId) {
      let { data } = await axios.delete(`/api/v1/users/${userId}`);
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
