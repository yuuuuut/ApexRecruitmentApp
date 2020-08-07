<template>
  <v-toolbar dense color="primary">
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
        <div class="mt-3 mr-7">
          <router-link
            :to="{ name: 'Notification' }"
          >
            <div v-if="badegFlag">
              <v-badge
                color="pink"
                dot
              >
                <v-icon @click="badegFlag = false" style="color: white;">mdi-bell</v-icon>
              </v-badge>
            </div>
            <div v-else>
              <v-icon style="color: white;">mdi-bell</v-icon>
            </div>
          </router-link>
        </div>
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
import { mapState, mapGetters } from 'vuex'

import HeaderMenu from '../components/HeaderMenu.vue'

export default {
  components: {
    HeaderMenu
  },
  data () {
    return {
      badegFlag: false
    }
  },
  created: function () {
    if (this.user) {
      this.addBadegBool()
    }
  },
  computed: {
    ...mapState({
      user: state => state.auth.user
    }),
    ...mapGetters({
      isLogin: 'auth/check'
    })
  },
  methods: {
    addBadegBool () {
      this.badegFlag = this.user.is_false_notification
    }
  }
}
</script>