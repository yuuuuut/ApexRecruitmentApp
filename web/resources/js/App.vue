<template>
  <v-app>
    <header>
      <Header />
    </header>
    <main>
      <RouterView />
    </main>
  </v-app>
</template>

<script>
import Header from './components/Header.vue'

export default {
  components: {
    Header,
  },
  computed: {
    errorCode () {
      return this.$store.state.error.code
    }
  },
  watch: {
    errorCode: {
      handler (val) {
        if (val === 500) {
          this.$router.push('/500')
        }
      },
      immediate: true
    },
    $route () {
      this.$store.commit('error/setCode', null)
    }
  }
}
</script>