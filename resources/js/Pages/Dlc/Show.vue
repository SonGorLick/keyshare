<template>
  <app-layout>
    <template #header>
      {{ dlc.name }}
    </template>

    <b-container>
      <img
        :src="dlc.image"
        class="img-fluid mx-auto d-block rounded"
      >

      <router-link :to="route('dlc.edit', {id: dlc.id})">
        Edit Dlc
      </router-link>
      <p> {{ dlc.description }} </p>

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
    </b-container>
  </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import RouterLink from '../../Components/RouterLink.vue'

export default {
  components: {
    AppLayout,
    RouterLink
  },
  props: {
    dlc: {
      type: Object,
      default: null
    },
    keys: {
      type: Array,
      default: null
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
