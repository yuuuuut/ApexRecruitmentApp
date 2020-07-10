<template>
  <form @submit.prevent>
    <v-text-field
      class="mt-5 ml-10 mr-10"
      v-model="registerForm.name"
      label="名前"
      hide-details="auto"></v-text-field>
    <v-text-field
      class="mt-5 ml-10 mr-10"
      v-model="registerForm.email"
      label="メールアドレス"
      :rules="emailRules"
      hide-details="auto"></v-text-field>
    <v-text-field
      class="mt-5 ml-10 mr-10"
      v-model="registerForm.password"
      :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
      :type="show1 ? 'text' : 'password'"
      label="パスワード"
      :rules="passRules"
      counter
      @click:append="show1 = !show1"></v-text-field>
    <v-text-field
      class="mt-2 ml-10 mr-10"
      v-model="registerForm.password_confirmation"
      :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'"
      :type="show2 ? 'text' : 'password'"
      label="パスワード(確認)"
      :rules="passRules"
      counter
      @click:append="show2 = !show2"></v-text-field>
    <div class="mt-3 mb-5 d-flex justify-center">
      <v-btn @click="register" width="300px" color="primary" dark>新規登録</v-btn>
    </div>
  </form>
</template>

<script>
export default {
  data () {
    return {
      show1: false,
      show2: false,
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
      passRules: [
        v => !!v || 'パスワードを入力してください',
      ],
    }
  },
  methods: {
    async register () {
      await this.$store.dispatch('auth/register', this.registerForm)
      this.$router.push('/')
    }
  }
}
</script>