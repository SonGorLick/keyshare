<template>
  <guest-layout>
    <template #header>
      Two Factor Authentication
    </template>

    <b-container>
      <div>
        <template v-if="! recovery">
          Please confirm access to your account by entering the authentication code provided by your authenticator application.
        </template>

        <template v-else>
          Please confirm access to your account by entering one of your emergency recovery codes.
        </template>
      </div>

      <jet-validation-errors class="mb-4" />

      <form @submit.prevent="submit">
        <div v-if="! recovery">
          <jet-label
            for="code"
            value="Code"
          />
          <b-input
            id="code"
            ref="code"
            v-model="form.code"
            type="text"
            inputmode="numeric"
            autofocus
          />
        </div>

        <div v-else>
          <jet-label
            for="recovery_code"
            value="Recovery Code"
          />
          <b-input
            id="recovery_code"
            ref="recovery_code"
            v-model="form.recovery_code"
            type="text"
          />
        </div>

        <div>
          <b-button
            type="button"
            @click.prevent="toggleRecovery"
          >
            <template v-if="! recovery">
              Use a recovery code
            </template>

            <template v-else>
              Use an authentication code
            </template>
          </b-button>

          <b-button
            variant="primary"
            :disabled="form.processing"
            @click.prevent="submit"
          >
            Login
          </b-button>
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
      recovery: false,
      form: this.$inertia.form({
        code: '',
        recovery_code: ''
      })
    }
  },

  methods: {
    toggleRecovery () {
      this.recovery ^= true

      this.$nextTick(() => {
        if (this.recovery) {
          this.$refs.recovery_code.focus()
          this.form.code = ''
        } else {
          this.$refs.code.focus()
          this.form.recovery_code = ''
        }
      })
    },

    submit () {
      this.form.post(this.route('two-factor.login'))
    }
  }
}
</script>
