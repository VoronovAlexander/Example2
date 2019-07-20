<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex justify-content-between">
              <div>{{ locale_sections }}</div>
            </div>
          </div>

          <div class="card-body">
            <form @submit.prevent="save">
              <div class="form-group row">
                <label for="name" class="col-md-12 col-form-label">{{ locale_name }}</label>

                <div class="col-md-12">
                  <input
                    type="text"
                    :class="{
                        'form-control': true,
                        'is-invalid': findErrorsForField('name').length > 0 
                    }"
                    required
                    autofocus
                    v-model="section.name"
                  />

                  <div
                    class="invalid-feedback"
                  >{{ findErrorsForField('name').map(error => error.description).join(' ') }}</div>
                </div>
              </div>

              <div class="form-group row">
                <label for="description" class="col-md-12 col-form-label">{{ locale_description }}</label>

                <div class="col-md-12">
                  <textarea
                    :class="{
                        'form-control': true,
                        'is-invalid': findErrorsForField('description').length > 0 
                    }"
                    required
                    v-model="section.description"
                  />

                  <div
                    class="invalid-feedback"
                  >{{ findErrorsForField('description').map(error => error.description).join(' ') }}</div>
                </div>
              </div>

              <div class="form-group row">
                <label for="logo" class="col-md-12 col-form-label">{{ locale_logo }}</label>

                <div class="col-md-12">
                  <input
                    type="file"
                    :class="{
                        'form-control': true,
                        'is-invalid': findErrorsForField('logo').length > 0 
                    }"
                    @change="logo = $event.target.files[0]"
                  />

                  <div
                    class="invalid-feedback"
                  >{{ findErrorsForField('logo').map(error => error.description).join(' ') }}</div>
                </div>
              </div>

              <div class="form-group row users-checkboxes-group mb-0">
                <h3>
                  <label for="user_ids" class="col-md-12 col-form-label">{{ locale_users }}</label>
                </h3>

                <div v-for="user in users" :key="user.id">
                  <label>
                    <input
                      type="checkbox"
                      :id="`user_${user.id}`"
                      :value="user.id"
                      v-model="checkedUsers"
                    />
                    {{ user.name }}
                  </label>
                  <br />
                </div>

                <div class="col-md-12"></div>
              </div>

              <div class="row">
                <div class="col-12">
                  <hr />
                </div>
              </div>

              <div class="form-group row mb-0">
                <div class="col-md-12">
                  <button type="submit" class="btn btn-primary">{{ locale_send }}</button>
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
export default {
  props: {
    section: {
      type: Object,
      default: () => ({
        name: "",
        description: "",
        logo: null,
        user_ids: []
      })
    },
    locale_sections: {
      type: String
    },
    locale_users: {
      type: String
    },
    locale_name: {
      type: String
    },
    locale_email: {
      type: String
    },
    locale_password: {
      type: String
    },
    locale_description: {
      type: String
    },
    locale_logo: {
      type: String
    },
    locale_send: {
      type: String
    }
  },
  data() {
    return {
      errors: [],
      users: [],
      checkedUsers: [],
      logo: null
    };
  },
  async created() {
    await this.getUsers();
    this.checkedUsers = this.section.users.map(user => user.id);
  },
  methods: {
    async getUsers() {
      let { data } = await axios.get(`/api/v1/users/all`);
      if (data.status === false) {
        console.warn("Error");
        return;
      }
      this.users = data.data;
      return this.users;
    },
    async save() {

      let post = new FormData();

      // наполняем FormData данными 
      for (let key in this.section) {
        post.set(key, this.section[key]);
      }

      // Переносим в FormData массив идентификаторов пользователей
      for (let checkedUser of this.checkedUsers) {
        post.append("user_ids[]", checkedUser);
      }

      // Удаляем грязь
      post.delete("users");
      post.delete("user_ids");
      post.delete("logo");

      if (this.logo) {
        // Если выбрано изображение - добавляем в FormData
        post.append("logo", this.logo);
      }

      let params = {
        headers: {
          "Content-Type": "multipart/form-data"
        }
      };

      let { data } = this.section.id
        ? await axios.post(`/api/v1/sections/${this.section.id}`, post, params) // это д.б PUT, но, кажется, внутри axios баг, из-за которого он не может отправить FormData
        : await axios.post("/api/v1/sections", post, params);

      if (data.status === false) {
        console.warn("Error");
        this.errors = data.errors;
        return;
      }
      window.location = "/sections";
    },
    findErrorsForField(fieldName) {
      let errors = this.errors.filter(error => error.field == fieldName);
      return errors;
    }
  }
};
</script>
<style>
.users-checkboxes-group {
  display: flex;
  flex-direction: column;
  margin-left: 15px;
}
</style>
