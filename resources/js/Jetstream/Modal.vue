<template>
  <portal to="modal">
    <b-modal v-model="show">
      <template #modal-header>
        <slot name="title" />
      </template>

      <template #default>
        <slot name="content" />
      </template>

      <template #modal-footer>
        <slot name="footer" />
      </template>
    </b-modal>
  </portal>
</template>

<script>
export default {
  props: {
    show: {
      default: false
    },
    maxWidth: {
      default: '2xl'
    },
    closeable: {
      default: true
    }
  },

  computed: {
    maxWidthClass () {
      return {
        sm: 'sm:max-w-sm',
        md: 'sm:max-w-md',
        lg: 'sm:max-w-lg',
        xl: 'sm:max-w-xl',
        '2xl': 'sm:max-w-2xl'
      }[this.maxWidth]
    }
  },

  watch: {
    show: function () {
      if (this.show === false) {
        this.$emit('close')
      }
    }
  },

  created () {
    const closeOnEscape = (e) => {
      if (e.key === 'Escape' && this.show) {
        this.close()
      }
    }

    document.addEventListener('keydown', closeOnEscape)

    this.$once('hook:destroyed', () => {
      document.removeEventListener('keydown', closeOnEscape)
    })
  },

  methods: {
    close () {
      if (this.closeable) {
        this.$emit('close')
      }
    }
  }
}
</script>
