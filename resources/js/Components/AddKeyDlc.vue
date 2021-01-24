<template>
  <div>
    <form
      method="POST"
      action="/addkey/store"
    >
      <label for="gamename">Game:</label>
      <autocomplete
        id="gamename"
        v-model="game"
        placeholder
        name="gamename"
        classes="form-control"
        url="/autocomplete/games/"
      />

      <label for="dlcname">DLC:</label>
      <autocomplete
        id="dlcname"
        :url="'autocomplete/dlc/' + game + '/'"
        placeholder
        name="dlcname"
        classes="form-control"
      />

      <label for="platform">Platform:</label>
      <select
        class="form-control"
        name="platform_id"
      >
        <option
          v-for="platform in platforms"
          :key="platform.id"
          :value="platform.id"
        >
          {{ platform.name }}
        </option>
      </select>

      <label for="key">Key:</label>
      <input
        name="key"
        class="form-control"
        type="text"
        required
      >
      <label for="message">Message:</label>
      <textarea
        name="message"
        class="form-control"
        type="text"
      />
      <input
        type="hidden"
        name="key_type"
        value="2"
      >
      <br>
      <input
        type="submit"
        class="btn btn-keyshare"
        value="Add Key"
      >
    </form>
  </div>
</template>
<script>
export default {
  props: {
    platforms: {
      type: Array,
      required: true,
      default: null
    }
  },
  data () {
    return {
      game: ''
    }
  },
  methods: {
  }
}
</script>
