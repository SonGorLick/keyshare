<template>
  <guest-layout>
    <template #header>
      Welcome
    </template>

    <div v-if="canLogin">
      <inertia-link
        v-if="$page.props.user"
        href="/dashboard"
      >
        Dashboard
      </inertia-link>

      <template v-else>
        <inertia-link :href="route('login')">
          Login
        </inertia-link>

        <inertia-link
          v-if="canRegister"
          :href="route('register')"
        >
          Register
        </inertia-link>
      </template>
    </div>
  </guest-layout>
</template>

<style scoped>
</style>

<script>
import GuestLayout from '@/Layouts/GuestLayout'

export default {
  components: {
    GuestLayout
  },
  props: {
    canLogin: Boolean,
    canRegister: Boolean
  }
}
</script>
