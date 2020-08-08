<template>
  <v-toolbar color="primary">
    <v-toolbar-title>
      <routerLink
        to="/"
        style="text-decoration: none; color: white;"
      >
        エペぼ!!
      </routerLink>
    </v-toolbar-title>
    <v-spacer></v-spacer>
    <div v-if="isLogin">
      <div class="d-flex flex-row-reverse">
        <HeaderMenu />
      </div>
    </div>
    <div v-else>
      <routerLink
        to="/login"
        style="text-decoration: none;"
      >
        <v-btn color="success" dark>
          ログイン / 新規登録
        </v-btn>
      </routerLink>
    </div>
  </v-toolbar>
</template>

<script>
import { mapGetters } from 'vuex'

import HeaderMenu from '../components/HeaderMenu.vue'

export default {
  components: {
    HeaderMenu
  },
  computed: {
    ...mapGetters({
      isLogin: 'auth/check'
    })
  }
}
</script>