<template>
  <app-layout>
    <template #header>
        Users
    </template>

    <b-container>
      <b-table
        :items="users.data"
        :fields="fields"
      >
      </b-table>
      <ul class="pagination">
        <li class="page-item disabled" v-if="users.current_page === 1" >
          <a class="page-link">Previous</a>
        </li>
        <li v-else class="page-item">
          <router-link :to="route('admin.users.index', {page: users.current_page - 1})">
            <a class="page-link">Previous</a>
          </router-link>
        </li>
        <li class="page-item" v-for="n in users.last_page" :key="n" :class="{ active: (n === users.current_page) }">
          <router-link :to="route('admin.users.index', {page: n})">
            <a class="page-link">{{n}}</a>
          </router-link>
        </li>
        <li class="page-item disabled" v-if="users.current_page === users.last_page" >
          <a class="page-link">Next</a>
        </li>
        <li v-else class="page-item" >
          <router-link :to="route('admin.users.index', {page: users.current_page + 1})">
            <a class="page-link">Next</a>
          </router-link>
        </li>
      </ul>
    </b-container>
  </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import RouterLink from '../../../Components/RouterLink.vue'

export default {
  components: {
    AppLayout,
    RouterLink
  },
  props: {
    users: {
      type: Object,
      default: null
    },
  },
  data () {
    return {
      fields: [
        { key: 'name' },
        { key: 'email', label: 'Email' },
        { key: 'approved' },
        { key: 'admin' }

      ]
    }
  }
}
</script>
