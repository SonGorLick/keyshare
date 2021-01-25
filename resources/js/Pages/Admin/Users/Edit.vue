<template>
  <app-layout>
    <template #header>
      <h2>
        {{ auser.name }}
      </h2>
    </template>

    <b-container>
      <jet-form-section @submitted="adminUserUpdate">
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
              :src="auser.profile_photo_url"
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
              v-if="auser.profile_photo_path"
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

          <!-- Bio -->
          <div>
            <jet-label
              for="bio"
              value="Bio:"
            />
            <b-form-textarea
              id="bio"
              v-model="form.bio"
              type="text"
            />
            <jet-input-error :message="form.errors.bio" />
          </div>

          <b-form-checkbox
            v-model="form.approved"
            name="Approved"
            :value="1"
            :unchecked-value="0"
          >
            Approved
          </b-form-checkbox>
        </template>

        <template #actions>
          <jet-action-message :on="form.recentlySuccessful">
            Saved.
          </jet-action-message>

          <b-button
            :disabled="form.processing"
            type="submit"
            @click="adminUserUpdate"
          >
            Save
          </b-button>
        </template>
      </jet-form-section>
    </b-container>
  </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import JetFormSection from '@/Jetstream/FormSection'
import JetLabel from '@/Jetstream/Label'

export default {
  components: {
    AppLayout,
    JetFormSection,
    JetLabel
  },

  props: ['auser'],

  data () {
    return {
      form: this.$inertia.form({
        _method: 'PUT',
        name: this.auser.name,
        email: this.auser.email,
        bio: this.auser.bio,
        approved: this.auser.approved,
        photo: null,
        user: this.auser.id
      }),

      photoPreview: null
    }
  },

  methods: {
    adminUserUpdate () {
      if (this.$refs.photo) {
        this.form.photo = this.$refs.photo.files[0]
      }

      this.form.post(route('admin.user.update'), {
        errorBag: 'adminUserUpdate',
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
    }

    // deletePhoto () {
    //   this.$inertia.delete(route('current-user-photo.destroy'), {
    //     preserveScroll: true,
    //     onSuccess: () => (this.photoPreview = null)
    //   })
    // }
  }
}
</script>
<style>
  .hidden {
    display: none;
  }
</style>
