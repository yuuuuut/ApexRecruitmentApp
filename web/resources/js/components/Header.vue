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
            v-on="on" icon
          >
            <v-icon>mdi-dots-vertical</v-icon>
          </v-btn>
        </template>
        <v-list>
          <v-list-item
            v-for="(item, index) in items"
            :key="index"
            @click=""
          >
            <div v-if="item.title === 'マイページ'">
              <button>
                <router-link :to="{ name: 'userDetail', params: { id: user.id.toString() }}" class="mypage--link">マイページ<v-icon>mdi-account</v-icon></router-link>
              </button>
            </div>
            <div v-if="item.title === 'ログアウト'">
              <button  @click.stop="dialog = true">ログアウト<v-icon>mdi-seat-individual-suite</v-icon></button>
              <v-dialog
                v-model="dialog"
                max-width="290"
              >
                <v-card>
                  <v-card-title class="headline">ログアウトしますか?</v-card-title>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                      color="green darken-1"
                      text
                      @click="dialog = false"
                    >
                      いいえ
                    </v-btn>
                    <v-btn
                      color="green darken-1"
                      text
                      @click="logout">
                      はい
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
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
import { mapState, mapGetters } from 'vuex'

export default {
  data () {
    return {
      items: [
        { title: 'マイページ' },
        { title: 'ログアウト' },
      ],
      dialog: false,
    }
  },
  computed: {
    ...mapState({
      apiStatus: state => state.auth.apiStatus,
      user: state => state.auth.user
    }),
    ...mapGetters({
      isLogin: 'auth/check'
    })
  },
  methods: {
    async logout () {
      await this.$store.dispatch('auth/logout')
      
      if (this.apiStatus) {
        this.dialog = false
        this.$router.push('/login')
      }
    }
  }
}
</script>

<style scoped>
.mypage--link {
  color: black;
  text-decoration: none;
}
</style>