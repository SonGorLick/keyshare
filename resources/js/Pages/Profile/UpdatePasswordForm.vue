<template>
  <jet-form-section @submitted="updatePassword">
    <template #title>
      Update Password
    </template>

    <template #description>
      Ensure your account is using a long, random password to stay secure.
    </template>

    <template #form>
      <div class="col-span-6 sm:col-span-4">
        <jet-label
          for="current_password"
          value="Current Password"
        />
        <b-input
          id="current_password"
          ref="current_password"
          v-model="form.current_password"
          type="password"
        />
        <jet-input-error
          :message="form.errors.current_password"
          class="mt-2"
        />
      </div>

      <div class="col-span-6 sm:col-span-4">
        <jet-label
          for="password"
          value="New Password"
        />
        <b-input
          id="password"
          ref="password"
          v-model="form.password"
          type="password"
        />
        <jet-input-error
          :message="form.errors.password"
          class="mt-2"
        />
      </div>

      <div class="col-span-6 sm:col-span-4">
        <jet-label
          for="password_confirmation"
          value="Confirm Password"
        />
        <b-input
          id="password_confirmation"
          v-model="form.password_confirmation"
          type="password"
        />
        <jet-input-error
          :message="form.errors.password_confirmation"
          class="mt-2"
        />
      </div>
    </template>

    <template #actions>
      <jet-action-message
        :on="form.recentlySuccessful"
        class="mr-3"
      >
        Saved.
      </jet-action-message>

      <b-button
        :disabled="form.processing"
        @click.prevent="updatePassword"
      >
        Save
      </b-button>
    </template>
  </jet-form-section>
</template>

<script>
import JetActionMessage from '@/Jetstream/ActionMessage'
import JetFormSection from '@/Jetstream/FormSection'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'

export default {
  components: {
    JetActionMessage,
    JetFormSection,
    JetInputError,
    JetLabel
  },

  data () {
    return {
      form: this.$inertia.form({
        current_password: '',
        password: '',
        password_confirmation: ''
      })
    }
  },

  methods: {
    updatePassword () {
      this.form.put(route('user-password.update'), {
        errorBag: 'updatePassword',
        preserveScroll: true,
        onSuccess: () => this.form.reset(),
        onError: () => {
          if (this.form.errors.password) {
            this.form.reset('password', 'password_confirmation')
            this.$refs.password.focus()
          }

          if (this.form.errors.current_password) {
            this.form.reset('current_password')
            this.$refs.current_password.focus()
          }
        }
      })
    }
  }
}
</script>
