<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Team Settings
      </h2>
    </template>

    <b-container>
      <update-team-name-form
        :team="team"
        :permissions="permissions"
      />

      <team-member-manager
        class="mt-10 sm:mt-0"
        :team="team"
        :available-roles="availableRoles"
        :user-permissions="permissions"
      />

      <template v-if="permissions.canDeleteTeam && ! team.personal_team">
        <jet-section-border />

        <delete-team-form
          class="mt-10 sm:mt-0"
          :team="team"
        />
      </template>
    </b-container>
  </app-layout>
</template>

<script>
import TeamMemberManager from './TeamMemberManager'
import AppLayout from '@/Layouts/AppLayout'
import DeleteTeamForm from './DeleteTeamForm'
import JetSectionBorder from '@/Jetstream/SectionBorder'
import UpdateTeamNameForm from './UpdateTeamNameForm'

export default {

  components: {
    AppLayout,
    DeleteTeamForm,
    JetSectionBorder,
    TeamMemberManager,
    UpdateTeamNameForm
  },
  props: [
    'team',
    'availableRoles',
    'permissions'
  ]
}
</script>
