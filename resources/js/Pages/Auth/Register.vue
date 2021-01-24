<template>
  <guest-layout>
    <template #header>
      Register
    </template>

    <b-container>
      <jet-validation-errors />

      <form @submit.prevent="submit">
        <b-form-group
          id="name"
          label="Name:"
          label-for="name"
        >
          <b-form-input
            id="name"
            v-model="form.name"
            type="text"
            required
            autofocus
            autocomplete="name"
          />
        </b-form-group>

        <b-form-group
          id="email"
          label="Email:"
          label-for="email"
        >
          <b-form-input
            id="email"
            v-model="form.email"
            type="email"
            required
          />
        </b-form-group>

        <b-form-group
          id="password"
          label="Password:"
          label-for="password"
        >
          <b-form-input
            id="password"
            v-model="form.password"
            type="password"
            required
            autocomplete="new-password"
          />
        </b-form-group>

        <b-form-group
          id="password_confirmation"
          label="Confirm Password:"
          label-for="password_confirmation"
        >
          <b-form-input
            id="password_confirmation"
            v-model="form.password_confirmation"
            type="password"
            required
            autocomplete="new-password"
          />
        </b-form-group>

        <div
          v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature"
          class="mt-4"
        >
          <jet-label for="terms">
            <div class="flex items-center">
              <b-checkbox
                id="terms"
                v-model="form.terms"
                name="terms"
              />

              <div class="ml-2">
                I agree to the <a
                  target="_blank"
                  :href="route('terms.show')"
                  class="underline text-sm text-gray-600 hover:text-gray-900"
                >Terms of Service</a> and <a
                  target="_blank"
                  :href="route('policy.show')"
                  class="underline text-sm text-gray-600 hover:text-gray-900"
                >Privacy Policy</a>
              </div>
            </div>
          </jet-label>
        </div>

        <div class="flex items-center justify-end mt-4">
          <b-button
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
            variant="primary"
            type="submit"
          >
            Register
          </b-button>
          <b-link :href="route('login')">
            Already registered?
          </b-link>
        </div>
      </form>
    </b-container>
  </guest-layout>
</template>

<script>
import JetLabel from '@/Jetstream/Label'
import JetValidationErrors from '@/Jetstream/ValidationErrors'
import GuestLayout from '@/Layouts/GuestLayout'

export default {
  components: {
    JetLabel,
    JetValidationErrors,
    GuestLayout
  },

  data () {
    return {
      form: this.$inertia.form({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        terms: false
      })
    }
  },

  methods: {
    submit () {
      this.form.post(this.route('register'), {
        onFinish: () => this.form.reset('password', 'password_confirmation')
      })
    }
  }
}
</script>
