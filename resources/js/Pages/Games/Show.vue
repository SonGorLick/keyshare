<template>
  <app-layout>
    <template #header>
      {{ game.name }}
    </template>

    <b-container>
      <b-card style="background-color: #e9ecef;">
        <b-container fluid>
          <b-row>
            <b-col>
              <img
                :src="game.image"
                class="img-fluid mx-auto d-block rounded"
              >
              <span
                v-for="genre in genres"
                :key="genre.id"
                class="badge bg-secondary"
              >
                {{ genre.name }}
              </span>
            </b-col>
            <b-col
              v-if="screenshots"
              cols="9"
              sm="9"
            >
              <b-carousel
                id="carousel-1"
                v-model="slide"
                :interval="4000"
                controls
                indicators
                background="#ababab"
                img-width="940"
                img-height="529"
                style="text-shadow: 1px 1px 2px #333; margin-bottom: 10px;"
              >
                <b-carousel-slide
                  v-for="screenshot in screenshots"
                  :key="screenshot.id"
                  :img-src="'https://images.igdb.com/igdb/image/upload/t_screenshot_big/' + screenshot.image_id + '.jpg'"
                />
              </b-carousel>
            </b-col>
          </b-row>
        </b-container>
        <template
          v-if="igdb"
          #footer
        >
          <b-form-rating
            id="rating-inline"
            inline
            :value="igdb.aggregated_rating / 20"
            disabled
          />
          <label or="rating-inline">By {{ igdb.aggregated_rating_count }} reviewers</label>
        </template>
      </b-card>

      <router-link :to="route('game.edit', {id: game.id})">
        Edit Game
      </router-link>
      <p> {{ game.description }} </p>

      <b-table
        v-if="keys"
        :items="keys"
        :fields="fields"
      >
        <template #cell(createduser)="data">
          {{ data.value.name }} <b-badge
            pill
            :variant="data.value.karma_color"
          >
            {{ data.value.karma }}
          </b-badge>
        </template>
        <template #cell(id)="data">
          <router-link :to="route('key.show', {id: data.value})">
            Claim
          </router-link>
        </template>
      </b-table>
      <p v-else>
        No Keys Available
      </p>

      <div
        v-if="dlcCount > 0"
        class="page"
      >
        <div class="title">
          <h2>DLC</h2>
        </div>
        <game-grid :url="dlcUrl" />
      </div>
    </b-container>
  </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import RouterLink from '../../Components/RouterLink.vue'
import GameGrid from '../../Components/GameGrid.vue'

export default {
  components: {
    AppLayout,
    RouterLink,
    GameGrid
  },
  props: {
    dlcenabled: {
      default: true,
      type: Boolean
    },
    game: {
      type: Object,
      default: null
    },
    keys: {
      type: Array,
      default: null
    },
    dlcUrl: {
      type: String,
      default: ''
    },
    dlcCount: {
      type: Number,
      default: 0
    },
    igdb: {
      type: Object
      // default: {}
    },
    genres: {
      type: Array
      // default: []
    },
    screenshots: {
      type: Array
      // default: []
    }
  },
  data () {
    return {
      fields: [
        { key: 'platform.name', link: 'id', label: 'Platform' },
        { key: 'createduser', label: 'AddedBy' },
        { key: 'id', label: 'Link' }
      ]
    }
  }
}
</script>
