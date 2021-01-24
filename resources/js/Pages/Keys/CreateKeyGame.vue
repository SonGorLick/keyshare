<template>
  <div>
    <div
      v-if="form.wasSuccessful"
      class="alert alert-success"
    >
      Key has been created
    </div>
    <form @submit.prevent="createKey">
      <label for="gamename">Game:</label>
      <autocomplete
        v-model="form.gamename"
        placeholder
        url="/autocomplete/games/"
        classes="form-control"
      />
      <jet-input-error
        :message="form.errors.gamename"
      />

      <label for="platform">Platform:</label>
      <b-form-select v-model="form.platform_id">
        <b-form-select-option
          v-for="platform in $page.props.platforms"
          :key="platform.id"
          :value="platform.id"
        >
          {{ platform.name }}
        </b-form-select-option>
      </b-form-select>
      <jet-input-error
        :message="form.errors.platform_id"
      />

      <label for="key">Key:</label>
      <input
        v-model="form.key"
        class="form-control"
        type="text"
        required
      >
      <jet-input-error
        :message="form.errors.key"
      />

      <label for="message">Message:</label>
      <textarea
        v-model="form.message"
        class="form-control"
        type="text"
      />
      <jet-input-error
        :message="form.errors.message"
      />
      <b-button
        type="submit"
        value="Add Key"
        variant="primary"
      >
        Submit
      </b-button>
    </form>
  </div>
</template>
<script>
export default {
  data () {
    return {
      form: this.$inertia.form({
        gamename: 'test',
        platform_id: 0,
        key: '',
        message: '',
        key_type: 1
      })
    }
  },
  methods: {
    createKey () {
      this.form.post(route('key.store'), {
        errorBag: 'createKey',
        preserveScroll: true,
        onSuccess: () => this.form.reset(),
        onError: () => {}
      })
    }
  }
}
</script>
