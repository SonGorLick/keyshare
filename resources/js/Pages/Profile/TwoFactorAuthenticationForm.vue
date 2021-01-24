<template>
  <jet-action-section>
    <template #title>
      Two Factor Authentication
    </template>

    <template #description>
      Add additional security to your account using two factor authentication.
    </template>

    <template #content>
      <h3
        v-if="twoFactorEnabled"
      >
        You have enabled two factor authentication.
      </h3>

      <h3
        v-else
      >
        You have not enabled two factor authentication.
      </h3>

      <div>
        <p>
          When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone's Google Authenticator application.
        </p>
      </div>

      <div v-if="twoFactorEnabled">
        <div v-if="qrCode">
          <div>
            <p>
              Two factor authentication is now enabled. Scan the following QR code using your phone's authenticator application.
            </p>
          </div>

          <div
            v-html="qrCode"
          />
        </div>

        <div v-if="recoveryCodes.length > 0">
          <div>
            <p>
              Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.
            </p>
          </div>

          <div>
            <div
              v-for="code in recoveryCodes"
              :key="code"
            >
              {{ code }}
            </div>
          </div>
        </div>
      </div>

      <div class="mt-5">
        <div v-if="! twoFactorEnabled">
          <jet-confirms-password @confirmed="enableTwoFactorAuthentication">
            <jet-button
              type="button"
              :class="{ 'opacity-25': enabling }"
              :disabled="enabling"
            >
              Enable
            </jet-button>
          </jet-confirms-password>
        </div>

        <div v-else>
          <jet-confirms-password @confirmed="regenerateRecoveryCodes">
            <b-button
              v-if="recoveryCodes.length > 0"
            >
              Regenerate Recovery Codes
            </b-button>
          </jet-confirms-password>

          <jet-confirms-password @confirmed="showRecoveryCodes">
            <b-button
              v-if="recoveryCodes.length === 0"
              class="mr-3"
            >
              Show Recovery Codes
            </b-button>
          </jet-confirms-password>

          <jet-confirms-password @confirmed="disableTwoFactorAuthentication">
            <b-button
              variant="danger"
              :disabled="disabling"
            >
              Disable
            </b-button>
          </jet-confirms-password>
        </div>
      </div>
    </template>
  </jet-action-section>
</template>

<script>
import JetActionSection from '@/Jetstream/ActionSection'
import JetButton from '@/Jetstream/Button'
import JetConfirmsPassword from '@/Jetstream/ConfirmsPassword'

export default {
  components: {
    JetActionSection,
    JetButton,
    JetConfirmsPassword
  },

  data () {
    return {
      enabling: false,
      disabling: false,

      qrCode: null,
      recoveryCodes: []
    }
  },

  computed: {
    twoFactorEnabled () {
      return !this.enabling && this.$page.props.user.two_factor_enabled
    }
  },

  methods: {
    enableTwoFactorAuthentication () {
      this.enabling = true

      this.$inertia.post('/user/two-factor-authentication', {}, {
        preserveScroll: true,
        onSuccess: () => Promise.all([
          this.showQrCode(),
          this.showRecoveryCodes()
        ]),
        onFinish: () => (this.enabling = false)
      })
    },

    showQrCode () {
      return axios.get('/user/two-factor-qr-code')
        .then(response => {
          this.qrCode = response.data.svg
        })
    },

    showRecoveryCodes () {
      return axios.get('/user/two-factor-recovery-codes')
        .then(response => {
          this.recoveryCodes = response.data
        })
    },

    regenerateRecoveryCodes () {
      axios.post('/user/two-factor-recovery-codes')
        .then(response => {
          this.showRecoveryCodes()
        })
    },

    disableTwoFactorAuthentication () {
      this.disabling = true

      this.$inertia.delete('/user/two-factor-authentication', {
        preserveScroll: true,
        onSuccess: () => (this.disabling = false)
      })
    }
  }
}
</script>
