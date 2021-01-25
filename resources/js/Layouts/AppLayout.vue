<template>
  <div>
    <b-navbar
      toggleable="lg"
      type="dark bg-dark navbar-dark navbar-keyshare"
      variant="dark"
      fixed="top"
    >
      <b-navbar-brand href="#">
        {{ $page.props.config.name }}
      </b-navbar-brand>
      <b-navbar-toggle target="nav-collapse" />
      <b-collapse
        id="nav-collapse"
        is-nav
      >
        <b-navbar-nav>
          <router-link :to="route('game.index')">
            <a class="nav-link">Games</a>
          </router-link>
          <b-nav-item-dropdown
            text="Platforms"
            right
          >
            <router-link
              v-for="platform in $page.props.platforms"
              :key="platform.id"
              :to="route('platform.show', {id: platform.id})"
            >
              <a class="dropdown-item">{{ platform.name }}</a>
            </router-link>
          </b-nav-item-dropdown>
          <router-link :to="route('addkey')">
            <a class="nav-link">Add Key</a>
          </router-link>
        </b-navbar-nav>

        <!-- Right aligned nav items -->
        <b-navbar-nav class="ml-auto">
          <b-nav-form @submit.prevent="submitSearch">
            <autocomplete
              id="search"
              v-model="search.search"
              url="/autocomplete/games/"
              placeholder="Search"
              name="search"
              type="search"
              classes="form-control navbar-search"
            />
          </b-nav-form>

          <b-nav-item-dropdown
            v-if="$page.props.user.admin"
            text="Admin"
            right
          >
            <router-link :to="route('admin.users.index')">
              <a class="dropdown-item">
                Users
              </a>
            </router-link>
          </b-nav-item-dropdown>

          <b-nav-item-dropdown right>
            <!-- Using 'button-content' slot -->
            <template #button-content>
              <b-avatar
                :src="$page.props.user.profile_photo_url"
                size="1.5rem"
                rounded
              />
              {{ $page.props.user.name }}
              <b-badge
                pill
                :variant="$page.props.user.karma_color"
              >
                {{ $page.props.user.karma }}
              </b-badge>
            </template>
            <router-link :to="route('profile.show')">
              <a class="dropdown-item">Edit Profile</a>
            </router-link>
            <router-link
              v-if="$page.props.jetstream.hasApiFeatures"
              :to="route('api-tokens.index')"
            >
              <a class="dropdown-item">API Tokens</a>
            </router-link>

            <b-dropdown-divider />

            <!-- Shared/Claimed Keys -->
            <router-link :to="route('sharedkeys')">
              <a class="dropdown-item">Shared Keys</a>
            </router-link>
            <router-link :to="route('claimedkeys')">
              <a class="dropdown-item">Claimed Keys</a>
            </router-link>

            <b-dropdown-divider />

            <template v-if="$page.props.jetstream.hasTeamFeatures">
              <b-dropdown-header>
                Manage Team
              </b-dropdown-header>

              <!-- Team Settings  -->
              <router-link v-if="$page.props.user.current_team" :to="route('teams.show', $page.props.user.current_team)">
                <a class="dropdown-item">Team Settings</a>
              </router-link>

              <router-link :to="route('teams.create')">
                <a class="dropdown-item">Create New Team</a>
              </router-link>

              <b-dropdown-header v-if="$page.props.user.all_teams.length > 0">
                Switch Teams
              </b-dropdown-header>
              <template v-for="team in $page.props.user.all_teams">
                <b-dropdown-item-button
                  :key="team.id"
                  :active="team.id == $page.props.user.current_team_id"
                  @click.prevent="switchToTeam(team)"
                >
                  {{ team.name }}
                </b-dropdown-item-button>
              </template>
            </template>
            <b-dropdown-divider />
            <b-dropdown-item
              type="submit"
              @click="logout"
            >
              Sign Out
            </b-dropdown-item>
          </b-nav-item-dropdown>
        </b-navbar-nav>
      </b-collapse>
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
import RouterLink from '../Components/RouterLink.vue'

export default {
  components: {
    RouterLink
  },

  data () {
    return {
      showingNavigationDropdown: false,
      search: this.$inertia.form({
        search: ''
      })
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

    submitSearch () {
      this.search.get(route('search'), {
        onSuccess: () => this.form.reset()
      })
    },

    logout () {
      this.$inertia.post(route('logout'))
    }
  }
}
</script>
