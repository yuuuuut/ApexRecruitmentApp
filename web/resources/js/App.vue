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
      async handler (val) {
        if (val === 500) {
          this.$router.push('/500')
        } else if (val === 419) {
          await axios.get('/api/refresh-token')

          this.$store.commit('auth/setUser', null)
          this.$router.push('/login')
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