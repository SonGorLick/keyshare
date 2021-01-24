<template>
  <jet-action-section>
    <template #title>
      Delete Team
    </template>

    <template #description>
      Permanently delete this team.
    </template>

    <template #content>
      <div class="max-w-xl text-sm text-gray-600">
        Once a team is deleted, all of its resources and data will be permanently deleted. Before deleting this team, please download any data or information regarding this team that you wish to retain.
      </div>

      <b-button
        variant="danger"
        @click.prevent="confirmTeamDeletion"
      >
        Delete Team
      </b-button>

      <!-- Delete Team Confirmation Modal -->
      <jet-modal
        :show="confirmingTeamDeletion"
        @close="confirmingTeamDeletion = false"
      >
        <template #title>
          Delete Team
        </template>

        <template #content>
          Are you sure you want to delete this team? Once a team is deleted, all of its resources and data will be permanently deleted.
        </template>

        <template #footer>
          <b-button @click.prevent="confirmingTeamDeletion = false">
            Nevermind
          </b-button>

          <b-button
            :disabled="form.processing"
            variant="danger"
            @click.prevent="deleteTeam"
          >
            Delete Team
          </b-button>
        </template>
      </jet-modal>
    </template>
  </jet-action-section>
</template>

<script>
import JetActionSection from '@/Jetstream/ActionSection'
import JetModal from '@/Jetstream/Modal'

export default {

  components: {
    JetActionSection,
    JetModal
  },
  props: ['team'],

  data () {
    return {
      confirmingTeamDeletion: false,
      deleting: false,

      form: this.$inertia.form()
    }
  },

  methods: {
    confirmTeamDeletion () {
      this.confirmingTeamDeletion = true
    },

    deleteTeam () {
      this.form.delete(route('teams.destroy', this.team), {
        errorBag: 'deleteTeam'
      })
    }
  }
}
</script>
