<template>
  <b-button
    :type="type"
  >
    <slot />
  </b-button>
</template>

<script>
export default {
  props: {
    type: {
      type: String,
      default: 'submit'
    }
  }
}
</script>
