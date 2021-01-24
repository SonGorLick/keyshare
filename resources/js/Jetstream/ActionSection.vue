<template>
  <b-row>
    <b-col>
      <jet-section-title>
        <template #title>
          <slot name="title" />
        </template>
        <template #description>
          <slot name="description" />
        </template>
      </jet-section-title>
    </b-col>
    <b-col cols="8">
      <b-card>
        <b-card-text>
          <slot name="content" />
        </b-card-text>
      </b-card>
    </b-col>
  </b-row>
</template>

<script>
import JetSectionTitle from './SectionTitle'

export default {
  components: {
    JetSectionTitle
  }
}
</script>
<style scoped>
  .row {
    padding-bottom: 15px;
  }
</style>
