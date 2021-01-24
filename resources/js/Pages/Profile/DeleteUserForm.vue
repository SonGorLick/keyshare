<template>
  <jet-action-section>
    <template #title>
      Delete Account
    </template>

    <template #description>
      Permanently delete your account.
    </template>

    <template #content>
      <div>
        Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
      </div>

      <b-button
        variant="danger"
        @click.prevent="confirmUserDeletion"
      >
        Delete Account
      </b-button>

      <!-- Delete Account Confirmation Modal -->
      <jet-modal
        :show="confirmingUserDeletion"
        @close="closeModal"
      >
        <template #title>
          Delete Account
        </template>

        <template #content>
          Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.

          <div class="mt-4">
            <b-input
              ref="password"
              v-model="form.password"
              type="password"
              placeholder="Password"
              @keyup.enter.native="deleteUser"
            />

            <jet-input-error
              :message="form.errors.password"
              class="mt-2"
            />
          </div>
        </template>

        <template #footer>
          <jet-secondary-button @click.native="closeModal">
            Nevermind
          </jet-secondary-button>

          <b-button
            variant="danger"
            :disabled="form.processing"
            @click.native="deleteUser"
          >
            Delete Account
          </b-button>
        </template>
      </jet-modal>
    </template>
  </jet-action-section>
</template>

<script>
import JetActionSection from '@/Jetstream/ActionSection'
import JetModal from '@/Jetstream/Modal'
import JetInputError from '@/Jetstream/InputError'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'

export default {
  components: {
    JetActionSection,
    JetModal,
    JetInputError,
    JetSecondaryButton
  },

  data () {
    return {
      confirmingUserDeletion: false,

      form: this.$inertia.form({
        password: ''
      })
    }
  },

  methods: {
    confirmUserDeletion () {
      this.confirmingUserDeletion = true

      setTimeout(() => this.$refs.password.focus(), 250)
    },

    deleteUser () {
      this.form.delete(route('current-user.destroy'), {
        preserveScroll: true,
        onSuccess: () => this.closeModal(),
        onError: () => this.$refs.password.focus(),
        onFinish: () => this.form.reset()
      })
    },

    closeModal () {
      this.confirmingUserDeletion = false

      this.form.reset()
    }
  }
}
</script>
