<template>
  <jet-form-section @submitted="updateProfileInformation">
    <template #title>
      Profile Information
    </template>

    <template #description>
      Update your account's profile information and email address.
    </template>

    <template #form>
      <!-- Profile Photo -->
      <div v-if="$page.props.jetstream.managesProfilePhotos">
        <!-- Profile Photo File Input -->
        <input
          ref="photo"
          type="file"
          class="hidden"
          @change="updatePhotoPreview"
        >

        <jet-label
          for="photo"
          value="Photo:"
        />
        <br>

        <!-- New Profile Photo Preview -->
        <b-avatar
          v-show="! photoPreview"
          :src="user.profile_photo_url"
          size="6rem"
          rounded
        />
        <b-avatar
          v-show="photoPreview"
          :src="photoPreview"
          size="6rem"
          rounded
        />
        <br>

        <b-button
          @click.prevent="selectNewPhoto"
        >
          Select A New Photo
        </b-button>

        <b-button
          v-if="user.profile_photo_path"
          @click.prevent="deletePhoto"
        >
          Remove Photo
        </b-button>

        <jet-input-error :message="form.errors.photo" />
      </div>

      <!-- Name -->
      <div>
        <jet-label
          for="name"
          value="Name:"
        />
        <b-input
          id="name"
          v-model="form.name"
          type="text"
          autocomplete="name"
        />
        <jet-input-error :message="form.errors.name" />
      </div>

      <!-- Email -->
      <div>
        <jet-label
          for="email"
          value="Email:"
        />
        <b-input
          id="email"
          v-model="form.email"
          type="email"
        />
        <jet-input-error :message="form.errors.email" />
      </div>
    </template>

    <template #actions>
      <jet-action-message :on="form.recentlySuccessful">
        Saved.
      </jet-action-message>

      <b-button
        :disabled="form.processing"
        type="submit"
        @click="updateProfileInformation"
      >
        Save
      </b-button>
    </template>
  </jet-form-section>
</template>

<script>
import JetFormSection from '@/Jetstream/FormSection'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'
import JetActionMessage from '@/Jetstream/ActionMessage'

export default {
  components: {
    JetActionMessage,
    JetFormSection,
    JetInputError,
    JetLabel
  },

  props: ['user'],

  data () {
    return {
      form: this.$inertia.form({
        _method: 'PUT',
        name: this.user.name,
        email: this.user.email,
        photo: null
      }),

      photoPreview: null
    }
  },

  methods: {
    updateProfileInformation () {
      console.log('hello')

      if (this.$refs.photo) {
        this.form.photo = this.$refs.photo.files[0]
      }

      this.form.post(route('user-profile-information.update'), {
        errorBag: 'updateProfileInformation',
        preserveScroll: true
      })
    },

    selectNewPhoto () {
      this.$refs.photo.click()
    },

    updatePhotoPreview () {
      const reader = new FileReader()

      reader.onload = (e) => {
        this.photoPreview = e.target.result
      }

      reader.readAsDataURL(this.$refs.photo.files[0])
    },

    deletePhoto () {
      this.$inertia.delete(route('current-user-photo.destroy'), {
        preserveScroll: true,
        onSuccess: () => (this.photoPreview = null)
      })
    }
  }
}
</script>
<style>
  .hidden {
    display: none;
  }
</style>
