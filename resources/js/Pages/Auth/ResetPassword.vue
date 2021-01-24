<template>
  <guest-layout>
    <template #header>
      Reset Password
    </template>

    <b-container>
      <jet-validation-errors class="mb-4" />

      <form @submit.prevent="submit">
        <div>
          <jet-label
            for="email"
            value="Email"
          />
          <b-input
            id="email"
            v-model="form.email"
            type="email"
            required
            autofocus
          />
        </div>

        <div class="mt-4">
          <jet-label
            for="password"
            value="Password"
          />
          <b-input
            id="password"
            v-model="form.password"
            type="password"
            required
          />
        </div>

        <div class="mt-4">
          <jet-label
            for="password_confirmation"
            value="Confirm Password"
          />
          <b-input
            id="password_confirmation"
            v-model="form.password_confirmation"
            type="password"
            required
          />
        </div>

        <b-button
          :disabled="form.processing"
          @click.prevent="submit"
        >
          Reset Password
          </b-button>
      </form>
    </b-container>
  </guest-layout>
</template>

<script>
import JetLabel from '@/Jetstream/Label'
import JetValidationErrors from '@/Jetstream/ValidationErrors'
import GuestLayout from '@/Layouts/GuestLayout.vue'

export default {
  components: {
    JetLabel,
    JetValidationErrors,
    GuestLayout
  },

  props: {
    email: String,
    token: String
  },

  data () {
    return {
      form: this.$inertia.form({
        token: this.token,
        email: this.email,
        password: '',
        password_confirmation: ''
      })
    }
  },

  methods: {
    submit () {
      this.form.post(this.route('password.update'), {
        onFinish: () => this.form.reset('password', 'password_confirmation')
      })
    }
  }
}
</script>
