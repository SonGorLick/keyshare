<template>
  <b-container>
    <jet-form-section @submitted="createTeam">
      <template #title>
        Team Details
      </template>

      <template #description>
        Create a new team to collaborate with others on projects.
      </template>

      <template #form>
        <jet-label value="Team Owner" />
        <b-card>
          <b-media>
            <template #aside>
              <b-avatar
                :src="$page.props.user.profile_photo_url"
                size="6em"
                rounded
              />
            </template>

            <h5 class="mt-0">
              {{ $page.props.user.name }}
            </h5>
            <p>
              {{ $page.props.user.email }}
            </p>
          </b-media>
        </b-card>

        <div class="col-span-6 sm:col-span-4">
          <jet-label
            for="name"
            value="Team Name"
          />
          <b-input
            id="name"
            v-model="form.name"
            type="text"
            autofocus
          />
          <jet-input-error
            :message="form.errors.name"
            class="mt-2"
          />
        </div>
      </template>

      <template #actions>
        <b-button
          :disabled="form.processing"
          @click="createTeam"
        >
          Create
        </b-button>
      </template>
    </jet-form-section>
  </b-container>
</template>

<script>
import JetFormSection from '@/Jetstream/FormSection'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'

export default {
  components: {
    JetFormSection,
    JetInputError,
    JetLabel
  },

  data () {
    return {
      form: this.$inertia.form({
        name: ''
      })
    }
  },

  methods: {
    createTeam () {
      this.form.post(route('teams.store'), {
        errorBag: 'createTeam',
        preserveScroll: true
      })
    }
  }
}
</script>
