<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex justify-content-between">
              <div>{{ locale_users }}</div>
            </div>
          </div>

          <div class="card-body">
            <form>
              <div class="form-group row">
                <label for="name" class="col-md-12 col-form-label">{{ locale_name }}</label>

                <div class="col-md-12">
                  <input
                    id="name"
                    type="text"
                    :class="{
                        'form-control': true,
                        'is-invalid': findErrorsForField('name').length > 0 
                    }"
                    name="name"
                    required
                    autofocus
                    v-model="user.name"
                  />

                  <div
                    class="invalid-feedback"
                  >{{ findErrorsForField('name').map(error => error.description).join(' ') }}</div>
                </div>
              </div>

              <div class="form-group row">
                <label for="email" class="col-md-12 col-form-label">{{ locale_email }}</label>

                <div class="col-md-12">
                  <input
                    id="email"
                    type="email"
                    :class="{
                        'form-control': true,
                        'is-invalid': findErrorsForField('email').length > 0 
                    }"
                    name="email"
                    required
                    autocomplete="email"
                    autofocus
                    v-model="user.email"
                  />

                  <div
                    class="invalid-feedback"
                  >{{ findErrorsForField('email').map(error => error.description).join(' ') }}</div>
                </div>
              </div>

              <div class="form-group row">
                <label for="password" class="col-md-12 col-form-label">{{ locale_password }}</label>

                <div class="col-md-12 mb-0">
                  <input
                    id="password"
                    type="password"
                    :class="{
                        'form-control': true,
                        'is-invalid': findErrorsForField('password').length > 0 
                    }"
                    name="password"
                    required
                    autocomplete="password"
                    autofocus
                    v-model="user.password"
                  />

                  <div
                    class="invalid-feedback"
                  >{{ findErrorsForField('password').map(error => error.description).join(' ') }}</div>
                </div>
              </div>

              <div class="row">
                <div class="col-12">
                  <hr />
                </div>
              </div>

              <div class="form-group row mb-0">
                <div class="col-md-12">
                  <button
                    @click.prevent="save"
                    type="submit"
                    class="btn btn-primary"
                  >{{ locale_send }}</button>
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
    user: {
      type: Object,
      default: () => ({
        name: "",
        email: "",
        password: ""
      })
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
    locale_send: {
      type: String
    }
  },
  data() {
    return {
      errors: []
    };
  },
  methods: {
    async save() {
      let { data } = this.user.id
        ? await axios.put(`/api/v1/users/${this.user.id}`, this.user)
        : await axios.post("/api/v1/users", this.user);

      if (data.status === false) {
        console.warn("Error");
        this.errors = data.errors;
        return;
      }
      window.location = "/users";
    },
    findErrorsForField(fieldName) {
      let errors = this.errors.filter(error => error.field == fieldName);
      return errors;
    }
  },
  computed: {}
};
</script>
