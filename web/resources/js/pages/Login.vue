<template>

    <v-card
      class="mx-auto mt-10"
      width="830px"
      outlined>
      <v-tabs
        v-model="tab"
        background-color="light-blue darken-2"
        center-active
        grow
        dark>
        <v-tab
          v-for="item in items"
          :key="item.tab"
          class="font-weight-bold">
          {{ item.tab }}
        </v-tab>
      </v-tabs>

      <v-tabs-items v-model="tab">
        <v-tab-item
          v-for="item in items"
          :key="item.tab">
          <!-- ログインフォーム -->
          <div v-show="item.tab === 'ログイン'">
            <form @submit.prevent>
              <v-text-field
                class="mt-5 ml-10 mr-10"
                v-model="loginForm.email"
                :rules="emailRules"
                label="メールアドレス"
                hide-details="auto"></v-text-field>
              <v-text-field
                class="mt-5 ml-10 mr-10"
                v-model="loginForm.password"
                :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                :type="show1 ? 'text' : 'password'"
                label="パスワード"
                counter
                @click:append="show1 = !show1"></v-text-field>
              <div class="mt-3 mb-5 d-flex justify-center">
                <v-btn @click="login" width="300px" color="primary" dark>ログイン</v-btn>
              </div>
            </form>
          </div>

          <div v-show="item.tab === '新規登録'">
            <form @submit.prevent>
              <v-text-field
                class="mt-5 ml-10 mr-10"
                v-model="registerForm.name"
                label="名前"
                hide-details="auto"></v-text-field>
              <v-text-field
                class="mt-5 ml-10 mr-10"
                v-model="registerForm.email"
                :rules="emailRules"
                label="メールアドレス"
                hide-details="auto"></v-text-field>
              <v-text-field
                class="mt-5 ml-10 mr-10"
                v-model="registerForm.password"
                :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'"
                :type="show2 ? 'text' : 'password'"
                label="パスワード"
                counter
                @click:append="show2 = !show2"></v-text-field>
              <v-text-field
                class="mt-2 ml-10 mr-10"
                v-model="registerForm.password_confirmation"
                :append-icon="show3 ? 'mdi-eye' : 'mdi-eye-off'"
                :type="show3 ? 'text' : 'password'"
                label="パスワード(確認)"
                counter
                @click:append="show3 = !show3"></v-text-field>
              <div class="mt-3 mb-5 d-flex justify-center">
                <v-btn @click="register" width="300px" color="primary" dark>新規登録</v-btn>
              </div>
            </form>
          </div>
        </v-tab-item>
      </v-tabs-items>
    </v-card>

</template>

<script>
export default {
  data () {
    return {
      tab: null,
      show1: false,
      show2: false,
      show3: false,
      items: [
        { tab: 'ログイン' },
        { tab: '新規登録' },
      ],
      loginForm: {
        email: '',
        password: '',
      },
      registerForm: {
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      },
      //Validations
      emailRules: [
        v => !!v || 'メールアドレスを入力してください',
        v => /.+@.+\..+/.test(v) || '無効なメールアドレスです',
      ],
    }
  },
  computed: {
    apiStatus () {
      return this.$store.state.auth.apiStatus
    }
  },
  methods: {
    async login () {
      await this.$store.dispatch('auth/login', this.loginForm)

      if (this.apiStatus) {
        this.$router.push('/')
      }
    },
    async register () {
      await this.$store.dispatch('auth/register', this.registerForm)
      this.$router.push('/')
    }
  }
}
</script>