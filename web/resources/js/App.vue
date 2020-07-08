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
  }
}
</script>