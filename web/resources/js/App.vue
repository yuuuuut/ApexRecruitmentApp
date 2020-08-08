<template>
  <v-app>
    <header>
      <Header />
    </header>
    <main>
      <RouterView />
    </main>
    <div class="position-fixed-left">
      <NotificationButton />
    </div>
  </v-app>
</template>

<script>
import Header from './components/Header.vue'
import NotificationButton from './components/NotificationButton.vue'

export default {
  components: {
    Header,
    NotificationButton,
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

<style scoped>
.position-fixed-left {
  position: fixed;
  bottom: 20px;
  left: 10px;
}
</style>