<template>
  <app-layout>
    <template #header>
      Add Key
    </template>

    <b-container>
      <div v-if="$page.props.config.dlc_enabled">
        <label for="Key Type">Key Type:</label>
        <br>
        <input
          id="Game"
          v-model="KeyType"
          type="radio"
          value="Game"
          selected
        >
        <label for="Game">Game</label>
        <br>
        <input
          id="DLC"
          v-model="KeyType"
          type="radio"
          value="DLC"
        >
        <label for="DLC">DLC</label>
        <br>

        <create-key-game v-if="( KeyType == 'Game' )" />
        <create-key-dlc v-if="( KeyType == 'DLC' )" />
      </div>
      <div v-else>
        <create-key-game />
      </div>
    </b-container>
  </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import CreateKeyGame from '@/Pages/Keys/CreateKeyGame'
import CreateKeyDlc from '@/Pages/Keys/CreateKeyDlc'

export default {
  components: {
    AppLayout,
    CreateKeyGame,
    CreateKeyDlc
  },
  data () {
    return {
      platforms: [],
      KeyType: ''
    }
  }
}
</script>
