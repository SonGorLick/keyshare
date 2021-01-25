<template>
  <app-layout>
    <template #header>
      Demo Mode
    </template>

    <b-container>
      This action cannot be completed, as the application is in demo mode.
    </b-container>
  </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'

export default {
  components: {
    AppLayout
  },

  data () {
  }

}
</script>
