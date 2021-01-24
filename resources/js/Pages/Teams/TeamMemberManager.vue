<template>
  <div>
    <div v-if="userPermissions.canAddTeamMembers">
      <jet-section-border />

      <!-- Add Team Member -->
      <jet-form-section @submitted="addTeamMember">
        <template #title>
          Add Team Member
        </template>

        <template #description>
          Add a new team member to your team, allowing them to collaborate with you.
        </template>

        <template #form>
          <div class="col-span-6">
            <div class="max-w-xl text-sm text-gray-600">
              Please provide the email address of the person you would like to add to this team.
            </div>
          </div>

          <!-- Member Email -->
          <div class="col-span-6 sm:col-span-4">
            <jet-label
              for="email"
              value="Email:"
            />
            <b-input
              id="email"
              v-model="addTeamMemberForm.email"
              type="text"
              class="mt-1 block w-full"
            />
            <jet-input-error
              :message="addTeamMemberForm.errors.email"
              class="mt-2"
            />
          </div>

          <!-- Role -->

          <div
            v-if="availableRoles.length > 0"
            class="col-span-6 lg:col-span-4"
          >
            <jet-label
              for="roles"
              value="Role:"
            />
            <jet-input-error
              :message="addTeamMemberForm.errors.role"
              class="mt-2"
            />

            <b-list-group>
              <b-list-group-item
                v-for="role in availableRoles"
                :key="role.key"
                :active="addTeamMemberForm.role == role.key"
                class="flex-column align-items-start"
                style="cursor: pointer;"
                @click="addTeamMemberForm.role = role.key"
              >
                <div class="d-flex w-100 justify-content-between">
                  <h5 class="mb-1">
                    {{ role.name }}
                  </h5>
                </div>
                <p class="mb-1">
                  {{ role.description }}
                </p>
              </b-list-group-item>
            </b-list-group>
          </div>
        </template>

        <template #actions>
          <jet-action-message
            :on="addTeamMemberForm.recentlySuccessful"
            class="mr-3"
          >
            Added.
          </jet-action-message>

          <b-button
            :disabled="addTeamMemberForm.processing"
            @click.prevent="addTeamMember"
          >
            Add
          </b-button>
        </template>
      </jet-form-section>
    </div>

    <div v-if="team.team_invitations.length > 0 && userPermissions.canAddTeamMembers">
      <jet-section-border />

      <!-- Team Member Invitations -->
      <jet-action-section class="mt-10 sm:mt-0">
        <template #title>
          Pending Team Invitations
        </template>

        <template #description>
          These people have been invited to your team and have been sent an invitation email. They may join the team by accepting the email invitation.
        </template>

        <!-- Pending Team Member Invitation List -->
        <template #content>
          <div>
            <div
              v-for="invitation in team.team_invitations"
              :key="invitation.id"
              class="flex items-center justify-between"
            >
              <b-card>
                <b-media>
                  <template #aside>
                    <b-img
                      blank
                      blank-color="#ccc"
                      width="64"
                    />
                  </template>

                  <h5 class="mt-0">
                    {{ invitation.email }}
                  </h5>
                  <b-button
                    v-if="userPermissions.canRemoveTeamMembers"
                    @click="cancelTeamInvitation(invitation)"
                  >
                    Cancel
                  </b-button>
                </b-media>
              </b-card>
            </div>
          </div>
        </template>
      </jet-action-section>
    </div>

    <div v-if="team.users.length > 0">
      <jet-section-border />

      <!-- Manage Team Members -->
      <jet-action-section>
        <template #title>
          Team Members
        </template>

        <template #description>
          All of the people that are part of this team.
        </template>

        <!-- Team Member List -->
        <template #content>
          <div class="space-y-6">
            <div
              v-for="user in team.users"
              :key="user.id"
              class="flex items-center justify-between"
            >
              <b-card>
                <b-media>
                  <template #aside>
                    <b-avatar
                      :src="user.profile_photo_url"
                      size="3rem"
                      rounded
                    />
                  </template>

                  <h5 class="mt-0">
                    {{ user.name }}
                  </h5>
                  <b-button
                    v-if="userPermissions.canAddTeamMembers && availableRoles.length"
                    @click="manageRole(user)"
                  >
                    {{ displayableRole(user.membership.role) }}
                  </b-button>

                  <div
                    v-else-if="availableRoles.length"
                  >
                    {{ displayableRole(user.membership.role) }}
                  </div>

                  <!-- Leave Team -->
                  <b-button
                    v-if="$page.props.user.id === user.id"
                    variant="danger"
                    @click.prevent="confirmLeavingTeam"
                  >
                    Leave
                  </b-button>

                  <!-- Remove Team Member -->
                  <b-button
                    v-if="userPermissions.canRemoveTeamMembers"
                    @click.prevent="confirmTeamMemberRemoval(user)"
                  >
                    Remove
                  </b-button>
                </b-media>
              </b-card>
            </div>
          </div>
        </template>
      </jet-action-section>
    </div>

    <!-- Role Management Modal -->
    <jet-modal
      :show="currentlyManagingRole"
      @close="currentlyManagingRole = false"
    >
      <template #title>
        Manage Role
      </template>

      <template #content>
        <div v-if="managingRoleFor">
          <b-list-group>
            <b-list-group-item
              v-for="role in availableRoles"
              :key="role.key"
              :active="updateRoleForm.role === role.key"
              class="flex-column align-items-start"
              style="cursor: pointer;"
              @click.prevent="updateRoleForm.role = role.key"
            >
              <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">
                  {{ role.name }}
                </h5>
              </div>
              <p class="mb-1">
                {{ role.description }}
              </p>
            </b-list-group-item>
          </b-list-group>
        </div>
      </template>

      <template #footer>
        <jet-secondary-button @click.native="currentlyManagingRole = false">
          Nevermind
        </jet-secondary-button>

        <b-button
          :disabled="updateRoleForm.processing"
          @click.prevent="updateRole"
        >
          Save
        </b-button>
      </template>
    </jet-modal>

    <!-- Leave Team Confirmation Modal -->
    <jet-modal
      :show="confirmingLeavingTeam"
      @close="confirmingLeavingTeam = false"
    >
      <template #title>
        Leave Team
      </template>

      <template #content>
        Are you sure you would like to leave this team?
      </template>

      <template #footer>
        <b-button @click.prevent="confirmingLeavingTeam = false">
          Nevermind
        </b-button>

        <b-button
          variant="danger"
          :disabled="leaveTeamForm.processing"
          @click.prevent="leaveTeam"
        >
          Leave
        </b-button>
      </template>
    </jet-modal>

    <!-- Remove Team Member Confirmation Modal -->
    <jet-modal
      :show="teamMemberBeingRemoved"
      @close="teamMemberBeingRemoved = null"
    >
      <template #title>
        Remove Team Member
      </template>

      <template #content>
        Are you sure you would like to remove this person from the team?
      </template>

      <template #footer>
        <b-button @click.prevent="teamMemberBeingRemoved = null">
          Nevermind
        </b-button>

        <b-button
          :disabled="removeTeamMemberForm.processing"
          @click.prevent="removeTeamMember"
        >
          Remove
        </b-button>
      </template>
    </jet-modal>
  </div>
