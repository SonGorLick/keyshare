<template>
  <guest-layout>
    <template #header>
      Not Approved
    </template>

    <b-container>
      Your account is currently awaiting approval from an admin.
      <br>
      <b-button
        @click="logout"
      >
        Sign Out
      </b-button>
    </b-container>
  </guest-layout>
</template>

<script>
import GuestLayout from '@/Layouts/GuestLayout'

export default {
  components: {
    GuestLayout
  },

  data () {
  },

  methods: {
    logout () {
      this.$inertia.post(route('logout'))
    }
  }

}
</script>
