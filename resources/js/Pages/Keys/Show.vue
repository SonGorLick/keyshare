<template>
  <app-layout>
    <template #header>
      {{ key.platform.name }} - {{ key.game.name }}
    </template>

    <b-container>
      <div v-if="key.owned_user_id == null">
        <form @submit.prevent="claim">
          <input
            name="key"
            class="form-control"
            type="text"
            value="*****-*****-*****-*****"
            disabled
          >
          <input
            type="submit"
            class="btn btn-primary"
            value="Claim Key"
          >
        </form>
      </div>

      <div v-else-if="key.owned_user_id == $page.props.user.id">
        <input
          name="key"
          class="form-control"
          type="text"
          :value="key.keycode"
          disabled
        >
        <a
          v-if="key.platform.name == 'Steam'"
          :href="'https://store.steampowered.com/account/registerkey?key=' + key.keycode"
        >Redeem on Steam</a>
      </div>

      <div v-else>
        <input
          name="key"
          class="form-control"
          type="text"
          value="*****-*****-*****-*****"
          disabled
        >
        <input
          type="submit"
          class="btn btn-keyshare"
          value="Claim Key"
          disabled
        >
        <br> Key already claimed
      </div>

      <div v-if="key.message">
        Message:
        {{ key.message }}
      </div>

      <b-card
        v-if="key.created_user"
      >
        <b-media>
          <template #aside>
            <b-avatar
              :src="key.created_user.profile_photo_url"
              size="12em"
              rounded
            />
          </template>

          <h5 class="mt-0">
            {{ key.created_user.name }}
            <b-badge
              pill
              :variant="key.created_user.karma_color"
            >
              {{ key.created_user.karma }}
            </b-badge>
          </h5>
          <p> {{ key.created_user.bio }} </p>
        </b-media>
      </b-card>
    </b-container>
  </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'

export default {
  components: {
    AppLayout
  },
  props: {
    key: {
      type: Object
    }
  },
  data () {
    return {
      form: this.$inertia.form({
        key: this.key.id
      })
    }
  },
  methods: {
    claim () {
      this.form.put(route('key.claim'), {
        errorBag: 'claim',
        preserveScroll: true
      })
    }
  }
}
</script>
