<template>
  <jet-form-section @submitted="updateTeamName">
    <template #title>
      Team Name
    </template>

    <template #description>
      The team's name and owner information.
    </template>

    <template #form>
      <!-- Team Owner Information -->
      <jet-label value="Owner:" />
      <b-card>
        <b-media>
          <template #aside>
            <b-avatar
              :src="team.owner.profile_photo_url"
              size="6em"
              rounded
            />
          </template>

          <h5 class="mt-0">
            {{ team.owner.name }}
          </h5>
          <p>
            {{ team.owner.email }}
          </p>
        </b-media>
      </b-card>

      <!-- Team Name -->
      <div>
        <jet-label
          for="name"
          value="Team Name:"
        />

        <b-input
          id="name"
          v-model="form.name"
          type="text"
          class="mt-1 block w-full"
          :disabled="! permissions.canUpdateTeam"
        />

        <jet-input-error
          :message="form.errors.name"
          class="mt-2"
        />
      </div>
    </template>

    <template
      v-if="permissions.canUpdateTeam"
      #actions
    >
      <jet-action-message
        :on="form.recentlySuccessful"
        class="mr-3"
      >
        Saved.
      </jet-action-message>

      <b-button
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
        @click.prevent="updateTeamName"
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

  props: ['team', 'permissions'],

  data () {
    return {
      form: this.$inertia.form({
        name: this.team.name
      })
    }
  },

  methods: {
    updateTeamName () {
      this.form.put(route('teams.update', this.team), {
        errorBag: 'updateTeamName',
        preserveScroll: true
      })
    }
  }
}
</script>
