// Import modules...
import Vue from 'vue'
import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue'
import PortalVue from 'portal-vue'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import RouterLink from './Components/RouterLink'
import { InertiaProgress } from '@inertiajs/progress'

InertiaProgress.init({
  delay: 250,
  color: '#ff8800',
  includeCSS: true,
  showSpinner: false
})

require('./bootstrap')

Vue.mixin({ methods: { route } })
Vue.use(InertiaPlugin)
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(PortalVue)

Vue.component('autocomplete', require('andyh-autocomplete').default)
Vue.component('game-list', require('./Components/GameList.vue').default)
Vue.component('add-key-dlc', require('./Components/AddKeyDlc.vue').default)

Vue.component('RouterLink', RouterLink)
Vue.prototype.$router = 'fake'

const app = document.getElementById('app')

new Vue({
  render: (h) =>
    h(InertiaApp, {
      props: {
        initialPage: JSON.parse(app.dataset.page),
        resolveComponent: (name) => require(`./Pages/${name}`).default
      }
    })
}).$mount(app)
