<template>
  <app-layout>
    <template #header>
      <h2>
        Profile
      </h2>
    </template>

    <b-container>
      <div v-if="$page.props.jetstream.canUpdateProfileInformation">
        <update-profile-information-form :user="$page.props.user" />

        <jet-section-border />
      </div>

      <div v-if="$page.props.jetstream.canUpdatePassword">
        <update-password-form />

        <jet-section-border />
      </div>

      <div v-if="$page.props.jetstream.canManageTwoFactorAuthentication">
        <two-factor-authentication-form />

        <jet-section-border />
      </div>

      <logout-other-browser-sessions-form
        :sessions="sessions"
      />

      <template v-if="$page.props.jetstream.hasAccountDeletionFeatures">
        <jet-section-border />

        <delete-user-form />
      </template>
    </b-container>
  </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import DeleteUserForm from './DeleteUserForm'
import JetSectionBorder from '@/Jetstream/SectionBorder'
import LogoutOtherBrowserSessionsForm from './LogoutOtherBrowserSessionsForm'
import TwoFactorAuthenticationForm from './TwoFactorAuthenticationForm'
import UpdatePasswordForm from './UpdatePasswordForm'
import UpdateProfileInformationForm from './UpdateProfileInformationForm'

export default {

  components: {
    AppLayout,
    DeleteUserForm,
    JetSectionBorder,
    LogoutOtherBrowserSessionsForm,
    TwoFactorAuthenticationForm,
    UpdatePasswordForm,
    UpdateProfileInformationForm
  },
  props: ['sessions']
}
</script>
