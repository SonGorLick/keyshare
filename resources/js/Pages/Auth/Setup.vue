<template>
  <guest-layout>
    <template #header>
      Account Setup
    </template>

    <b-container>
      Your account is nearly there, finish the setup:
      <jet-validation-errors />

      <div v-if="status">
        {{ status }}
      </div>

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
                >Terms of Service</a> and <a
                  target="_blank"
                  :href="route('policy.show')"
                >Privacy Policy</a>
              </div>
            </div>
          </jet-label>
        </div>

        <b-button
          @click="logout"
        >
          Sign Out
        </b-button>
        <b-button
          :disabled="form.processing"
          variant="primary"
          type="submit"
        >
          Finish account Setup
        </b-button>
      </form>
    </b-container>
  </guest-layout>
</template>

<script>
import GuestLayout from '@/Layouts/GuestLayout'

export default {
  components: {
    GuestLayout
  },

  data () {
    return {
      form: this.$inertia.form({
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      })
    }
  },

  methods: {
    logout () {
      this.$inertia.post(route('logout'))
    },

    submit () {
      this.form.put(this.route('login.setup.update'), {
        onFinish: () => this.form.reset('password', 'password_confirmation')
      })
    }
  }

}
</script>
