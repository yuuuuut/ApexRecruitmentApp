<template>
  <form @submit.prevent>
    <!-- ErrorMessage -->
    <div v-if="loginErrors" style="color: red;">
      <ul v-if="loginErrors.email">
        <li v-for="msg in loginErrors.email" :key="msg">{{ msg }}</li>
      </ul>
      <ul v-if="loginErrors.password">
        <li v-for="msg in loginErrors.password" :key="msg">{{ msg }}</li>
      </ul>
    </div>
    <!-- / -->
    <v-text-field
      class="mt-5 ml-10 mr-10"
      v-model="loginForm.email"
      :rules="emailRules"
      label="メールアドレス"
      hide-details="auto"
    ></v-text-field>
    <v-text-field
      class="mt-5 ml-10 mr-10"
      v-model="loginForm.password"
      :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
      :type="show1 ? 'text' : 'password'"
      label="パスワード"
      :rules="passRules"
      counter
      @click:append="show1 = !show1"
    ></v-text-field>
    <div class="mt-3 d-flex justify-center">
      <v-btn v-if="!sending" @click="login" class="mb-5" width="300px" color="primary" dark>ログイン</v-btn>
      <v-btn v-else class="mb-5" width="300px" disabled>ログイン</v-btn>
    </div>
  </form>
</template>

<script>
import { mapState } from 'vuex'

export default {
  data () {
    return {
      sending: false,
      show1: false,
      loginForm: {
        email: '',
        password: '',
      },
      //Validations
      emailRules: [
        v => !!v || 'メールアドレスを入力してください',
        v => /.+@.+\..+/.test(v) || '無効なメールアドレスです',
      ],
      passRules: [
        v => !!v || 'パスワードを入力してください',
      ],
    }
  },
  computed:  {
    ...mapState({
      apiStatus: state => state.auth.apiStatus,
      loginErrors: state => state.auth.loginErrorMessages
    })
  },
  created () {
    this.clearError()
  },
  methods: {
    async login () {
      this.sending = true
      await this.$store.dispatch('auth/login', this.loginForm)

      if (this.apiStatus) {
        this.$router.push('/')
      }
      this.sending = false
    },
    clearError () {
      this.$store.commit('auth/setLoginErrorMessages', null)
    }
  }
}
</script>