<template>
  <div v-if="hasErrors">
    <div>Whoops! Something went wrong.</div>

    <ul>
      <li
        v-for="(error, key) in errors"
        :key="key"
      >
        {{ error }}
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  computed: {
    errors () {
      return this.$page.props.errors
    },

    hasErrors () {
      return Object.keys(this.errors).length > 0
    }
  }
}
</script>
