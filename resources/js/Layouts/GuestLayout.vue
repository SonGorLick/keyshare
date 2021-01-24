<template>
  <div>
    <b-navbar
      toggleable="lg"
      type="dark bg-dark navbar-dark navbar-keyshare"
      variant="dark"
      fixed="top"
    >
      <b-navbar-brand href="#">
        Keyshare
      </b-navbar-brand>
    </b-navbar>
    <b-jumbotron>
      <b-img
        src="/images/logo_default.png"
        width="137"
        height="110"
      />
    </b-jumbotron>

    <!-- Page Heading -->
    <header>
      <div class="title">
        <h2><slot name="header" /></h2>
      </div>
    </header>

    <!-- Page Content -->
    <main>
      <slot />
    </main>

    <!-- Modal Portal -->
    <portal-target
      name="modal"
      multiple
    />
  </div>
</template>

<script>

export default {
  data () {
    return {
      showingNavigationDropdown: false
    }
  },

  methods: {
    switchToTeam (team) {
      this.$inertia.put(route('current-team.update'), {
        team_id: team.id
      }, {
        preserveState: false
      })
    },

    logout () {
      this.$inertia.post(route('logout'))
    }
  }
}
</script>