</template>

<script>
import JetActionMessage from '@/Jetstream/ActionMessage'
import JetActionSection from '@/Jetstream/ActionSection'
import JetModal from '@/Jetstream/Modal'
import JetFormSection from '@/Jetstream/FormSection'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'
import JetSectionBorder from '@/Jetstream/SectionBorder'

export default {
  components: {
    JetActionMessage,
    JetActionSection,
    JetModal,
    JetFormSection,
    JetInputError,
    JetLabel,
    JetSecondaryButton,
    JetSectionBorder
  },

  props: [
    'team',
    'availableRoles',
    'userPermissions'
  ],

  data () {
    return {
      addTeamMemberForm: this.$inertia.form({
        email: '',
        role: null
      }),

      updateRoleForm: this.$inertia.form({
        role: null
      }),

      leaveTeamForm: this.$inertia.form(),
      removeTeamMemberForm: this.$inertia.form(),

      currentlyManagingRole: false,
      managingRoleFor: null,
      confirmingLeavingTeam: false,
      teamMemberBeingRemoved: null
    }
  },

  methods: {
    addTeamMember () {
      this.addTeamMemberForm.post(route('team-members.store', this.team), {
        errorBag: 'addTeamMember',
        preserveScroll: true,
        onSuccess: () => this.addTeamMemberForm.reset()
      })
    },

    cancelTeamInvitation (invitation) {
      this.$inertia.delete(route('team-invitations.destroy', invitation), {
        preserveScroll: true
      })
    },

    manageRole (teamMember) {
      this.managingRoleFor = teamMember
      this.updateRoleForm.role = teamMember.membership.role
      this.currentlyManagingRole = true
    },

    updateRole () {
      this.updateRoleForm.put(route('team-members.update', [this.team, this.managingRoleFor]), {
        preserveScroll: true,
        onSuccess: () => (this.currentlyManagingRole = false)
      })
    },

    confirmLeavingTeam () {
      this.confirmingLeavingTeam = true
    },

    leaveTeam () {
      this.leaveTeamForm.delete(route('team-members.destroy', [this.team, this.$page.props.user]))
    },

    confirmTeamMemberRemoval (teamMember) {
      this.teamMemberBeingRemoved = teamMember
    },

    removeTeamMember () {
      this.removeTeamMemberForm.delete(route('team-members.destroy', [this.team, this.teamMemberBeingRemoved]), {
        errorBag: 'removeTeamMember',
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => (this.teamMemberBeingRemoved = null)
      })
    },

    displayableRole (role) {
      return this.availableRoles.find(r => r.key === role).name
    }
  }
}
</script>
