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
        <template #cell(name)="data">
          <router-link :to="route('admin.users.edit', {id: data.item.id})">
            {{ data.item.name }}
            <b-badge
              pill
              :variant="data.item.karma_color"
            >
              {{ data.item.karma }}
            </b-badge>
          </router-link>
        </template>
        <template #cell(approved)="data">
          <p v-if="data.item.approved === 1">
            Yes
          </p>
          <p v-else>
            No
          </p>
        </template>
        <template #cell(admin)="data">
          <p v-if="data.item.admin === 1">
            Yes
          </p>
          <p v-else>
            No
          </p>
        </template>
      </b-table>

      <ul class="pagination">
        <li
          v-if="users.current_page === 1"
          class="page-item disabled"
        >
          <a class="page-link">Previous</a>
        </li>
        <li
          v-else
          class="page-item"
        >
          <router-link :to="route('admin.users.index', {page: users.current_page - 1})">
            <a class="page-link">Previous</a>
          </router-link>
        </li>
        <li
          v-for="n in users.last_page"
          :key="n"
          class="page-item"
          :class="{ active: (n === users.current_page) }"
        >
          <router-link :to="route('admin.users.index', {page: n})">
            <a class="page-link">{{ n }}</a>
          </router-link>
        </li>
        <li
          v-if="users.current_page === users.last_page"
          class="page-item disabled"
        >
          <a class="page-link">Next</a>
        </li>
        <li
          v-else
          class="page-item"
        >
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
    }
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
