<template>
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
      :rules="passRules"
      counter
      @click:append="show1 = !show1"></v-text-field>
    <div class="mt-3 mb-5 d-flex justify-center">
      <v-btn @click="login" width="300px" color="primary" dark>ログイン</v-btn>
    </div>
  </form>
</template>

<script>
export default {
  data () {
    return {
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
  }
}
</script>