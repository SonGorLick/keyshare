<template>
  <div class="gamegrid">
    <div
      v-for="game in games"
      :key="game.id"
      class="gamecard card"
    >
      <router-link :to="getUrl(game)">
        <a :href="game.url">
          <img
            :src="game.image"
            alt="Card image cap"
            class="image"
          >
          <div class="overlay">{{ game.name }}</div>
        </a>
      </router-link>
    </div>
    <infinite-loading
      spinner="waveDots"
      @infinite="infiniteHandler"
    >
      <div slot="no-more" />
      <div slot="no-results">
        No Games Found
      </div>
    </infinite-loading>
  </div>
</template>
<script>
import InfiniteLoading from 'vue-infinite-loading'

export default {
  components: {
    InfiniteLoading
  },
  props: {
    url: {
      type: String,
      default: ''
    }
  },
  data () {
    return {
      page: 1,
      lastpage: null,
      games: []
    }
  },
  methods: {
    infiniteHandler ($state) {
      axios.get(this.url + '?page=' + this.page).then(response => {
        this.lastpage = response.data.last_page
        if (this.lastpage >= this.page) {
          this.games = this.games.concat(response.data.data)
          this.page = response.data.current_page + 1
          $state.loaded()
        } else {
          $state.complete()
        }
      })
    },
    getUrl ($game) {
      if ($game.linktype === 'dlc') {
        return route('dlc.show', { id: $game.id })
      } else if ($game.key_type_id) {
        return route('key.show', { id: $game.id })
      } else {
        return route('game.show', { id: $game.id })
      }
    }
  }
}
</script>
