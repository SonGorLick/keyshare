<template>
  <b-input
    :value="value"
    @input="$emit('input', $event.target.value)"
  />
</template>

<script>
export default {
  props: ['value'],

  methods: {
    focus () {
      this.$refs.input.focus()
    }
  }
}
</script>
