<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ dlc.name }}
      </h2>
    </template>

    <b-container>
      <jet-form-section @submitted="updateDlcInformation">
        <template #title>
          Edit Dlc
        </template>

        <template #description>
          Update Dlc information
        </template>

        <template #form>
          <!-- Dlc Image File Input -->
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

          <!-- New Game Image Preview -->
          <div
            class="gamecard card"
            style="max-width: 352px;"
          >
            <img
              v-show="! photoPreview"
              :src="dlc.image"
              class="image"
            >
            <img
              v-show="photoPreview"
              :src="photoPreview"
              class="image"
            >
          </div>
          <br>

          <b-button
            @click.prevent="selectNewPhoto"
          >
            Select A New Photo
          </b-button>

          <jet-input-error :message="form.errors.photo" />

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

          <!-- Description -->
          <div>
            <jet-label
              for="description"
              value="Description:"
            />
            <b-form-textarea
              id="description"
              v-model="form.description"
              type="text"
            />
            <jet-input-error :message="form.errors.description" />
          </div>
        </template>

        <template #actions>
          <jet-action-message :on="form.recentlySuccessful">
            Saved.
          </jet-action-message>

          <b-button
            :disabled="form.processing"
            type="submit"
            @click="updateDlcInformation"
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
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'
import JetActionMessage from '@/Jetstream/ActionMessage'

export default {
  components: {
    JetActionMessage,
    JetFormSection,
    JetInputError,
    JetLabel,
    AppLayout
  },

  props: {
    dlc: {
      type: Object,
      default: null
    }
  },

  data () {
    return {
      form: this.$inertia.form({
        _method: 'PUT',
        name: this.dlc.name,
        description: (this.dlc.description == null) ? '' : this.dlc.description,
        photo: null,
        dlcid: this.dlc.id
      }),

      photoPreview: null
    }
  },

  methods: {
    updateDlcInformation () {

      if (this.$refs.photo) {
        this.form.photo = this.$refs.photo.files[0]
      }

      this.form.post(route('dlc.update'), {
        errorBag: 'updateDlcnformation',
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

  }
}
</script>
<style>
  .hidden {
    display: none;
  }
</style>
