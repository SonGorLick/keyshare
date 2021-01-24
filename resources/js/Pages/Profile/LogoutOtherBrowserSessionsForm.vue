<template>
  <jet-action-section>
    <template #title>
      Browser Sessions
    </template>

    <template #description>
      Manage and logout your active sessions on other browsers and devices.
    </template>

    <template #content>
      <div>
        If necessary, you may logout of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.
      </div>

      <!-- Other Browser Sessions -->
      <b-list-group v-if="sessions.length > 0">
        <b-list-group-item
          v-for="(session, i) in sessions"
          :key="i"
        >
          <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1">
              {{ session.agent.platform }} - {{ session.agent.browser }}
            </h5>
          </div>
          <p class="mb-1">
            {{ session.ip_address }}
          </p>
          <small
            v-if="session.is_current_device"
          >This device</small>
        </b-list-group-item>
      </b-list-group>

      <div>
        <b-button @click.prevent="confirmLogout">
          Logout Other Browser Sessions
        </b-button>

        <jet-action-message :on="form.recentlySuccessful">
          Done.
        </jet-action-message>
      </div>

      <!-- Logout Other Devices Confirmation Modal -->
      <jet-modal
        :show="confirmingLogout"
        @close="closeModal"
      >
        <template #title>
          Logout Other Browser Sessions
        </template>

        <template #content>
          Please enter your password to confirm you would like to logout of your other browser sessions across all of your devices.

          <div class="mt-4">
            <b-input
              ref="password"
              v-model="form.password"
              type="password"
              placeholder="Password"
              @keyup.enter.prevent="logoutOtherBrowserSessions"
            />

            <jet-input-error
              :message="form.errors.password"
              class="mt-2"
            />
          </div>
        </template>

        <template #footer>
          <b-button @click.prevent="closeModal">
            Nevermind
          </b-button>

          <b-button
            :disabled="form.processing"
            variant="primary"
            @click.prevent="logoutOtherBrowserSessions"
          >
            Logout Other Browser Sessions
          </b-button>
        </template>
      </jet-modal>
    </template>
  </jet-action-section>
</template>

<script>
import JetActionMessage from '@/Jetstream/ActionMessage'
import JetActionSection from '@/Jetstream/ActionSection'
import JetModal from '@/Jetstream/Modal'
import JetInputError from '@/Jetstream/InputError'

export default {

  components: {
    JetActionMessage,
    JetActionSection,
    JetModal,
    JetInputError
  },
  props: ['sessions'],

  data () {
    return {
      confirmingLogout: false,

      form: this.$inertia.form({
        password: ''
      })
    }
  },

  methods: {
    confirmLogout () {
      this.confirmingLogout = true

      setTimeout(() => this.$refs.password.focus(), 250)
    },

    logoutOtherBrowserSessions () {
      this.form.delete(route('other-browser-sessions.destroy'), {
        preserveScroll: true,
        onSuccess: () => this.closeModal(),
        onError: () => this.$refs.password.focus(),
        onFinish: () => this.form.reset()
      })
    },

    closeModal () {
      this.confirmingLogout = false

      this.form.reset()
    }
  }
}
</script>
