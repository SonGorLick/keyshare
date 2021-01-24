<template>
  <guest-layout>
    <template #header>
      Forgot Password
    </template>
    <b-container>
      Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.

      <div v-if="status">
        {{ status }}
      </div>

      <jet-validation-errors />

      <form @submit.prevent="submit">
        <b-form-group
          id="email"
          label="Email address:"
          label-for="email"
        >
          <b-form-input
            id="email"
            v-model="form.email"
            type="email"
            required
            autofocus
          />
        </b-form-group>

        <b-button
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
          type="submit"
          variant="primary"
        >
          Email Password Reset Link
        </b-button>
        <b-link :href="route('login')">
          Login
        </b-link>
      </form>
    </b-container>
  </guest-layout>
</template>

<script>
import JetValidationErrors from '@/Jetstream/ValidationErrors'
import GuestLayout from '@/Layouts/GuestLayout'

export default {
  components: {
    JetValidationErrors,
    GuestLayout
  },

  props: {
    status: String
  },

  data () {
    return {
      form: this.$inertia.form({
        email: ''
      })
    }
  },

  methods: {
    submit () {
      this.form.post(this.route('password.email'))
    }
  }
}
</script>
