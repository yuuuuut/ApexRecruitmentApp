<template>
  <v-toolbar color="primary">
    <v-toolbar-title>
      <RouterLink to="/" style="text-decoration: none; color: white;">
        エペぼ!!
      </RouterLink>
    </v-toolbar-title>
    <v-spacer></v-spacer>
    <div v-if="isLogin">
      <v-menu top>
        <template v-slot:activator="{ on, attrs }">
          <v-btn
            style="color: white;"
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
    </div>
    <div v-else>
      <RouterLink to="/login" style="text-decoration: none;">
        <v-btn color="success" dark>ログイン / 新規登録</v-btn>
      </RouterLink>
    </div>
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
  computed: {
    isLogin () {
      return this.$store.getters['auth/check']
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