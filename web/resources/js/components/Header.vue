<template>
  <v-toolbar dark>
    <v-toolbar-title>えぺぼ!!</v-toolbar-title>
    <v-spacer></v-spacer>
    <v-menu top>
      <template v-slot:activator="{ on, attrs }">
        <v-btn 
          v-bind="attrs"
          v-on="on" icon>
            <v-icon>mdi-dots-vertical</v-icon>
        </v-btn>
      </template>
      <v-list>
        <v-list-item
          v-for="(item, index) in items"
          :key="index"
          @click="">
          <div v-if="item.title === 'ログアウト'">
            <button class="button button--link" @click="logout">ログアウト<v-icon>mdi-seat-individual-suite</v-icon></button>
          </div>
        </v-list-item>
      </v-list>
    </v-menu>
  </v-toolbar>
</template>

<script>
export default {
  data () {
    return {
      items: [
        { title: 'ログアウト' },
      ]
    }
  },
  methods: {
    async logout () {
      await this.$store.dispatch('auth/logout')
      this.$router.push('/login')
    }
  }
}
</script>